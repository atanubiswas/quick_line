<?php
// app/Http/Controllers/BillingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Bill;
use App\Models\Doctor;
use App\Models\studyType;
use App\Models\caseStudy;
use App\Models\Laboratory;
use App\Models\DoctorBill;
use App\Models\DoctorPriceSetting;
use App\Models\StudyPriceGroup;
use App\Models\StudyCenterPrice;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->roles[0]->name, ['Admin', 'Manager'])) {
                abort(403);
            }
            return $next($request);
        });
    }

    // Show the price management page
    public function index()
    {
        $centers = Laboratory::orderBy('lab_name', 'asc')->get();
        return view('admin.billing.center_prices', compact('centers'));
    }

    // AJAX: Get prices for a center
    public function getCenterPrices(Request $request)
    {
        $centerId = $request->input('center_id');
        $modalityId = $request->input('modality_id');
        $studyTypes = studyType::with('priceGroup')
            ->when($modalityId, function($q) use ($modalityId) {
                $q->where('modality_id', $modalityId);
            })
            ->orderBy('name', 'asc')->get();
        $prices = StudyCenterPrice::where('center_id', $centerId)
            ->when($modalityId, function($q) use ($modalityId) {
                $q->whereHas('studyType', function($q2) use ($modalityId) {
                    $q2->where('modality_id', $modalityId);
                });
            })
            ->get()->keyBy('study_type_id');
        $result = [];
        foreach ($studyTypes as $type) {
            if (isset($prices[$type->id]) && $prices[$type->id]->price_group_id) {
                $priceRow = $prices[$type->id];
                $group = StudyPriceGroup::find($priceRow->price_group_id);
                $result[] = [
                    'study_type_id' => $type->id,
                    'study_type_name' => $type->name,
                    'default_price' => $group->default_price ?? 0,
                    'price' => $priceRow->price,
                    'price_group_id' => $group->id ?? $type->price_group_id,
                    'price_group_name' => $group->name ?? '',
                ];
            } else {
                $result[] = [
                    'study_type_id' => $type->id,
                    'study_type_name' => $type->name,
                    'default_price' => $type->priceGroup->default_price ?? 0,
                    'price' => $type->priceGroup->default_price ?? 0,
                    'price_group_id' => $type->price_group_id,
                    'price_group_name' => $type->priceGroup->name ?? '',
                ];
            }
        }
        return response()->json($result);
    }

    // AJAX: Update prices for a center
    public function updateCenterPrices(Request $request)
    {
        $centerId = $request->input('center_id');
        $prices = $request->input('prices', []);
        foreach ($prices as $item) {
            if (!isset($item['study_type_id']) || !isset($item['price']) || !isset($item['price_group_id'])) continue;
            StudyCenterPrice::updateOrCreate(
                [
                    'center_id' => $centerId,
                    'study_type_id' => $item['study_type_id'],
                ],
                [
                    'price' => $item['price'],
                    'price_group_id' => $item['price_group_id']
                ]
            );
        }
        return response()->json(['success' => true]);
    }

    // Show the Generate Bill page
    public function generateBill(Request $request) {
        $centres = Laboratory::orderBy("lab_name")->get();
        return view('admin.billing.generate_bill', compact('centres'));
    }

    // AJAX endpoint to get bill data for a centre and date range
    public function generateBillData(Request $request) {
        $centreId = $request->input('centre_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        // Example: Fetch case studies for the centre and date range
        $cases = caseStudy::where('laboratory_id', $centreId)
            ->where('study_status_id', 5) // Only finished cases
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['study.type', 'patient'])
            ->get();
        $missingPrice = false;
        $totalAmount = 0;
        $data = collect();
        foreach ($cases as $case) {
            $patientName = $case->patient ? $case->patient->name : '-';
            $patientId = $case->patient ? $case->patient->patient_id : '-';
            $genderAge = $case->patient ? (ucfirst($case->patient->gender) . ' / ' . $case->patient->age) : '-';
            $modality = $case->modality ? $case->modality->name : '-';
            $reportedOn = $case->status_updated_on ? date('d-M-Y', strtotime($case->status_updated_on)) : '-';
            foreach ($case->study as $study) {
                $amount = '-';
                if ($study && $study->type) {
                    $scp = StudyCenterPrice::where('center_id', $centreId)
                        ->where('study_type_id', $study->type->id)
                        ->first();
                    if ($scp) {
                        $amount = $scp->price;
                        $totalAmount += floatval($scp->price);
                    } else {
                        $missingPrice = true;
                    }
                }
                $data->push([
                    'patient_id' => $patientId,
                    'patient_name' => $patientName,
                    'gender_age' => $genderAge,
                    'modality' => $modality,
                    'study_type' => $study && $study->type ? $study->type->name : '-',
                    'date' => $case->created_at ? $case->created_at->format('d-M-Y') : '-',
                    'reported_on' => $reportedOn,
                    'amount' => $amount,
                ]);
            }
        }
        if ($missingPrice) {
            return response()->json(['error' => 'Some studies do not have a price set for this centre. Please update prices in the billing section.']);
        }
        return response()->json(['data' => $data, 'total_amount' => $totalAmount]);
    }

    // AJAX: Get modalities for a center
    public function getLabModalities(Request $request)
    {
        $centerId = $request->input('center_id');
        $modalities = [];
        if ($centerId) {
            $lab = Laboratory::with(['labModality.modality'])->find($centerId);
            if ($lab) {
                foreach ($lab->labModality as $labModality) {
                    if ($labModality->modality) {
                        $modalities[] = [
                            'id' => $labModality->modality->id,
                            'name' => $labModality->modality->name
                        ];
                    }
                }
            }
        }
        return response()->json($modalities);
    }

    // AJAX: Save Bill
    public function saveBill(Request $request)
    {
        $request->validate([
            'centre_id' => 'required|exists:laboratories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'total_study' => 'required|integer',
            'bill_data' => 'required|array',
        ]);

        // Check for duplicate bill for same centre and period
        $exists = Bill::where('centre_id', $request->centre_id)
            ->where('start_date', $request->start_date)
            ->where('end_date', $request->end_date)
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'A bill for this centre and time period already exists.'], 409);
        }

        // Generate unique invoice number
        do {
            $invoiceNumber = 'QL-' . strtoupper(uniqid());
        } while (Bill::where('invoice_number', $invoiceNumber)->exists());

        $bill = Bill::create([
            'centre_id' => $request->centre_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_amount' => $request->total_amount,
            'total_study' => $request->total_study,
            'bill_data' => json_encode($request->bill_data),
            'is_paid' => false,
            'invoice_number' => $invoiceNumber,
        ]);

        return response()->json(['success' => true, 'invoice_number' => $invoiceNumber]);
    }

    // Show the saved bills page
    public function savedBills(Request $request)
    {
        $query = Bill::with('centre');
        if ($request->centre_id) {
            $query->where('centre_id', $request->centre_id);
        }
        if ($request->start_date) {
            $query->where('start_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('end_date', '<=', $request->end_date);
        }
        $bills = $query->orderBy('created_at', 'desc')->get();
        $centres = Laboratory::orderBy('lab_name')->get();
        return view('admin.billing.saved_bills', compact('bills', 'centres'));
    }

    // AJAX: Mark bill as paid/unpaid
    public function markPaid(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'is_paid' => 'required|boolean',
        ]);
        $bill = Bill::findOrFail($request->bill_id);
        $bill->is_paid = $request->is_paid;
        if ($request->is_paid) {
            $bill->paid_by = auth()->id();
        } else {
            $bill->paid_by = null;
        }
        $bill->save();
        return response()->json(['success' => true]);
    }

    // AJAX: Get bill data for modal
    public function getBillData(Request $request)
    {
        $bill = Bill::with('centre')->find($request->bill_id);
        if (!$bill) {
            return response()->json(['success' => false]);
        }
        $billData = json_decode($bill->bill_data, true);
        $html = view('admin.billing.partials.bill_data_modal', compact('bill', 'billData'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    // AJAX: Delete Bill (soft delete)
    public function deleteBill(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
        ]);
        $bill = Bill::findOrFail($request->bill_id);
        $bill->deleted_by = auth()->id();
        $bill->save();
        $bill->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Export bill as PDF using DomPDF
     */
    public function exportPdf(Request $request)
    {
        $centreId = $request->input('centre_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch bill data (reuse your bill generation logic)
        // You may want to move this logic to a service for DRY
        $billDataArr = [];
        $totalAmount = 0;
        $cases = caseStudy::where('laboratory_id', $centreId)
            ->where('study_status_id', 5)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['study.type', 'patient', 'modality'])
            ->get();
        foreach ($cases as $case) {
            $patientName = $case->patient ? $case->patient->name : '-';
            $patientId = $case->patient ? $case->patient->patient_id : '-';
            $genderAge = $case->patient ? (ucfirst($case->patient->gender) . ' / ' . $case->patient->age) : '-';
            $modality = $case->modality ? $case->modality->name : '-';
            $reportedOn = $case->status_updated_on ? date('d-M-Y', strtotime($case->status_updated_on)) : '-';
            foreach ($case->study as $study) {
                $amount = '-';
                if ($study && $study->type) {
                    $scp = StudyCenterPrice::where('center_id', $centreId)
                        ->where('study_type_id', $study->type->id)
                        ->first();
                    if ($scp) {
                        $amount = $scp->price;
                        $totalAmount += floatval($scp->price);
                    }
                }
                $billDataArr[] = [
                    'patient_id' => $patientId,
                    'patient_name' => $patientName,
                    'gender_age' => $genderAge,
                    'modality' => $modality,
                    'study_type' => $study && $study->type ? $study->type->name : '-',
                    'date' => $case->created_at ? $case->created_at->format('d-M-Y') : '-',
                    'reported_on' => $reportedOn,
                    'amount' => $amount,
                ];
            }
        }
        $centre = null;
        if ($centreId) {
            $centre = Laboratory::find($centreId);
        }
        // Try to get a saved bill for this centre and period
        $bill = Bill::where('centre_id', $centreId)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->first();
        $invoice_number = $bill ? $bill->invoice_number : null;
        $invoice_date = $bill ? $bill->created_at : null;
        $pdf = Pdf::loadView('admin.billing.bill_pdf', [
            'billData' => $billDataArr,
            'totalAmount' => $totalAmount,
            'centre' => $centre,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'invoice_number' => $invoice_number,
            'invoice_date' => $invoice_date,
        ]);
        $centreName = $centre ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $centre->lab_name) : 'Centre';
        $fileName = $centreName . '_Bill_' . $startDate . '_to_' . $endDate . '.pdf';
        $fileName = str_replace([' ', '__'], '_', $fileName);
        return $pdf->download($fileName);
    }

    // Show the doctor price management page
    public function doctorPrices()
    {
        $doctors = Doctor::orderBy('name', 'asc')->get();
        return view('admin.billing.doctor_prices', compact('doctors'));
    }

    // AJAX: Get prices for a doctor
    public function getDoctorPrices(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $groups = StudyPriceGroup::orderBy('name', 'asc')->get();
        $prices = DoctorPriceSetting::where('doctor_id', $doctorId)
            ->get()->keyBy('price_group_id');
        $result = [];
        foreach ($groups as $group) {
            $result[] = [
                'price_group_id' => $group->id,
                'price_group_name' => $group->name,
                'default_price' => $group->dr_default_price,
                'price' => isset($prices[$group->id]) ? $prices[$group->id]->price : $group->dr_default_price,
            ];
        }
        return response()->json($result);
    }

    // AJAX: Update prices for a doctor
    public function updateDoctorPrices(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $prices = $request->input('prices', []);
        foreach ($prices as $item) {
            if (!isset($item['price_group_id']) || !isset($item['price'])) continue;
            DoctorPriceSetting::updateOrCreate(
                [
                    'doctor_id' => $doctorId,
                    'price_group_id' => $item['price_group_id'],
                ],
                [
                    'price' => $item['price']
                ]
            );
        }
        return response()->json(['success' => true]);
    }

    // Show the Generate Doctor Bill page
    public function generateDoctorBill(Request $request) {
        $doctors = Doctor::orderBy('name')->get();
        return view('admin.billing.doctor_generate_bill', compact('doctors'));
    }

    // AJAX endpoint to get bill data for a doctor and date range
    public function generateDoctorBillData(Request $request) {
        $doctorId = $request->input('doctor_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $cases = caseStudy::where('doctor_id', $doctorId)
            ->where('study_status_id', 5)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['patient', 'study.type'])
            ->get();
        $missingPrice = false;
        $totalAmount = 0;
        $data = collect();
        foreach ($cases as $case) {
            $patientName = $case->patient ? $case->patient->name : '-';
            $genderAge = $case->patient ? (ucfirst($case->patient->gender) . ' / ' . $case->patient->age) : '-';
            foreach ($case->study as $study) {
                $amount = '-';
                if ($study && $study->type) {
                    $priceSetting = DoctorPriceSetting::where('doctor_id', $doctorId)
                        ->where('price_group_id', $study->type->price_group_id)
                        ->first();
                    if ($priceSetting) {
                        $amount = $priceSetting->price;
                        $totalAmount += floatval($priceSetting->price);
                    } else {
                        $missingPrice = true;
                    }
                }
                $data->push([
                    'case_id' => $case->case_study_id,
                    'patient_name' => $patientName,
                    'gender_age' => $genderAge,
                    'study_type' => $study && $study->type ? $study->type->name : '-',
                    'date' => $case->created_at ? $case->created_at->format('d-M-Y') : '-',
                    'amount' => $amount,
                ]);
            }
        }
        if ($missingPrice) {
            return response()->json(['error' => 'Some studies do not have a price set for this doctor. Please update prices in the doctor billing section.']);
        }
        return response()->json(['data' => $data, 'total_amount' => $totalAmount]);
    }

    // Export doctor bill as PDF
    public function generateDoctorBillPdf(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $doctor = Doctor::find($doctorId);
        $cases = caseStudy::where('doctor_id', $doctorId)
            ->where('study_status_id', 5)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['patient', 'study.type'])
            ->get();
        $missingPrice = false;
        $totalAmount = 0;
        $billDataArr = [];
        foreach ($cases as $case) {
            $patientName = $case->patient ? $case->patient->name : '-';
            $genderAge = $case->patient ? (ucfirst($case->patient->gender) . ' / ' . $case->patient->age) : '-';
            foreach ($case->study as $study) {
                $amount = '-';
                if ($study && $study->type) {
                    $priceSetting = DoctorPriceSetting::where('doctor_id', $doctorId)
                        ->where('price_group_id', $study->type->price_group_id)
                        ->first();
                    if ($priceSetting) {
                        $amount = $priceSetting->price;
                        $totalAmount += floatval($priceSetting->price);
                    } else {
                        $missingPrice = true;
                    }
                }
                $billDataArr[] = [
                    'case_id' => $case->case_study_id,
                    'patient_name' => $patientName,
                    'gender_age' => $genderAge,
                    'study_type' => $study && $study->type ? $study->type->name : '-',
                    'date' => $case->created_at ? $case->created_at->format('d-M-Y') : '-',
                    'amount' => $amount,
                ];
            }
        }
        if ($missingPrice) {
            return back()->with('error', 'Some studies do not have a price set for this doctor. Please update prices in the doctor billing section.');
        }
        // Fetch bill number from doctor_bills table if exists
        $doctorBill = DoctorBill::where('doctor_id', $doctorId)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->first();
        $bill_number = $doctorBill ? $doctorBill->bill_number : null;
        $pdf = Pdf::loadView('admin.billing.doctor_bill_pdf', [
            'billData' => $billDataArr,
            'totalAmount' => $totalAmount,
            'doctor' => $doctor,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'bill_number' => $bill_number,
        ]);
        $doctorName = $doctor ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $doctor->name) : 'Doctor';
        $fileName = $doctorName . '_Bill_' . $startDate . '_to_' . $endDate . '.pdf';
        $fileName = str_replace([' ', '__'], '_', $fileName);
        return $pdf->download($fileName);
    }

    // Save Doctor Bill
    public function saveDoctorBill(Request $request)
    {
        $data = $request->isJson() ? $request->json()->all() : $request->all();
        $validator = \Validator::make($data, [
            'doctor_id' => 'required|exists:doctors,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'total_cases' => 'required|integer',
            'bill_data' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        // Prevent duplicate
        $exists = DoctorBill::where('doctor_id', $data['doctor_id'])
            ->where('start_date', $data['start_date'])
            ->where('end_date', $data['end_date'])
            ->exists();
        if ($exists) {
            return response()->json(['error' => 'A bill for this doctor and time period already exists.'], 409);
        }
        $bill = DoctorBill::create([
            'doctor_id' => $data['doctor_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_amount' => $data['total_amount'],
            'total_cases' => $data['total_cases'],
            'bill_data' => json_encode($data['bill_data']),
            'is_paid' => false,
            'paid_by' => null,
            'bill_number' => $this->generateDoctorBillNumber(),
        ]);
        return response()->json(['success' => true, 'bill_id' => $bill->id]);
    }

    // List saved doctor bills
    public function savedDoctorBills(Request $request)
    {
        $query = DoctorBill::with('doctor');
        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }
        if ($request->start_date) {
            $query->where('start_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->where('end_date', '<=', $request->end_date);
        }
        $bills = $query->orderBy('created_at', 'desc')->get();
        $doctors = Doctor::orderBy('name')->get();
        return view('admin.billing.saved_doctor_bills', compact('bills', 'doctors'));
    }

    // Mark doctor bill as paid/unpaid
    public function markDoctorBillPaid(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:doctor_bills,id',
            'is_paid' => 'required|boolean',
        ]);
        $bill = DoctorBill::findOrFail($request->bill_id);
        $bill->is_paid = $request->is_paid;
        $bill->paid_by = $request->is_paid ? auth()->id() : null;
        $bill->save();
        return response()->json(['success' => true]);
    }

    // Soft delete doctor bill
    public function deleteDoctorBill(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:doctor_bills,id',
        ]);
        $bill = DoctorBill::findOrFail($request->bill_id);
        $bill->delete();
        return response()->json(['success' => true]);
    }

    // Generate unique doctor bill number
    protected function generateDoctorBillNumber()
    {
        do {
            $number = 'QL_DR_' . strtoupper(uniqid());
        } while (DoctorBill::where('bill_number', $number)->exists());
        return $number;
    }

    // Show the quality controller price management page
    public function qualityControllerPrices()
    {
        return view('admin.billing.quality_controller_prices');
    }

    // AJAX: Get list of Quality Controllers
    public function getQualityControllersList()
    {
        $qcRoleId = \DB::table('roles')->where('name', 'Quality Controller')->value('id');
        $qcIds = \DB::table('role_users')->where('role_id', $qcRoleId)->pluck('user_id');
        $qcs = \DB::table('users')->whereIn('id', $qcIds)->select('id', 'name')->orderBy('name')->get();
        return response()->json($qcs);
    }

    // AJAX: Get prices for a quality controller
    public function getQualityControllerPrices(Request $request)
    {
        $userId = $request->input('user_id');
        $groups = StudyPriceGroup::orderBy('name', 'asc')->get();
        $prices = \DB::table('quality_controller_pricings')
            ->where('user_id', $userId)
            ->get()->keyBy('price_group_id');
        $result = [];
        foreach ($groups as $group) {
            $result[] = [
                'price_group_id' => $group->id,
                'price_group_name' => $group->name,
                'default_price' => $group->qc_default_price,
                'price' => isset($prices[$group->id]) ? $prices[$group->id]->price : $group->qc_default_price,
            ];
        }
        return response()->json($result);
    }

    // AJAX: Update prices for a quality controller
    public function updateQualityControllerPrices(Request $request)
    {
        $userId = $request->input('user_id');
        $prices = $request->input('prices', []);
        foreach ($prices as $groupId => $price) {
            \DB::table('quality_controller_pricings')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'price_group_id' => $groupId,
                ],
                [
                    'price' => $price,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
        return response()->json(['success' => true]);
    }
}

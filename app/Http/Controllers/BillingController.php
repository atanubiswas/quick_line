<?php
// app/Http/Controllers/BillingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratory;
use App\Models\studyType;
use App\Models\caseStudy;
use App\Models\StudyCenterPrice;
use App\Models\StudyPriceGroup;
use Illuminate\Support\Facades\Gate;

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
}

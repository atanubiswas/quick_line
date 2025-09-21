<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;

use App\Models\Doctor;
use App\Models\caseStudy;
use App\Models\DoctorBill;
use App\Models\doctorBillPdfJob;
use App\Models\DoctorPriceSetting;

class GenerateDoctorBillPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $doctorId, $startDate, $endDate, $requestedBy;


    /**
     * Create a new job instance.
     */
    public function __construct($doctorId, $startDate, $endDate, $requestedBy)
    {
        $this->doctorId = $doctorId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->requestedBy = $requestedBy;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ini_set('memory_limit', '4096M');
        ini_set('max_execution_time', 1800);

        $doctorId = $this->doctorId;
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        $doctor = Doctor::find($doctorId);

        // ...existing code...

        $totalCases = caseStudy::where('doctor_id', $doctorId)
            ->where('study_status_id', 5)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        $html = '';
        $chunkNumber = 1;
        $processedCases = 0;
        $missingPrice = false;
        $serialOffset = 0;

        // Pre-calculate overall totalAmount and cache doctor's price settings to avoid repeated queries
        $priceSettings = DoctorPriceSetting::where('doctor_id', $doctorId)->get()->keyBy('price_group_id');
        $overallTotalAmount = 0.0;

        // Compute overall total using chunking to avoid loading all cases into memory
        caseStudy::where('doctor_id', $doctorId)
            ->where('study_status_id', 5)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['study.type'])
            ->chunk(500, function ($casesChunk) use (&$overallTotalAmount, $priceSettings, &$missingPrice) {
                foreach ($casesChunk as $case) {
                    foreach ($case->study as $study) {
                        if ($study && $study->type) {
                            $ps = $priceSettings->get($study->type->price_group_id);
                            if ($ps) {
                                $overallTotalAmount += floatval($ps->price);
                            } else {
                                $missingPrice = true;
                            }
                        }
                    }
                }
            });
        

        caseStudy::where('doctor_id', $doctorId)
            ->where('study_status_id', 5)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with(['patient', 'study.type'])
            ->chunk(500, function ($cases) use (&$html, &$chunkNumber, &$missingPrice, $doctor, $startDate, $endDate, $totalCases, &$processedCases, &$serialOffset, $overallTotalAmount, $priceSettings) {
                $billDataArr = [];
                $processedCases += $cases->count();

                foreach ($cases as $case) {
                    $patientName = $case->patient ? $case->patient->name : '-';
                    $genderAge = $case->patient ? (ucfirst($case->patient->gender) . ' / ' . $case->patient->age) : '-';
                    foreach ($case->study as $study) {
                        $amount = '-';
                        if ($study && $study->type) {
                            $ps = $priceSettings->get($study->type->price_group_id);
                            if ($ps) {
                                $amount = $ps->price;
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

                $doctorBill = DoctorBill::where('doctor_id', $doctor->id)
                    ->where('start_date', $startDate)
                    ->where('end_date', $endDate)
                    ->first();
                $bill_number = $doctorBill ? $doctorBill->bill_number : null;

                $isFirstChunk = $chunkNumber === 1;
                $isLastChunk = $processedCases >= $totalCases;

                $html .= view('admin.billing.doctor_bill_pdf', [
                    'billData' => $billDataArr,
                    'totalAmount' => $overallTotalAmount,
                    'doctor' => $doctor,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'bill_number' => $bill_number,
                    'isFirstChunk' => $isFirstChunk,
                    'isLastChunk' => $isLastChunk,
                    'serialOffset' => $serialOffset,
                    'chunkNumber' => $chunkNumber,
                    'totalCases' => $totalCases,
                ])->render();

                // increment serial offset for the next chunk
                $serialOffset += count($billDataArr);

                $chunkNumber++;
            });

        $pdf = Pdf::loadHtml($html);
        $pdf->setPaper('A4', 'portrait');

        $doctorName = $doctor ? preg_replace('/[^A-Za-z0-9_\\-]/', '_', $doctor->name) : 'Doctor';
        $fileName = $doctorName . '_Bill_' . $startDate . '_to_' . $endDate . '.pdf';
        $fileName = str_replace([' ', '__'], '_', $fileName);
        $path = "doctor_bills/{$fileName}";

        // save PDF to storage/app/public/doctor_bills
        Storage::disk('public')->put($path, $pdf->output());

        $exists = Storage::disk('public')->exists($path);
        $urlBase = config('filesystems.disks.public.url') ?? (env('APP_URL') . '/storage');
        $publicUrl = rtrim($urlBase, '/') . '/' . ltrim($path, '/');

        Log::info('GenerateDoctorBillPdfJob PDF saved', [
            'relative_path' => $path,
            'exists_on_disk' => $exists,
            'public_url' => $publicUrl,
        ]);

        $filePathForDb = $publicUrl;
        doctorBillPdfJob::updateOrCreate(
            [
                'doctor_id' => $this->doctorId,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'requested_by' => $this->requestedBy,
                'status' => 'pending',
            ],
            [
                'file_path' => $filePathForDb,
                'status' => 'completed',
            ]
        );
    }

    /**
     * The job failed to process.
     */
    public function failed($exception)
    {
        $message = $exception instanceof \Throwable ? $exception->getMessage() : json_encode($exception);

        Log::error('GenerateDoctorBillPdfJob.failed', [
            'message' => $message,
            'doctorId' => $this->doctorId,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'requestedBy' => $this->requestedBy,
            'status' => 'failed',
        ]);

        doctorBillPdfJob::updateOrCreate(
            [
                'doctor_id' => $this->doctorId,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'requested_by' => $this->requestedBy,
                'status' => 'pending',
            ],
            [
                'file_path' => $message,
                'status' => 'failed',
            ]
        );
    }
}

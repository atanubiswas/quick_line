<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctor Bill PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #e6f2ff; }
        .summary { font-weight: bold; background: #e6f2ff; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    @if($isFirstChunk)
    <div class="header" style="margin-bottom: 20px; display: flex; align-items: flex-start;">
        <table style="width:100%; border:none;">
            <tr>
                <td style="width:33%; text-align:left; vertical-align:middle; border:none;">
                    <table style="margin: 0; font-size: 13px; border:none; width:100%;">
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">Address:</span> 189/22.P.K.Guha Road, Kolkata 700028, West Bengal.</td>
                        </tr>
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">Phone:</span> +91 933 015 7724</td>
                        </tr>
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">Mobile:</span> +91 743 955 4275</td>
                        </tr>
                    </table>
                </td>
                <td style="width:34%; text-align:center; vertical-align:middle; border:none;">
                    @php
                        $logoPath = public_path('images'.DIRECTORY_SEPARATOR.'logo_pdf.png');
                        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                        $logoData = base64_encode(file_get_contents($logoPath));
                        $logoSrc = 'data:image/' . $logoType . ';base64,' . $logoData;
                    @endphp
                    <img src="{{ $logoSrc }}" style="width:120px; height:120px;" alt="Quick Line Logo">
                </td>
                <td style="width:33%; text-align:right; vertical-align:middle; border:none;">
                    <table style="margin: 0 0 0 auto; font-size: 13px; border:none; width:100%;">
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">Email:</span> info@quickline.co.in</td>
                        </tr>
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">Website:</span> https://quickline.in</td>
                        </tr>
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">PAN No:</span> AAACQ8401C</td>
                        </tr>
                        <tr>
                            <td style="border:none; font-weight:normal;"><span style="font-weight: bold;">GST No:</span> 19AAACQ8401C1ZQ</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center; border:none;">
                    <h2 style="margin: 10px 0;">Doctor Bill</h2>
                </td>
            </tr>
        </table>
        <table style="width:100%; border:none;">
            <tr>
                <td width="50%" style="border-top:none; border-right:1px solid #fff; border-bottom:none; boder-left:none; font-size: 14px; font-weight: bold; background-color: #4469BB; color: #ffffff; width:50%;">Pay To</td>
                <td width="50%" style="border:none; font-size: 14px; font-weight: bold; background-color: #4469BB; color: #ffffff; width:50%;">Bill Details</td>
            </tr>
            <tr>
                <td style="vertical-align:top; border:none;">
                    <div><strong>Doctor Name:</strong> {{ $doctor ? $doctor->name : '-' }}</div>
                    <div><strong>Email:</strong> {{ $doctor && isset($doctor->email) ? $doctor->email : '-' }}</div>
                    <div><strong>Phone:</strong> {{ $doctor && isset($doctor->phone) ? $doctor->phone : '-' }}</div>
                </td>
                <td style="vertical-align:top; border:none;">
                    <div><strong>Bill Number:</strong> {{ isset($bill_number) ? $bill_number : '-' }}</div>
                    <div><strong>Total Amount:</strong> {{ number_format($totalAmount, 2) }}</div>
                    <div><strong>Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</div>
                </td>
            </tr>
        </table>
    </div>
    @endif
    <table class="page-break">
        <!-- Chunk: {{ $chunkNumber ?? '?' }}, Offset: {{ $serialOffset ?? 0 }} -->
        <thead>
            <tr>
                <th>#</th>
                <th>Case ID</th>
                <th>Patient Name</th>
                <th>Gender/Age</th>
                <th>Study Type</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billData as $idx => $row)
            <tr>
                <td>{{ ($serialOffset ?? 0) + $loop->iteration }}</td>
                <td>{{ $row['case_id'] }}</td>
                <td>{{ $row['patient_name'] }}</td>
                <td>{{ $row['gender_age'] }}</td>
                <td>{{ $row['study_type'] }}</td>
                <td>{{ $row['date'] }}</td>
                <td>{{ number_format($row['amount'], 2) }}</td>
            </tr>
            @endforeach
            @if($isLastChunk)
            <tr class="summary">
                <td colspan="3">Total Number of Cases</td>
                <td>{{ $totalCases }}</td>
                <td colspan="2">Total Amount</td>
                <td>{{ number_format($totalAmount, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>

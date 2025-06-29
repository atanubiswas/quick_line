<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { margin-bottom: 20px; display: flex; align-items: flex-start; }
        .logo {
            width: 150px;
            height: 150px;
            margin-right: 18px;
        }
        .header-content { flex: 1; }
        .header h2 { margin: 0 0 10px 0; }
        .info-table td { padding: 4px 8px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #e6f2ff; font-size: 13px; }
        .summary-row td { background: #e6f2ff; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header" style="margin-bottom: 20px;">
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
                    <img src="{{ $logoSrc }}" class="logo" alt="Quick Line Logo">
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
                <td colspan="3" style="text-align:center; font-size: 18px; padding-top: 10px; border:none;">
                    <div style="margin-top: 10px;">
                        <table style="font-size:12px; border:none;">
                            <tr>
                                <td width="50%" style="border:none; font-size: 14px; font-weight: bold; background-color: #4469BB; color: #ffffff;">Bill To</td>
                                <td width="50%"  style="border:none; font-size: 14px; font-weight: bold; background-color: #4469BB; color: #ffffff;">Invoice Details</td>
                            </tr>
                            <tr>
                                <td style="border:none; text-align:left; vertical-align:top; padding-top:6px;">
                                    <div><span style="font-weight:bold;">Centre Name:</span> {{ $centre ? $centre->lab_name : '-' }}</div>
                                    <div><span style="font-weight:bold;">Email:</span> {{ $centre && isset($centre->lab_login_email) ? $centre->lab_login_email : '-' }}</div>
                                    <div><span style="font-weight:bold;">Phone:</span> {{ $centre && isset($centre->lab_phone_number) ? $centre->lab_phone_number : '-' }}</div>
                                    <div><span style="font-weight:bold;">Address:</span> {{ $centre && isset($centre->lab_primary_location) ? $centre->lab_primary_location : '-' }}</div>
                                </td>
                                <td style="border:none; text-align:left; vertical-align:top; padding-top:6px;">
                                    <div><span style="font-weight:bold;">Total Amount:</span> {{ number_format($totalAmount, 2) }}</div>
                                    <div><span style="font-weight:bold;">Invoice No:</span> {{ isset($invoice_number) ? $invoice_number : '-' }}</div>
                                    <div><span style="font-weight:bold;">Invoice Date:</span> {{ isset($invoice_date) ? \Carbon\Carbon::parse($invoice_date)->format('d-m-Y') : now()->format('d-m-Y') }}</div>
                                    <div><span style="font-weight:bold;">Period:</span> {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center; font-size: 18px; padding-top: 10px; border:none;">
                    <div style="margin-top: 10px;">
                        <table style="font-size:12px; border:none; width:100%;">
                            <tr>
                                <td width="50%" style="border:none; font-size: 14px; font-weight: bold; background-color: #4469BB; color: #ffffff; width:50%;">Bank Details</td>
                                <td width="50%" style="border:none; font-size: 14px; font-weight: bold; background-color: #4469BB; color: #ffffff; width:50%;">UPI Details</td>
                            </tr>
                            <tr>
                                <td style="border:none; text-align:left; vertical-align:top; padding-top:6px;">
                                    <div style="font-weight:bold;">QUICKLINE PVT.LTD</div>
                                    <div>Bank Name: HDFC BANK</div>
                                    <div>A/C: 50200077855372</div>
                                    <div>IFSC Code: HDFC0000106</div>
                                    <div>Branch: DUM DUM CANTONMENT</div>
                                </td>
                                <td style="border:none; text-align:left; vertical-align:top; padding-top:6px;">
                                    @php
                                        $upiQrPath = public_path('images'.DIRECTORY_SEPARATOR.'hdfc_qr_code.png');
                                        if (file_exists($upiQrPath)) {
                                            $upiQrType = pathinfo($upiQrPath, PATHINFO_EXTENSION);
                                            $upiQrData = base64_encode(file_get_contents($upiQrPath));
                                            $upiQrSrc = 'data:image/' . $upiQrType . ';base64,' . $upiQrData;
                                        } else {
                                            $upiQrSrc = null;
                                        }
                                    @endphp
                                    @if($upiQrSrc)
                                        <img src="{{ $upiQrSrc }}" alt="UPI QR" style="width:120px; height:120px; display:block; margin-bottom:6px;">
                                    @else
                                        <span>No UPI QR</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <td colspan="9" style="text-align:left; font-size: 16px; font-weight: bold; background-color: #4469BB; color: #ffffff;">Itemized Bill</td>
            </tr>
            <tr>
                <th>#</th>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Gender/Age</th>
                <th>Modality</th>
                <th>Study Type</th>
                <th>Date</th>
                <th>Reported On</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($billData as $idx => $row)
                <tr>
                    <td>{{ $idx+1 }}</td>
                    <td>{{ $row['patient_id'] }}</td>
                    <td>{{ $row['patient_name'] }}</td>
                    <td>{{ $row['gender_age'] }}</td>
                    <td>{{ $row['modality'] }}</td>
                    <td>{{ $row['study_type'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['reported_on'] }}</td>
                    <td>{{ is_numeric($row['amount']) ? number_format($row['amount'], 2) : $row['amount'] }}</td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;">No data found.</td></tr>
            @endforelse
            <tr class="summary-row">
                <td colspan="3">Total Number of Study</td>
                <td>{{ count($billData) }}</td>
                <td colspan="2"></td>
                <td colspan="2">Total Amount</td>
                <td>{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <footer style="width:100%; text-align:center; margin-top:40px; font-size:14px; color:#4469BB; font-weight:bold;">
        Thanks for your contribution.
    </footer>
</body>
</html>

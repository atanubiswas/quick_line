<!DOCTYPE html>
<html>
<head>
    <title>Developer Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .developer-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total-row {
            font-weight: bold;
        }
        .bill-info {
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Developer Bill</h2>
    </div>

    <div class="bill-info">
        <p><strong>Bill Number:</strong> {{ $bill_number }}</p>
        <p><strong>Bill Period:</strong> {{ date('d-M-Y', strtotime($startDate)) }} to {{ date('d-M-Y', strtotime($endDate)) }}</p>
        <p><strong>Generated On:</strong> {{ date('d-M-Y') }}</p>
    </div>

    <div class="developer-info">
        <h3>Developer Details:</h3>
        <p><strong>Name:</strong> {{ $developer['name'] }}</p>
        <p><strong>Email:</strong> {{ $developer['email'] }}</p>
        <p><strong>Contact:</strong> {{ $developer['phone'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Case ID</th>
                <th>Patient Name</th>
                <th>Gender/Age</th>
                <th>Date</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billData as $item)
            <tr>
                <td>{{ $item['case_id'] }}</td>
                <td>{{ $item['patient_name'] }}</td>
                <td>{{ $item['gender_age'] }}</td>
                <td>{{ $item['date'] }}</td>
                <td>₹{{ $item['amount'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>Total Amount:</strong></td>
                <td>₹{{ $totalAmount }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This is a computer-generated bill. No signature required.</p>
    </div>
</body>
</html>

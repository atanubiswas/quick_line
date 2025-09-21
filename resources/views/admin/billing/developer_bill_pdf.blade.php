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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Bill Period</th>
                <th>Total Cases</th>
                <th>Per Case</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody id="billTable">
            <tr>
                <td>1</td>
                <td>{{\Carbon\Carbon::parse($startDate)->format('d-M-Y')}} To {{\Carbon\Carbon::parse($endDate)->format('d-M-Y')}}</td>
                <td>{{number_format($totalCase)}}</td>
                <td>{{number_format($pricePerCase, 2)}}</td>
                <td>{{number_format($totalAmount, 2)}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td>{{number_format($totalAmount, 2)}}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This is a computer-generated bill. No signature required.</p>
    </div>
</body>
</html>

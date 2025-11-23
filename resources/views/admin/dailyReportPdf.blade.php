<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daily Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .user-info {
            color: #666;
            margin-top: 10px;
            font-size: 14px;
        }
        .report-date {
            color: #666;
            margin-top: 10px;
            font-size: 14px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 0 0 15px 0;
            font-size: 16px;
            border-left: 4px solid #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .no-data {
            text-align: center;
            color: #999;
            padding: 20px;
            font-style: italic;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .stats-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #28a745;
            flex: 1;
            margin-right: 10px;
        }
        .stat-box:last-child {
            margin-right: 0;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .stat-label {
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Report</h1>
        <div class="user-info">
            <strong>User:</strong> {{ $authUser->name }} ({{ $userRole }})
        </div>
        <div class="report-date">
            @if($startDate === $endDate)
                Report Date: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}
            @else
                Report Period: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
            @endif
        </div>
    </div>

    @if($userRole === 'Assigner')
        <div class="section">
            <h2>Case Assignments by Modality</h2>
            @if(count($assignerData) > 0)
                <div class="stats-row">
                    @php $total = array_sum($assignerData); @endphp
                    <div class="stat-box">
                        <div class="stat-number">{{ $total }}</div>
                        <div class="stat-label">Total Cases Assigned</div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Modality</th>
                            <th>Case Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignerData as $modality => $count)
                            <tr>
                                <td>{{ $modality }}</td>
                                <td>{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">No case assignments for the selected period</div>
            @endif
        </div>

    @elseif($userRole === 'Quality Controller')
        <div class="section">
            <h2>Cases Reviewed by Modality</h2>
            @if(count($qcData) > 0)
                <div class="stats-row">
                    @php $total = array_sum($qcData); @endphp
                    <div class="stat-box">
                        <div class="stat-number">{{ $total }}</div>
                        <div class="stat-label">Total Cases Reviewed</div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Modality</th>
                            <th>Case Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qcData as $modality => $count)
                            <tr>
                                <td>{{ $modality }}</td>
                                <td>{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">No case reviews for the selected period</div>
            @endif
        </div>

    @elseif($userRole === 'Doctor')
        <div class="section">
            <h2>Cases Completed by Modality</h2>
            @if(count($doctorData) > 0)
                <div class="stats-row">
                    @php $total = array_sum($doctorData); @endphp
                    <div class="stat-box">
                        <div class="stat-number">{{ $total }}</div>
                        <div class="stat-label">Total Cases Completed</div>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Modality</th>
                            <th>Case Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctorData as $modality => $count)
                            <tr>
                                <td>{{ $modality }}</td>
                                <td>{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">No cases completed for the selected period</div>
            @endif
        </div>

    @else
        <div class="section">
            <div class="no-data">No data available for your user role</div>
        </div>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('M d, Y H:i:s') }}</p>
    </div>
</body>
</html>

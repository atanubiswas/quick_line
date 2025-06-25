<div>
    <h5>Invoice: {{ $bill->invoice_number }}</h5>
    <p><strong>Centre:</strong> {{ $bill->centre->lab_name ?? '' }}</p>
    <p><strong>Period:</strong> {{ \Carbon\Carbon::parse($bill->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($bill->end_date)->format('d/m/Y') }}</p>
    <p><strong>Total Amount:</strong> {{ number_format($bill->total_amount, 2) }}</p>
    <p><strong>Total Study:</strong> {{ $bill->total_study }}</p>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
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
                @foreach($billData as $row)
                <tr>
                    <td>{{ $row['patient_id'] }}</td>
                    <td>{{ $row['patient_name'] }}</td>
                    <td>{{ $row['gender_age'] }}</td>
                    <td>{{ $row['modality'] }}</td>
                    <td>{{ isset($row['study_type'])?$row['study_type']:"-" }}</td>
                    <td>{{ isset($row['date'])?$row['date']:"-" }}</td>
                    <td>{{ isset($row['reported_on'])?$row['reported_on']:"-" }}</td>
                    <td>@if(isset($row['amount'])){{ is_numeric($row['amount']) ? number_format($row['amount'], 2) : $row['amount'] }}@else - @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mt-2">
            <div class="col-md-6 text-right font-weight-bold">Total Study:</div>
            <div class="col-md-2">{{ $bill->total_study }}</div>
            <div class="col-md-2 text-right font-weight-bold">Total Amount:</div>
            <div class="col-md-2">{{ number_format($bill->total_amount, 2) }}</div>
        </div>
    </div>
</div>

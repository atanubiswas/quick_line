<div class="col-sm-12">
    <table id="transaction_table" class="table table-sm">
        <thead>
            <tr>
                <th style="width: 30%">Details</th>
                <th style="width: 30%">Time</th>
                <th style="width: 20%">Done By</th>
                <th style="width: 10%">Amount</th>
                <th style="width: 10%">Balance</th>
            </tr>
        </thead>
        <tbody>
            @if(count($transactions)>0)
            @foreach($transactions as $transaction)
            <tr>
                <td>
                    @if($transaction->direction == 'Credit')
                    <p class="text-success">{{$transaction->transaction_type}}</p>
                    @else
                    <p class="text-danger">{{$transaction->transaction_type}}</p>
                    @endif
                </td>
                <td>
                    @if($transaction->direction == 'Credit')
                    <p class="text-success"> {{ \Carbon\Carbon::parse($transaction->transaction_date)->isoFormat('Do MMMM, YYYY, hh:mm:ss A') }} </p>
                    @else
                    <p class="text-danger"> {{ \Carbon\Carbon::parse($transaction->transaction_date)->isoFormat('Do MMMM, YYYY, hh:mm:ss A') }} </p>
                    @endif
                </td>
                <td>
                    @if($transaction->direction == 'Credit')
                    <p class="text-success">{{$transaction->transaction_by_data->name}} ({{$transaction->transaction_by_type}})</p>
                    @else
                    <p class="text-danger">{{$transaction->transaction_by_data->name}} ({{$transaction->transaction_by_type}})</p>
                    @endif
                </td>
                <td>
                    @if($transaction->direction == 'Credit')
                    <p class="text-success"><i class="fas fa-rupee-sign"></i> {{number_format($transaction->amount,2)}}</p>
                    @else
                    <p class="text-danger"><i class="fas fa-rupee-sign"></i> -{{number_format($transaction->amount,2)}}</p>
                    @endif
                </td>

                <td><p class="text-info"><i class="fas fa-rupee-sign"></i> {{number_format($transaction->after_amount,2)}}</p></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5"> No Data Found.</td>
            </tr>
            @endif
            <tr>

            </tr>
        </tbody>
    </table>
</div>
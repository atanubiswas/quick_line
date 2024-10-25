<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">View Wallet Transactions for {{$collector->collector_name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>View Transactions</label>
                <select class="form-control" name="view_transactions" id="view_transactions">
                    <option value="last_10" selected="selected">Last 10 Transactions</option>
                    <option value="current_week">Current Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="current_month">Current Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="custom">Custom Date</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="row" id="date_block" style="display: none">
                <div class="col-sm-6">
                    <label>Start Date</label>
                    <input type="text" id="start_date" name="start_date" placeholder="Start Date" class="form-control" placeholder=".col-3">
                </div>
                <div class="col-sm-6">
                    <label>End Date</label>
                    <input type="text" id="end_date" name="end_date" placeholder="End Date" class="form-control" placeholder=".col-3">
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <label>&nbsp;</label>
            <button type="button" data-id="{{$collector->id}}" id="transaction_search_btn" class="btn btn-block bg-gradient-warning"><i class="fas fa-search"></i> Search</button>
        </div>
    </div>
    <div id="transaction_table_div">
        <table id="transaction_table" class="table table-hover">
            <thead>
                <tr>
                    <th>Details</th>
                    <th>Time</th>
                    <th>Done By</th>
                    <th>Amount</th>
                    <th>Balance</th>
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
                        <p class="text-danger"><i class="fas fa-rupee-sign"></i> -{{number_format($transaction->amount, 2)}}</p>
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
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
<script type="text/javascript">
    $(function () {
        flatpickr("#start_date", {
            enableTime: false,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            maxDate: "today"
        });
        flatpickr("#end_date", {
            enableTime: false,
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            maxDate: "today"
        });
        $("#view_transactions").on('change', function () {
            var val = $(this).val();
            if (val === 'custom') {
                $("#date_block").show('slow');
            } else {
                $("#date_block").hide('slow');
            }
        });

        $("#transaction_search_btn").on("click", function () {
            var collector_id = $(this).data('id');
            var transaction_type = $("#view_transactions").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            if (transaction_type === 'custom') {
                if (start_date === '' || end_date === '') {
                    Swal.fire({
                        title: 'Error!',
                        html: 'Please select Start Date & End Date.',
                        icon: 'error',
                        confirmButtonText: 'Close',
                        timer: 10000,
                        timerProgressBar: true
                    });
                    return false;
                }

                if (new Date(start_date) > new Date(end_date)) {
                    Swal.fire({
                        title: 'Error!',
                        html: 'End date cannot be earlier than start date.',
                        icon: 'error',
                        confirmButtonText: 'Close',
                        timer: 10000,
                        timerProgressBar: true
                    });
                    return false;
                }
            }
            var form_data = new FormData();
            form_data.append('collector_id', collector_id);
            form_data.append('transaction_type', transaction_type);
            form_data.append('start_date', start_date);
            form_data.append('end_date', end_date);
            $.ajax({
                url: '{{url("admin/get-transaction-data")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (data) {
                    $('#transaction_table_div').html(data);
                },
                error: function (data) {
                }
            });
        });
    });
</script>
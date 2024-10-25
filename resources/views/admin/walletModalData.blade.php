<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Wallet Balance for {{$collector->collector_name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form name="wallet_balance_form" class="" id="wallet_balance_form">
        <input type="hidden" id="collector_id" name="collector_id" value="{{$collector->id}}" />
        <div class="form-group">
            <label for="wallet_balance_amount">Enter Amount</label>
            <div class="input-group">            
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                </div>
                <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount to add">
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Notes</label>
            <textarea class="form-control" name="notes" id="notes" placeholder="Add Notes"></textarea>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button type="button" id="add_balance_btn" class="btn btn-success">Add Balance</button>
</div>
<script>
    $(function () {
        $("#amount").on("blur", function () {
            var amount = $(this).val();
            if (amount === '') {
                $(this).val('0.00');
            } else if (isNaN(amount)) {
                $(this).val('0.00');
            } else {
                amount = parseFloat(amount);
                $(this).val(amount.toFixed(2));
            }
        });

        $("#add_balance_btn").on("click", function () {
            var amount = $("#amount").val();
            if (isNaN(amount)) {
                amount = parseFloat(0);
            }

            if (amount < 1) {
                $("#amount").focus();
                Swal.fire({
                    title: 'Error!',
                    html: "Enter Amount to add.",
                    icon: 'error',
                    confirmButtonText: 'Close',
                    timer: 10000,
                    timerProgressBar: true
                });
                return false;
            }

            Swal.fire({
                title: "Warning!",
                html: "You are about to add money to the wallet. Once you do this, there is no turning back now. Would you like to continue?",
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Yes",
                denyButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = new FormData();
                    var other_data = $('#wallet_balance_form').serializeArray();
                    $.each(other_data, function (key, input) {
                        form_data.append(input.name, input.value);
                    });
                    $.ajax({
                        url: '{{url("admin/add-wallet-balance")}}',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (data) {
                            if ($.isEmptyObject(data.error)) {
                                printSuccessMsg(data.success);
                                $('#wallet_balance_form').trigger("reset");
                            } else {
                                printErrorMsg(data.error);
                            }
                        },
                        error: function (data) {
                            printErrorMsg("Somthing went wrong! Reload the page.");
                        }
                    });
                } else if (result.isDenied) {
                    return false;
                }
            });
        });
    });
</script>
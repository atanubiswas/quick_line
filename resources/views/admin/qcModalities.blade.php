<div class="modal-header">
    <h4 class="modal-title">Active Modalities of {{ $qcUser->name }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body text-center">
    <div class="form-group">
        <label for="exampleInputEmail1">Modality <em>*</em></label>
        <select class="form-control select2" multiple="multiple" name="qcModalities[]" id="modalitiesSelect">
            @foreach($modalities as $modality)
                <option @if(in_array($modality->id, $qcModalities)) selected="selected" @endif value="{{ $modality->id }}">{{ $modality->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="button" id="update_qc_modalities_btn" data-id="{{ $qcUser->id }}" class="btn btn-warning update_qc_modalities_btn">Update Modalities</button>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>

<script type="text/javascript">
    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Select Modality --',
            templateSelection: function (data, container) {
                $(container).addClass('bg-purple');
                return data.text;
            },
            closeOnSelect: false
        });

        $(document).on('click', '.update_qc_modalities_btn', function () {
            var userId = $(this).data("id");
            var selectedModalities = $('#modalitiesSelect').val();

            $.ajax({
                url: '{{url("admin/edit-qc-modalities")}}',
                type: 'POST',
                data: {
                    user_id: userId,
                    modalities: selectedModalities,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === 'success') {
                        printSuccessMsg(response.message);
                        $('#qcModalitiesModal').modal('hide');
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating modalities.'
                    });
                }
            });
        });
    });
</script>
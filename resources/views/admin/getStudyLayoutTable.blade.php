<table id="study_layout_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Sl. No</th>
            <th>Study Name</th>
            <th>Layout</th>
            <th>Assign To</th>
            <th>Controls</th>
        </tr>
    </thead>
    <tbody>
        @php $count=1; @endphp
        @foreach($studyLayouts as $studyLayout)
            @if($studyLayout->doctor === null)
                @php $doctor = "Global"; @endphp
            @else
                @php $doctor = $studyLayout->doctor->name; @endphp
            @endif
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $studyLayout->studyType->name }}</td>
                <td>{!! $studyLayout->layout !!}</td>
                <td>{{ $doctor }}</td>
                <td>
                    <button type="button" data-id="{{$studyLayout->id}}" class="btn edit_btn btn-block bg-gradient-warning btn-xs"><i class="fas fa-edit"></i> Edit</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#study_layout_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ]
    });

    $("#study_layout_table tbody").on("click", '.edit_btn',function(){
        removePreviousDivElements();
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var lab_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('lab_id', lab_id);

        $.ajax({
            url: '{{url("admin/get-edit-study-layout-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
                $("#edit_study_layout_div").html(data);
                scrollToAnchor("edit_form");
            },
            error: function (data){
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
            }
        });
    });
</script>
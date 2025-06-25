<table id="study_layout_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Sl. No</th>
            <th>Study Name</th>
            <th>Layout Name</th>
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
                <td>{{ $studyLayout->name }}</td>
                <td>{!! $studyLayout->layout !!}</td>
                <td>{{ $doctor }}</td>
                <td>
                    <button type="button" data-id="{{$studyLayout->id}}" class="btn study_layout_edit_btn btn-block bg-gradient-warning btn-xs"><i class="fas fa-edit"></i> Edit</button>
                    <button type="button" data-id="{{$studyLayout->id}}" class="btn delete-layout-btn btn-block btn-danger btn-xs mt-1"><i class="fas fa-trash"></i> Delete</button>
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
</script>
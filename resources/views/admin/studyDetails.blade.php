<table id="study_layout_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="with:20%">Sl. No</th>
            <th>Study Name</th>
        </tr>
    </thead>
    <tbody>
        @php $count=1; @endphp
        @foreach($studies as $study)
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $study->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
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
    });
</script>
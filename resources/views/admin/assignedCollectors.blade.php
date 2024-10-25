<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">View Assigned Collectors for {{$lab->lab_name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div id="assigned_collector_table_div">
        <table id="assigned_collector_table" class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Email</th>
                    <th>Applied On</th>
                    <th>Assigned Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectors as $collector)
                <tr>
                    <td>{{$collector->collector->collector_name}}</td>
                    <td>{{$collector->collector->collector_primary_location}}</td>
                    <td>{{$collector->collector->collector_login_email}}</td>
                    <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $collector->created_at)->isoFormat('Do MMMM YYYY')}}</td>
                    <td><span class="badge  {{$collector->button_type}} " id="status_div_{{$collector->id}}">{{ucwords($collector->status)}}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
<script type="text/javascript">
    $(function () {
        $('#assigned_collector_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]
        });
    });
</script>
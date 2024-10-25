@extends('layouts.admin_layout')
@section('title', "View Pathology Test Data")
@section('extra_css')
<!-- CSS Switch -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{asset('css/css_switch.css')}}">
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$pageName}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$pageName}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">View {{$pageName}} Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="pathology_test_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Test Code</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Sample Type</th>
                                        <th>Normal Range</th>
                                        <th>Units</th>
                                        <th>Turnaround Time</th>
                                        @if($authUser->role->id == 1)
                                        <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pathologyTests as $pathologyTest)
                                    <tr>
                                        <td>{{$pathologyTest->test_name}}</td>
                                        <td>{{$pathologyTest->test_code}}</td>
                                        <td>{{$pathologyTest->pathlogyTestCategory->category_name}}</td>
                                        <td>{{$pathologyTest->description}}</td>
                                        <td>{{$pathologyTest->price}}</td>
                                        <td>{{$pathologyTest->sample_type}}</td>
                                        <td>{{$pathologyTest->normal_range}}</td>
                                        <td>{{$pathologyTest->units}}</td>
                                        <td>{{$pathologyTest->turnaround_time}}</td>
                                        @if($authUser->role->id == 1)
                                        <td><button type="button" data-id="{{$pathologyTest->id}}" class="btn edit_btn btn-block bg-gradient-info btn-xs"><i class="fas fa-edit"></i> Edit</button></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row" id="edit_collector_div">

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="addWalletBalanceModal" tabindex="-1" role="dialog" aria-labelledby="addWalletBalanceModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="modal-content-wallet_balance">
      
    </div>
  </div>
</div>

<div class="modal fade " id="viewTransactionsModal" tabindex="-1" role="dialog" aria-labelledby="viewTransactionsModal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content" id="modal-content-view-transactions">
      
    </div>
  </div>
</div>
@endsection

@section("extra_js")
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(function () {
    $('#pathology_test_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]
    });

    $(".edit_btn").on("click", function () {
        $(this).html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var pathology_test_id = $(this).data("id");
        var form_data = new FormData();
        form_data.append('pathology_test_id', pathology_test_id);

        $.ajax({
            url: '{{url("admin/get-edit-pathology-test")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $(".edit_btn").html('<i class="fas fa-edit"></i> Edit');
                $("#edit_collector_div").html(data);
                scrollToAnchor("edit_form");
            },
            error: function (data) {
                printErrorMsg("Somthing went wrong! Reload the page.");
            }
        });
    });
});
</script>
@endsection
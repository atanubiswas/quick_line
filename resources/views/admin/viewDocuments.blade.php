@extends('layouts.admin_layout')
@section('title', "View Uploaded Documents")
@section('extra_css')
<!-- CSS Switch -->
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
                            <h3 class="card-title">{{$pageName}} Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="document_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>Document Number</th>
                                        <th>Front Image</th>
                                        <th>Back Image</th>
                                        <th>St. Date</th>
                                        <th>En. Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                    <tr class="@if($document->status == 2) bg-danger @endif">
                                        <td>{{$document->document_type}}</td>
                                        <td>{{$document->document_number}}</td>
                                        <td><img src="{{asset($document->document_front_image)}}" alt="Document Front Image" width="150px" /></td>
                                        <td>@if(empty($document->document_back_image)) N/A @else <img src="{{asset($document->document_back_image)}}" alt="Document Back Image" width="150px" /> @endif</td>
                                        <td>{{$document->st_dt}}</td>
                                        <td>{{$document->en_dt}}</td>
                                        <td><span class="badge @if($document->status == 0) bg-warning @elseIf($document->status == 1) bg-success @else bg-danger @endif">{{$document->doc_status}}</span></td>
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
            <div class="row" id="edit_lab_div">
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
<script>
$(function () {
    $('#document_table').DataTable({
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
@endsection
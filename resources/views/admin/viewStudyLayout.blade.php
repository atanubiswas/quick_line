@extends('layouts.admin_layout')
@section('title', "View Users")
@section('extra_css')
<!-- CSS Switch -->
<link rel="stylesheet" href="{{asset('css/css_switch.css')}}">
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
<!--Plugin CSS file with desired skin-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
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
                    <div class="card card-purple">
                        <div class="card-header">
                            <h3 class="card-title">View {{ $pageName }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
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
<!--Plugin JavaScript file-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script>
$(function () {
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
});
</script>
@endsection
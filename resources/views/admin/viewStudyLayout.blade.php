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
<!-- summernote -->
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
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
            <div class="row" id="view_card">
                <div class="col-12">
                    <div class="card card-purple">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="card-title">View {{ $pageName }}</h3>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select class="form-control select2 modality" required="required" name="modality" id="modality">
                                            <option value="">Select Modality</option>
                                            @foreach($modalityes as $modality)
                                            <option value="{{$modality->id}}">{{$modality->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <select class="form-control select2 study" required="required" name="study" id="study">
                                            <option value="">Select Study</option>
                                        </select>
                                        <button type="button" style="margin-left:10px;" class="btn bg-gradient-orange float-right" id="search_btn" name="search_btn">Search</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ Route('admin.addStudyLayout') }}" class="btn bg-gradient-success float-right" id="add_btn" name="add_btn">Add Study Layout</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" id="card-body-main">
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
            <div class="row" id="edit_study_layout_div">
                
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
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    $(document).on("change", ".modality", function(){
        var modality = $(this).val();
        if(modality != ""){
            $.ajax({
                url: "{{url('admin/get-study-layout')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "modality": modality
                },
                success: function(data){
                    $(".study").html(data);
                }
            });
        }else{
            $(".study").html("<option value=''>Select Study</option>");
        }
    });

    $("#search_btn").on("click", function(){
        let modality = $("#modality").val();
        let study = $("#study").val();
        $.ajax({
            url: "{{url('admin/get-study-layout-table')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "modality": modality,
                "study" : study
            },
            success: function(data){
                console.log(data);
                $("#card-body-main").html(data);
            },
            error: function(data){
                $("#card-body-main").html('');
            }
        });
    });

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

    $(document).on("click", ".study_layout_edit_btn", function(){
        const thisButton = $(this);
        thisButton.html('Opening <i class="fas fa-spinner fa-spin"></i>');
        var study_layout_id = $(this).data("id");
        var modality = $("#modality").val();
        var study = $("#study").val();
        var form_data = new FormData();
        form_data.append('study_layout_id', study_layout_id);
        form_data.append('modality', modality);
        form_data.append('study', study);

        $.ajax({
            url: '{{url("admin/get-edit-study-layout-data")}}',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                thisButton.html('<i class="fas fa-edit"></i> Edit');
                $("#edit_study_layout_div").html(data);
                scrollToAnchor("edit_layout_form");
            },
            error: function (data){
                thisButton.html('<i class="fas fa-edit"></i> Edit');
            }
        });
    });

    $(document).on("click", ".delete-layout-btn", function() {
        var btn = $(this);
        var id = btn.data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this Study Layout.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).html('Deleting...');
                $.ajax({
                    url: '{{ route("admin.deleteStudyLayout") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(res) {
                        if(res.success) {
                            btn.closest('tr').fadeOut();
                            Swal.fire('Deleted!', 'Study Layout has been deleted.', 'success');
                        } else {
                            Swal.fire('Error', 'Delete failed!', 'error');
                            btn.prop('disabled', false).html('<i class="fas fa-trash"></i> Delete');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Delete failed!', 'error');
                        btn.prop('disabled', false).html('<i class="fas fa-trash"></i> Delete');
                    }
                });
            }
        });
    });
});
</script>
@endsection
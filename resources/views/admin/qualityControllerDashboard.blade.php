@extends('layouts.admin_layout')
@section('title', 'Dashboard')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $totalCaseThisMonth }}</h3>
              <p>Total Case This Month</p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-alt"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $todayCaseCount }}</h3>
              <p>Total Case Today</p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-check"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $currentActiveCase }}</h3>
              <p>Current Active Case</p>
            </div>
            <div class="icon">
              <i class="fas fa-hand-holding-medical"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $currentEmergencyCase }}</h3>
              <p>Current Emergency Case</p>
            </div>
            <div class="icon">
              <i class="fas fa-info-circle"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Date Picker Block -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="card card-purple">
              <div class="card-header">
                <h3 class="card-title">Download Daily Report</h3>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-md-5">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                  </div>
                  <div class="col-md-5">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                  </div>
                  <div class="col-md-2 align-self-end">
                    <button id="download_daily_report" class="btn btn-success">Download Report</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- /.Date Picker Block -->
      <!-- Case Study DataTable -->
      <div class="case-study-table-container">
        @include("admin.doctorCSTableDashboard")
      </div>
        
      @section('extra_js')
      <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
      <script>
        $(function () {
          $('#case_study_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "order": [[ 3, "desc" ]],
          });

          var startDateVal = '{{ $startDate }}';
          var endDateVal = '{{ $endDate }}';

          $('#daterange').daterangepicker({
              startDate: startDateVal ? moment(startDateVal, 'YYYY-MM-DD') : moment(),
              endDate: endDateVal ? moment(endDateVal, 'YYYY-MM-DD') : moment(),
              maxDate: moment(),
              applyButtonClasses: 'btn bg-gradient-purple',
              cancelButtonClasses: 'btn bg-gradient-danger',
              locale: {
                  format: 'DD/MM/YYYY'
              }
          }, function(start, end, label) {
              $('#start_date').val(start.format('YYYY-MM-DD'));
              $('#end_date').val(end.format('YYYY-MM-DD'));
          });

          $(document).on('click', '#dashboard_search_btn', function() {
            var btn = $(this);
            btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            if (startDate && endDate) {
                $.ajax({
                    url: "{{ route('admin.getCaseStudyDataDashboard') }}",
                    type: 'POST',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                      btn.html('Search').prop('disabled', false);
                        $('.case-study-table-container').html(response);
                        $('#case_study_table').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "order": [[ 3, "desc" ]],
                        });
                        $('#daterange').daterangepicker({
                          startDate: startDateVal ? moment(startDateVal, 'YYYY-MM-DD') : moment(),
                          endDate: endDateVal ? moment(endDateVal, 'YYYY-MM-DD') : moment(),
                          maxDate: moment(),
                          applyButtonClasses: 'btn bg-gradient-purple',
                          cancelButtonClasses: 'btn bg-gradient-danger',
                          locale: {
                              format: 'DD/MM/YYYY'
                          }
                      }, function(start, end, label) {
                          $('#start_date').val(start.format('YYYY-MM-DD'));
                          $('#end_date').val(end.format('YYYY-MM-DD'));
                      });
                    },
                    error: function(xhr, status, error) {
                      btn.html('Search').prop('disabled', false);
                      printErrorMsg(xhr.responseJSON.errors);
                    }
                });
            } else {
                alert('Please select a valid date range.');
            }
          });

          $('#download_daily_report').on('click', function(){
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            if(startDate > endDate){
              alert('Start Date cannot be greater than End Date.');
              return;
            }
            var url = "{{ route('admin.downloadDailyReport') }}" + "?start_date=" + startDate + "&end_date=" + endDate;
            window.location.href = url;
          });
        });
      </script>
      @endsection
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
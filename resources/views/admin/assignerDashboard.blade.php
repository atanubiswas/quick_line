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
              <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">

          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $todayCaseCount }}</h3>
              <p>Total Case Today</p>
            </div>
            <div class="icon">
              <i class="fas fa-calendar-check"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">

          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $activeCaseCount }}</h3>
              <p>Active Cases</p>
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
              <p>Emergency Cases</p>
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
      @section('extra_js')
        <script>
          $(document).ready(function(){
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
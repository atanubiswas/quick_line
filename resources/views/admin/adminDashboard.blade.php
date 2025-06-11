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
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $totalCaseThisMonth }}</h3>
              <p>Total Case This Month</p>
            </div>
            <div class="icon">
              <i class="fa fa-notes-medical"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">

          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $topCentreThisMonth['count'] }}<span> (Top Centre)</span></h3>
              <p>{{ $topCentreThisMonth['name'] }}</p>
            </div>
            <div class="icon">
              <i class="fas fa-flask"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">

          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $topQCThisMonth['count'] }}<span> (Top QC)</span></h3>
              <p>{{ $topQCThisMonth['name'] }}</p>
            </div>
            <div class="icon">
              <i class="fas fa-vials"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">

          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $topDoctorThisMonth['count'] }}<span> (Top Doctor)</span></h3>
              <p>{{ $topDoctorThisMonth['name'] }}</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-md"></i>
            </div>
            <a href="{{ route('admin.viewCaseStudy') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>
      <!-- /.row -->
      <!-- Date Picker Block -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Filter by Date Range</h3>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="start_date">Start Date:</label>
                  <input type="date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                  <label for="end_date">End Date:</label>
                  <input type="date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Date Picker Block -->
      <!-- Assigner Case Assignment Table -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Assigner Case Assignment Count</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="assigner_count_table">
                  <thead>
                    <tr>
                      <th>Assigner Name</th>
                      <th>Assigned Case Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($assignerCounts as $assigner)
                      <tr>
                        <td>{{ $assigner->name }}</td>
                        <td>{{ $assigner->count }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Assigner Table -->
      <!-- Quality Controller Case Assignment Table -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">Quality Controller Case Assignment Count</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="qc_count_table">
                  <thead>
                    <tr>
                      <th>Quality Controller Name</th>
                      <th>Assigned Case Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($qcCounts as $qc)
                      <tr>
                        <td>{{ $qc->name }}</td>
                        <td>{{ $qc->count }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Quality Controller Table -->
      <!-- Doctor Case Assignment Table -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Doctor Case Completed Count</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="doctor_count_table">
                  <thead>
                    <tr>
                      <th>Doctor Name</th>
                      <th>Assigned Case Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($doctorCounts as $doctor)
                      <tr>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->count }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Doctor Table -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
@section('extra_js')
@parent
<script>
$(document).ready(function() {
    function fetchAssignerCounts() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $.ajax({
            url: '{{ route('admin.assignerCounts') }}',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            success: function(data) {
                var tbody = '';
                data.forEach(function(assigner) {
                    tbody += '<tr><td>' + assigner.name + '</td><td>' + assigner.count + '</td></tr>';
                });
                $('#assigner_count_table tbody').html(tbody);
            }
        });
    }
    function fetchQCCounters() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $.ajax({
            url: '{{ route('admin.qcCounts') }}',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            success: function(data) {
                var tbody = '';
                data.forEach(function(qc) {
                    tbody += '<tr><td>' + qc.name + '</td><td>' + qc.count + '</td></tr>';
                });
                $('#qc_count_table tbody').html(tbody);
            }
        });
    }
    function fetchDoctorCounters() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $.ajax({
            url: '{{ route('admin.doctorCounts') }}',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            success: function(data) {
                var tbody = '';
                data.forEach(function(doctor) {
                    tbody += '<tr><td>' + doctor.name + '</td><td>' + doctor.count + '</td></tr>';
                });
                $('#doctor_count_table tbody').html(tbody);
            }
        });
    }
    function fetchAllCounters() {
        fetchAssignerCounts();
        fetchQCCounters();
        fetchDoctorCounters();
    }
    $('#start_date, #end_date').on('change', fetchAllCounters);
    // Ensure future dates are disabled and end date is not before start date
    $('#start_date').on('change', function() {
        var startDate = $(this).val();
        var endDate = $('#end_date').val();
        // If start date is after end date, set end date to start date
        if (startDate > endDate) {
            $('#end_date').val(startDate);
        }
        // Set min for end_date to start_date
        $('#end_date').attr('min', startDate);
    });
    // On page load, set min for end_date
    $('#end_date').attr('min', $('#start_date').val());
    // Initial load
    fetchAllCounters();
});
</script>
@endsection
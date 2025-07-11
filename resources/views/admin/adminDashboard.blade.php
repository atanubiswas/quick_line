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
          <div class="card card-purple">
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
              <!-- Line Chart for Assigner Daily Counts -->
              <div class="mt-4">
                <!-- <canvas id="assigner_line_chart" height="100"></canvas> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Assigner Table & Chart -->
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
              <!-- Line Chart for QC Daily Counts -->
              <div class="mt-4">
                <!-- <canvas id="qc_line_chart" height="100"></canvas> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Quality Controller Table & Chart -->
      <!-- Doctor Case Assignment Table -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Doctor Case Completed Count (by Study Price Group)</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="doctor_count_table">
                  <thead>
                    <tr>
                      <th>Doctor Name</th>
                      @foreach($studyPriceGroups as $group)
                        <th>{{ $group }}</th>
                      @endforeach
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($doctorCounts as $doctor)
                      <tr>
                        <td>{{ $doctor['name'] }}</td>
                        @foreach($studyPriceGroups as $group)
                          <td>{{ $doctor['groups'][$group] ?? 0 }}</td>
                        @endforeach
                        <td>{{ array_sum($doctor['groups']) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- Line Chart for Doctor Daily Counts -->
              <div class="mt-4">
                <!-- <canvas id="doctor_line_chart" height="100"></canvas> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Doctor Table & Chart -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
@section('extra_js')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                // Get study price groups from the table header
                var groupNames = [];
                $('#doctor_count_table thead th').each(function(i, th) {
                    var name = $(th).text().trim();
                    if (name !== 'Doctor Name' && name !== 'Total') {
                        groupNames.push(name);
                    }
                });
                var tbody = '';
                data.forEach(function(doctor) {
                    var row = '<tr><td>' + doctor.name + '</td>';
                    var total = 0;
                    groupNames.forEach(function(group) {
                        var val = (doctor.groups && doctor.groups[group]) ? doctor.groups[group] : 0;
                        row += '<td>' + val + '</td>';
                        total += parseInt(val, 10);
                    });
                    row += '<td>' + total + '</td></tr>';
                    tbody += row;
                });
                $('#doctor_count_table tbody').html(tbody);
            }
        });
    }
    var assignerLineChart = null;
    var qcLineChart = null;
    var doctorLineChart = null;
    function fetchAssignerLineChart() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $.ajax({
            url: '{{ route('admin.assignerDailyCounts') }}',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            success: function(resp) {
                var ctx = document.getElementById('assigner_line_chart').getContext('2d');
                var labels = resp.dates.map(function(dateStr) {
                    var d = new Date(dateStr);
                    var yy = String(d.getFullYear()).slice(-2);
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                  'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var month = months[d.getMonth()];
                    var dd = ('0' + d.getDate()).slice(-2);
                    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    var day = days[d.getDay()];
                    return dd + '-' + month + ' (' + day + ')';
                });
                var datasets = resp.series.map(function(assigner, idx) {
                    var color = getColor(idx);
                    return {
                        label: assigner.name,
                        data: assigner.data,
                        borderColor: color,
                        backgroundColor: color + '33',
                        fill: false,
                        tension: 0.2
                    };
                });
                if(assignerLineChart) assignerLineChart.destroy();
                assignerLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Assigner Daily Assignment Count' }
                        },
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, precision: 0 }
                        }
                    }
                });
            }
        });
    }
    function fetchQCLineChart() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $.ajax({
            url: '{{ route('admin.qcDailyCounts') }}',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            success: function(resp) {
                var ctx = document.getElementById('qc_line_chart').getContext('2d');
                var labels = resp.dates.map(function(dateStr) {
                    var d = new Date(dateStr);
                    var yy = String(d.getFullYear()).slice(-2);
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                  'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var month = months[d.getMonth()];
                    var dd = ('0' + d.getDate()).slice(-2);
                    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    var day = days[d.getDay()];
                    return dd + '-' + month + ' (' + day + ')';
                });
                var datasets = resp.series.map(function(qc, idx) {
                    var color = getColor(idx);
                    return {
                        label: qc.name,
                        data: qc.data,
                        borderColor: color,
                        backgroundColor: color + '33',
                        fill: false,
                        tension: 0.2
                    };
                });
                if(qcLineChart) qcLineChart.destroy();
                qcLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'QC Daily Assignment Count' }
                        },
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, precision: 0 }
                        }
                    }
                });
            }
        });
    }
    function fetchDoctorLineChart() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $.ajax({
            url: '{{ route('admin.doctorDailyCounts') }}',
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            success: function(resp) {
                var ctx = document.getElementById('doctor_line_chart').getContext('2d');
                var labels = resp.dates.map(function(dateStr) {
                    var d = new Date(dateStr);
                    var yy = String(d.getFullYear()).slice(-2);
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                  'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var month = months[d.getMonth()];
                    var dd = ('0' + d.getDate()).slice(-2);
                    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    var day = days[d.getDay()];
                    return dd + '-' + month + ' (' + day + ')';
                });
                var datasets = resp.series.map(function(doctor, idx) {
                    var color = getColor(idx);
                    return {
                        label: doctor.name,
                        data: doctor.data,
                        borderColor: color,
                        backgroundColor: color + '33',
                        fill: false,
                        tension: 0.2
                    };
                });
                if(doctorLineChart) doctorLineChart.destroy();
                doctorLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Doctor Daily Assignment Count' }
                        },
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, precision: 0 }
                        }
                    }
                });
            }
        });
    }
    // Helper to get color for each line
    function getColor(idx) {
        var colors = [
            '#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997', '#e83e8c', '#343a40'
        ];
        return colors[idx % colors.length];
    }
    function fetchAllCounters() {
        fetchAssignerCounts();
        fetchQCCounters();
        fetchDoctorCounters();
        fetchAssignerLineChart();
        fetchQCLineChart();
        fetchDoctorLineChart();
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
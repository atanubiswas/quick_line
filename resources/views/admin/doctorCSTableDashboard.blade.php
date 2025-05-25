<div class="card card-purple mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-9">
                <h3 class="card-title">Case Studies</h3>
            </div>
            <div class="col-md-3 text-right">
                <div class="input-group">
                    <input type="text" id="daterange" class="form-control daterange" data-target="#datepicker"/>
                    <input type="hidden" id="start_date" name="start_date" value="{{ Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                    <input type="hidden" id="end_date" name="end_date" value="{{ Carbon\Carbon::now()->endOfDay()->format('Y-m-d') }}">
                    <button style="margin-left: 10px;" type="button" id="dashboard_search_btn" name="search_btn" class="btn bg-gradient-orange float-right btn-sm">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="case_study_table" class="table table-bordered table-hover">
        <thead>
            <tr>
            <th>Case ID</th>
            <th>Patient Name</th>
            <th>Age / Gender</th>
            <th>Date</th>
            <th>Status</th>
            <th>Studies</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caseStudyList as $caseStudy)
            <tr>
            <td>{{ $caseStudy->case_study_id }}</td>
            <td>{{ $caseStudy->patient->name ?? '-' }}</td>
            <td>
                {{ $caseStudy->patient->age ?? '-' }} / 
                {{ $caseStudy->patient->gender}}
            </td>
            <td data-order="{{ $caseStudy->created_at }}">{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('jS M Y, g:i a') }}</td>
            <td><span class="badge bg-gradient-info">{{ $caseStudy->status->name ?? '-' }}</span></td>
            <td>
                @foreach($caseStudy->study as $study)
                    {{ $study->type->name }}@if(!$loop->last), @endif
                @endforeach
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>

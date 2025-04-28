<div class="print_block">
@php $count = 1; @endphp
  @foreach($caseStudy->study as $study)
    <div style="margin: {{ $top }} {{ $right }} {{ $bottom }} {{ $left }};">
      <table style="border-collapse: collapse; width: 100%;">
        <tr>
          <th style="border: 1px solid black; padding: 4px;">Patient Name:</th>
          <th style="border: 1px solid black; padding: 4px;">{{ $caseStudy->patient->name }}</th>
          <th style="border: 1px solid black; padding: 4px;">Age / Gender:</th>
          <th style="border: 1px solid black; padding: 4px;">{{ $caseStudy->patient->age }} / {{ ucwords($caseStudy->patient->gender) }}</th>
        </tr>
        <tr>
          <th style="border: 1px solid black; padding: 4px;">Patient Id:</th>
          <th style="border: 1px solid black; padding: 4px;">{{ $caseStudy->patient->patient_id }}</th>
          <th style="border: 1px solid black; padding: 4px;">Date & Time:</th>
          <th style="border: 1px solid black; padding: 4px;">{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('jS \o\f M Y, h:i A')}}</th>
        </tr>
        <tr>
          <th style="border: 1px solid black; padding: 4px;">Refd By:</th>
          <th style="border: 1px solid black; padding: 4px;">{{ $caseStudy->ref_by }}</th>
          <th style="border: 1px solid black; padding: 4px;">Study:</th>
          <th style="border: 1px solid black; padding: 4px;">{{ $study->type->name }}</th>
        </tr>
      </table>

      <div class="main_study_result" style="margin-top: 30px;" id="main_study_result_{{ $study->id }}">
        {!! $study->report !!}
      </div>

      <div style="width:100%; padding-top: 50px;">
        <!-- Left: Signature + Doctor Info (60%) -->
        <div style="width: 50%; display: inline-block;">
          <img src="{{$signature}}" alt="Doctor Signature" style="width: 100%; max-width: 250px; margin-bottom: 10px;">
          <p style="margin: 0; font-size: 14px; line-height: 1.5;">
            <strong style="font-size: 18px;">Doctor {{ $caseStudy->doctor->name }}</strong><br>
            <strong>{{ $doctorQualification->value }}</strong><br>
            @if(isset($registrationNumber->value))
              <strong>{{ $registrationNumber->value }}</strong><br>
            @endif
          </p>
        </div>

        <!-- Right: QR Code with Dashed Border -->
        <div style="width: 40%; display: inline-block;">
          <div style="">
            <img src="{{ $qrLocalPath }}" alt="QR Code" style="width: 100px; height: 100px;">
          </div>
        </div>
      </div>

      <div style="text-align: center; margin: 0 auto; width: 100%; font-family: Arial, sans-serif;">
              @php echo str_repeat('-', 20); @endphp
              <strong> &nbsp;&nbsp;End Of Report&nbsp;&nbsp; </strong>
              @php echo str_repeat('-', 20); @endphp
      </div>
      <p style="font-size: 14px; margin-top: 20px;"><strong>Disclaimer</strong>: The science of radiology is based upon interpretation of shadows of normal and abnormal 
      tissue. This is neither complete nor accurate; hence, findings should always be interpreted in to the light of 
      clinico-pathological correlation. This is a professional opinion, not a diagnosis. Not meant for medico 
      legal purposes.</p>
      @if(count($caseStudy['study'])>$count++)
        <div style="page-break-before: always;"></div>
      @endif
    </div>
  @endforeach
</div>
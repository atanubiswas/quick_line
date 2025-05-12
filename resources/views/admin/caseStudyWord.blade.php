<html>
  <head></head>
  <body>
      @php $count = 1; @endphp
      @foreach($caseStudy->study as $study)
        <table style="border-collapse: collapse; width: 100%;">
          <tr>
            <th width="300" style="border: 1px solid black; padding: 4px;">Patient Name:</th>
            <th style="border: 1px solid black; padding: 4px;">{{ ucwords($caseStudy->patient->name) }}</th>
            <th style="border: 1px solid black; padding: 4px;">Age / Gender:</th>
            <th style="border: 1px solid black; padding: 4px;">{{ $caseStudy->patient->age }} / {{ ucwords($caseStudy->patient->gender) }}</th>
          </tr>
          <tr>
            <th style="border: 1px solid black; padding: 4px;">Patient Id:</th>
            <th style="border: 1px solid black; padding: 4px;">{{ $caseStudy->patient->patient_id }}</th>
            <th style="border: 1px solid black; padding: 4px;">Date and Time:</th>
            <th style="border: 1px solid black; padding: 4px;">{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('jS \o\f M Y, h:i A')}}</th>
          </tr>
          <tr>
            <th style="border: 1px solid black; padding: 4px;">Refd By:</th>
            <th style="border: 1px solid black; padding: 4px;">{{ ucwords($caseStudy->ref_by) }}</th>
            <th style="border: 1px solid black; padding: 4px;">Study:</th>
            <th style="border: 1px solid black; padding: 4px;">{{ $study->type->name }}</th>
          </tr>
        </table>

        <div class="main_study_result" style="margin-top: 30px;" id="main_study_result_{{ $study->id }}">
          {!! $study->report !!}
        </div>
        
        <table style="width: 100%; margin-top: 20px;">
          <tr>
            <td style="width: 50%; vertical-align: top;">
                @php
                    $signaturePath = public_path('storage/' . $caseStudy->doctor->signature);
                    $signatureBase64 = '';
                    if (file_exists($signaturePath)) {
                        $imageType = pathinfo($signaturePath, PATHINFO_EXTENSION);
                        $imageData = file_get_contents($signaturePath);
                        $signatureBase64 = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
                    }
                @endphp

                @if($signatureBase64)
                  <img src="{{ $signatureBase64 }}" alt="Doctor Signature" width="200" />
                @endif
              <p style="margin: 0; font-size: 14px; line-height: 1.5;">
                <strong style="font-size: 18px;">{{ $caseStudy->doctor->name }}</strong><br/>
                <strong>{{ $doctorQualification->value }}</strong><br/>
                @if(isset($registrationNumber->value))
                  <strong>{{ $registrationNumber->value }}</strong><br/>
                @endif
              </p>
            </td>
            <td style="width: 50%; vertical-align: top; text-align: left;">
                @php
                // QR Code Image Conversion to Base64
                $qrPath = $qrLocalPath;
                $qrBase64 = '';
                if (file_exists($qrPath)) {
                    $imageType = pathinfo($qrPath, PATHINFO_EXTENSION);
                    $imageData = file_get_contents($qrPath);
                    $qrBase64 = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
                }
                @endphp
                @if($qrBase64)
                  <img src="{{ $qrBase64 }}" alt="QR Code" width="150" />
                @endif
            </td>
          </tr>
        </table>

        <div style="width:100%;margin: 50px 0;">
            <div style="text-align: center;">
                @php echo str_repeat('-', 100); @endphp
                <strong> &nbsp;&nbsp;End Of Report&nbsp;&nbsp; </strong>
                @php echo str_repeat('-', 100); @endphp
            </div>
        </div>
        <p style="font-size: 14px; margin-top: 20px;"><strong>Disclaimer</strong>: The science of radiology is based upon interpretation of shadows of normal and abnormal tissue. This is neither complete nor accurate; hence, findings should always be interpreted in to the light of clinico-pathological correlation. This is a professional opinion, not a diagnosis. Not meant for medico legal purposes.</p>
      @endforeach
  </body>
</html>
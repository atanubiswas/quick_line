<html>
  <head></head>
  <body>
      @php $count = 1; @endphp
      @foreach($caseStudy->study as $study)
        <table style="border-collapse: collapse; width: 100%; table-layout: fixed;" border="1">
          <tr>
              <th style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">Patient Name:</th>
              <td style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">{{ ucwords($caseStudy->patient->name) }}</td>
              <th style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">Age / Gender:</th>
              <td style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">{{ $caseStudy->patient->age }} / {{ ucwords($caseStudy->patient->gender) }}</td>
          </tr>
          <tr>
              <th style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">Patient ID:</th>
              <td style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">{{ $caseStudy->patient->patient_id }}</td>
              <th style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">Date and Time:</th>
              <td style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('d/m/y g:i a') }}</td>
          </tr>
          <tr>
              <th style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">Refd By:</th>
              <td style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">{{ ucwords($caseStudy->ref_by) }}</td>
              <th style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">Study:</th>
              <td style="width: 25%; text-align: center; padding: 4px; border: 1px solid black;">{{ $study->type->name }}</td>
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
                  <img src="{{ $qrBase64 }}" alt="QR Code" width="100" />
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
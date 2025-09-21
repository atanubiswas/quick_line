@if($isPdf === true)
<style>
    @page {
        margin-top: {{ str_replace('mm', '', $top) }}mm;
        margin-right: {{ str_replace('mm', '', $right) }}mm;
        margin-bottom: {{ str_replace('mm', '', $bottom) }}mm;
        margin-left: {{ str_replace('mm', '', $left) }}mm;
    }

    body {
        margin: 0;
    }
</style>
@endif
<a name="view_report"></a>
<div class="print_block">
  @php $count = 1; @endphp
  @foreach($caseStudy->study as $study)
    <table style="border-collapse: collapse; width: 100%; font-size: 16px;">
      <tr>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">Patient Name:</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">{{ ucwords($caseStudy->patient->name) }}</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">Age / Gender:</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">{{ $caseStudy->patient->age }} / {{ ucwords($caseStudy->patient->gender) }}</th>
      </tr>
      <tr>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">Patient Id:</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">{{ $caseStudy->patient->patient_id }}</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">Date & Time:</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">{{ \Carbon\Carbon::parse($caseStudy->created_at)->format('jS \\o\\f M Y, h:i A')}}</th>
      </tr>
      <tr>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">Refd By:</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">{{ ucwords($caseStudy->ref_by) }}</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">Study:</th>
        <th style="border: 1px solid black; padding: 4px; font-size: 16px;">{{ $study->type->name }}</th>
      </tr>
    </table>

    <div class="main_study_result" style="margin-top: 30px;" id="main_study_result_{{ $study->id }}">
      {!! $study->report !!}
    </div>
    <div style="display: none;" id="text_area_div_{{ $study->id }}">  
      <textarea class="study_result" id="study_result_{{ $study->id }}" name="study_result_{{ $study->id }}">{!! $study->report !!}</textarea>
    </div>
    <div style="display: flex;">
      <div style="width:100px; display: none; margin-right: 20px;" id="save_b4_print_div_{{ $study->id }}">
        <button type="button" class="btn btn-block bg-gradient-orange btn-xs save_b4_print" id="save_b4_print_{{ $study->id }}" data-index="{{ $study->id }}"><i class="fas fa-save"></i>Save</button>
      </div>
      <div style="width:100px; float: right; @if($isPdf === true) display: none; @endif">
        <button type="button" class="btn btn-block bg-gradient-primary btn-xs edit_b4_print" data-index="{{ $study->id }}"><i class="fas fa-edit"></i>Edit</button>
      </div>
    </div>
    
    <table style="width: 100%; margin-top: 20px;">
      <tr>
        <td style="width: 50%; vertical-align: top;">
          @if($isPdf === true)
            <img src="{{ public_path('storage'.DIRECTORY_SEPARATOR.$caseStudy->doctor->signature) }}" alt="Doctor Signature" style="width: 100%; max-width: 250px; margin-bottom: 10px;">
          @else
            <img src="{{ url('storage/'.$caseStudy->doctor->signature) }}" alt="Doctor Signature" style="width: 100%; max-width: 250px; margin-bottom: 10px;">
          @endif
          <p style="margin: 0; font-size: 14px; line-height: 1.5;">
            <strong style="font-size: 18px;">{{ $caseStudy->doctor->name }}</strong><br>
            <strong>{{ $doctorQualification->value }}</strong><br>
            @if(isset($registrationNumber->value))
              <strong>{{ $registrationNumber->value }}</strong><br>
            @endif
          </p>
        </td>
        <td style="width: 50%; vertical-align: top; text-align: left;">
          @if($isPdf === true)
            <img src="{{$qrLocalPath}}" alt="QR Code" style="width: 50px; height: 50px; border: 2px dashed #333; padding: 10px;">
          @else
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&color=02013c&data={{$pdfPublicUrl}}" alt="QR Code" style="width: 100px; height: 100px; border: 2px dashed #333; padding: 10px;">
          @endif
        </td>
      </tr>
    </table>
    <p style="font-size: 14px; margin-top: 20px;"><strong>Disclaimer</strong>: It is an online interpretation of Medical Imaging based on clinical data. All modern machines/procedures have their own limitation. If there is any clinical discrepancy, this investigation may be repeated or reassessed by other tests. patient's identification in online reporting is not established, so in no way can this report be utilized for any Medico Legal Purpose.</p>
    @if(count($caseStudy['study'])>$count++)
      <div class="b4-page-break" style="margin-top: 250px;"></div>
      <div style="page-break-before: always; break-before: page;"></div>
    @endif
  @endforeach
</div>
<div style="width:155px; float: right; margin: 5px;">
<button type="button" @if($isPdf === true) style="display: none;" @endif class="btn btn-block bg-gradient-warning btn-small word_button" id="word_button_new" data-word_file_type="docx" data-index="{{ $caseStudy->id }}"><i class="fas fa-file-word"></i>Download Word (.docx)</button>
</div>
<div style="width:155px; float: right; margin: 5px;">
<button type="button" @if($isPdf === true) style="display: none;" @endif class="btn btn-block bg-gradient-warning btn-small word_button" id="word_button_old" data-word_file_type="doc" data-index="{{ $caseStudy->id }}"><i class="fas fa-file-word"></i>Download Word (.doc)</button>
</div>
<div style="width:155px; float: right; margin: 5px;">
<button type="button" @if($isPdf === true) style="display: none;" @endif class="btn btn-block bg-gradient-warning btn-small pdf_button" id="pdf_button" data-index="{{ $caseStudy->id }}"><i class="fas fa-file-pdf"></i>Download PDF</button>
</div>
<div style="width:150px; float: right; margin: 5px;">
<button type="button" @if($isPdf === true) style="display: none;" @endif class="btn btn-block bg-gradient-warning btn-small print_button" id="print_report"><i class="fas fa-print"></i>Print Report</button>
</div>
@if($isPdf !== true)
<script>
  $(function () {
    $('.study_result').summernote({
        height: 300,
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather'],
        fontNamesIgnoreCheck: ['Merriweather'],
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ]
    });

    $(document).on("click", '.save_b4_print',function(){
      var studyId = $(this).data('index');
      var divId = "main_study_result_"+studyId;
      var textareaId = "study_result_"+studyId;
      var textAreaDiv = "text_area_div_"+studyId;
      var saveButtonDiv = "save_b4_print_div_"+studyId;

      var content = $('#'+textareaId).summernote('code');
      $('#'+divId).html(content);
      $("#"+divId).show();
      $("#"+textAreaDiv).hide();
      $("#"+saveButtonDiv).hide();

      $(".print_button").prop('disabled', false);
      $(".edit_b4_print").prop('disabled', false);
    });

    $(document).on("click", '.edit_b4_print',function(){
      var studyId = $(this).data('index');
      var divId = "main_study_result_"+studyId;
      var textareaId = "study_result_"+studyId;
      var textAreaDiv = "text_area_div_"+studyId;
      var saveButtonId = "save_b4_print_"+studyId;
      var saveButtonDivId = "save_b4_print_div_"+studyId;

      $('#'+divId).hide();
      $("#"+saveButtonDivId).show();
      $("#"+textAreaDiv).show();
      $(".print_button").prop('disabled', true);
      $(".edit_b4_print").prop('disabled', true);
    });

    $('.print_button').on('click', function () {
      const content = $('.print_block').clone();
      const printWindow = window.open('', '', 'width=800,height=1000');

      const top = '{{ $top }}';
      const right = '{{ $right }}';
      const bottom = '{{ $bottom }}';
      const left = '{{ $left }}';

      printWindow.document.write(`<head> <title>Print</title> <style> @page {size: A4; margin: ${top} ${right} ${bottom} ${left}; } body {margin: 0; padding: 0; font-family: Arial, sans-serif; } img {max-width: 100%; height: auto; display: block; } .edit_b4_print, .b4-page-break {display: none; } </style> </head> <body> <div class="print-content"></div></body>`);

      printWindow.document.close();

      printWindow.onload = function () {
        const printBody = printWindow.document.querySelector('.print-content');
        printBody.innerHTML = content.html();

        const images = printBody.querySelectorAll('img');
        let loaded = 0;

        if (images.length === 0) {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
            return;
        }

        images.forEach(function (img) {
          // Check if already loaded
          if (img.complete) {
              loaded++;
              if (loaded === images.length) {
                  printWindow.focus();
                  printWindow.print();
                  printWindow.close();
              }
          }
          else {
              img.onload = img.onerror = function () {
                  loaded++;
                  if (loaded === images.length) {
                      printWindow.focus();
                      printWindow.print();
                      printWindow.close();
                  }
              };
          }
        });
      }
    });

    $('.word_button').on('click', function () {
        var id = $(this).data('index');
        var fileType = $(this).data('word_file_type');
        let url = `/quick_line_new/public/admin/download-word/${id}/${fileType}`;
        window.open(url, '_blank');
    });

    $('#pdf_button').on('click', function () {
        var id = $(this).data('index');
        let name = '{{ str_replace([" ", "/"], ["-", "-"], $caseStudy->patient->name) }}';
        let caseStudyId = '{{ $caseStudy->case_study_id }}';
        let fileName = `case-study-report-${caseStudyId}-${name}.pdf`;
        let url = `/quick_line_new/public/storage/pdfs/${fileName}`;
        window.open(url, '_blank');
    });
  });
</script>
@endif
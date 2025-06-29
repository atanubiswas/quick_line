// public/js/doctor-bill-pdf.js
$(document).ready(function() {
    // Show PDF button after search
    function showDoctorPdfButton(show) {
        if (show) {
            $('#doctor-pdf-btn-container').show();
        } else {
            $('#doctor-pdf-btn-container').hide();
        }
    }
    // Hook into the search completion
    window.showDoctorPdfButton = showDoctorPdfButton;
    // Set hidden fields before PDF download
    $('#download-doctor-pdf-btn').on('click', function(e) {
        $('#pdf_doctor_id').val($('#doctor_select').val());
        $('#pdf_start_date').val($('#start_date').val());
        $('#pdf_end_date').val($('#end_date').val());
    });
});

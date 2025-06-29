// public/js/doctor-bill-generate.js
$(document).ready(function() {
    // Set min for end_date to start_date
    $('#start_date').on('change', function() {
        var startDate = $(this).val();
        var endDate = $('#end_date').val();
        if (startDate > endDate) {
            $('#end_date').val(startDate);
        }
        $('#end_date').attr('min', startDate);
    });
    $('#end_date').attr('min', $('#start_date').val());
    // Filter button click
    $('#filter-doctor-bill-btn').on('click', function() {
        var doctorId = $('#doctor_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        if (!doctorId) {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select a Doctor.' });
            return;
        }
        if (!startDate) {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select a Start Date.' });
            return;
        }
        if (!endDate) {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select an End Date.' });
            return;
        }
        $(this).data('original-text', $(this).html());
        $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating');
        fetchDoctorBillData();
    });
    function fetchDoctorBillData() {
        var doctorId = $('#doctor_select').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        $('#doctor-bill-loading').show();
        $('#doctor_bill_datatable').hide();
        $('#doctor-excel-btn-container').hide();
        $.ajax({
            url: doctorBillDataUrl,
            type: 'GET',
            data: {
                doctor_id: doctorId,
                start_date: startDate,
                end_date: endDate
            },
            success: function(data) {
                $('#doctor-bill-loading').hide();
                $('#doctor_bill_datatable').show();
                $('#filter-doctor-bill-btn').prop('disabled', false).html($('#filter-doctor-bill-btn').data('original-text'));
                if (data.error) {
                    Swal.fire({ icon: 'error', title: 'Missing Price', text: data.error });
                    $('#doctor_bill_datatable tbody').html('<tr><td colspan="7" class="text-center">No data found.</td></tr>');
                    $('#doctor-excel-btn-container').hide();
                    return;
                }
                var tbody = '';
                if (!data.data || data.data.length === 0) {
                    tbody = '<tr><td colspan="7" class="text-center">No data found.</td></tr>';
                    $('#save-doctor-bill-btn').hide();
                    if (window.showDoctorPdfButton) window.showDoctorPdfButton(false);
                } else {
                    data.data.forEach(function(row, idx) {
                        tbody += '<tr>' +
                            '<td>' + (idx+1) + '</td>' +
                            '<td>' + row.case_id + '</td>' +
                            '<td>' + row.patient_name + '</td>' +
                            '<td>' + row.gender_age + '</td>' +
                            '<td>' + row.study_type + '</td>' +
                            '<td>' + row.date + '</td>' +
                            '<td>' + (parseFloat(row.amount).toFixed(2)) + '</td>' +
                            '</tr>';
                    });
                    tbody += '<tr id="total_summary_row">' +
                        '<td colspan="3" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Number of Cases</td>' +
                        '<td style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">' + data.data.length + '</td>' +
                        '<td colspan="2" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Total Amount</td>' +
                        '<td style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;"><span class="d-block mt-1" style="font-weight:bold;">' + (data.total_amount ? parseFloat(data.total_amount).toFixed(2) : '0.00') + '</span></td>' +
                        '</tr>';
                    $('#save-doctor-bill-btn').show();
                    if (window.showDoctorPdfButton) window.showDoctorPdfButton(true);
                }
                $('#doctor_bill_datatable tbody').html(tbody);
            },
            error: function() {
                $('#doctor-bill-loading').hide();
                $('#doctor_bill_datatable').show();
                $('#filter-doctor-bill-btn').prop('disabled', false).html($('#filter-doctor-bill-btn').data('original-text'));
                $('#doctor-excel-btn-container').hide();
            }
        });
    }
    // Previous Month checkbox logic for doctor bill
    var prevStartDate = '';
    var prevEndDate = '';
    $('#doctor-previous-month-checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            prevStartDate = $('#start_date').val();
            prevEndDate = $('#end_date').val();
            var now = new Date();
            var prevMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
            var prevMonthStart = new Date(prevMonth.getFullYear(), prevMonth.getMonth(), 1);
            var prevMonthEnd = new Date(prevMonth.getFullYear(), prevMonth.getMonth() + 1, 0);
            var pad = function(n) { return n < 10 ? '0' + n : n; };
            var startStr = prevMonthStart.getFullYear() + '-' + pad(prevMonthStart.getMonth() + 1) + '-' + pad(prevMonthStart.getDate());
            var endStr = prevMonthEnd.getFullYear() + '-' + pad(prevMonthEnd.getMonth() + 1) + '-' + pad(prevMonthEnd.getDate());
            $('#start_date').val(startStr);
            $('#end_date').val(endStr);
            $('#end_date').attr('min', startStr);
        } else {
            if (prevStartDate) $('#start_date').val(prevStartDate);
            if (prevEndDate) $('#end_date').val(prevEndDate);
            $('#end_date').attr('min', $('#start_date').val());
        }
    });
    // Save Doctor Bill button click
    // (Moved to Blade file)
});

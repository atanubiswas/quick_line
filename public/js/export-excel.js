// Simple function to export HTML table to Excel
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    if (!tableSelect) {
        alert('Table not found!');
        return;
    }
    // Clone table to avoid exporting hidden rows (if any)
    var tableClone = tableSelect.cloneNode(true);
    // Remove any hidden rows (display: none)
    var rows = tableClone.querySelectorAll('tr');
    rows.forEach(function(row) {
        if (row.style.display === 'none') {
            row.parentNode.removeChild(row);
        }
    });

    // Get Centre Name and Dates
    var centreSelect = document.getElementById('centre_select');
    var centreName = '';
    if (centreSelect) {
        if (centreSelect.tagName === 'SELECT') {
            var selectedOption = centreSelect.options[centreSelect.selectedIndex];
            centreName = selectedOption ? selectedOption.text.trim() : '';
        } else {
            centreName = centreSelect.value ? centreSelect.value.trim() : '';
        }
    }
    var startDate = '';
    var endDate = '';
    var startDateInput = document.getElementById('start_date');
    var endDateInput = document.getElementById('end_date');
    if (startDateInput) startDate = startDateInput.value;
    if (endDateInput) endDate = endDateInput.value;

    // Helper to format date as '12th Jun 2025'
    function formatDateWithSuffix(dateStr) {
        if (!dateStr) return '';
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        var day = d.getDate();
        var daySuffix = (function(n) {
            if (n >= 11 && n <= 13) return 'th';
            switch (n % 10) {
                case 1: return 'st';
                case 2: return 'nd';
                case 3: return 'rd';
                default: return 'th';
            }
        })(day);
        return day + daySuffix + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    // Info rows before table
    var infoHTML = '';
    if (centreName) {
        infoHTML += '<tr><td colspan="9" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Centre Name: ' + centreName + '</td></tr>';
    }
    var formattedStart = formatDateWithSuffix(startDate);
    var formattedEnd = formatDateWithSuffix(endDate);
    if (startDate || endDate) {
        infoHTML += '<tr><td colspan="9" style="background:#e6f2ff;font-size:14px;font-weight:bold;color:#1a237e;">Date Between: ' + (formattedStart ? formattedStart : '') + (formattedEnd ? ' to ' + formattedEnd : '') + '</td></tr>';
    }
    // Add Total Study and Total Amount rows
    var totalStudy = 0;
    var totalAmount = 0;
    var rows = tableClone.querySelectorAll('tbody tr');
    rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length === 9) {
            var amount = parseFloat(cells[8].textContent.trim());
            if (!isNaN(amount)) totalAmount += amount;
            totalStudy++;
        }
    });
    var infoTable = infoHTML ? '<table>' + infoHTML + '</table><br>' : '';

    // Add border style for table and cells
    var borderStyle = '<style>table, th, td { border: 1px solid #000 !important; border-collapse: collapse !important; } th, td { padding: 5px; }</style>';
    var tableHTML = '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="UTF-8">' + borderStyle + '</head><body>' + infoTable + tableClone.outerHTML + '</body></html>';

    // Format amount columns to two decimal places in the exported table
    var amountColIndex = -1;
    var headerCells = tableClone.querySelectorAll('thead tr th');
    headerCells.forEach(function(th, idx) {
        if (th.textContent.trim().toLowerCase() === 'amount') {
            amountColIndex = idx;
        }
    });
    if (amountColIndex !== -1) {
        var rows = tableClone.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            if (cells.length > amountColIndex) {
                var val = cells[amountColIndex].textContent.trim();
                var num = parseFloat(val.replace(/[^0-9.\-]/g, ''));
                if (!isNaN(num)) {
                    cells[amountColIndex].textContent = num.toFixed(2);
                }
            }
        });
    }

    // Custom filename logic
    if (!filename) {
        var fileCentre = centreName ? centreName.replace(/\s+/g, '_') : '';
        filename = 'Bill_' + (fileCentre ? fileCentre + '_' : '') + (formattedStart ? formattedStart.replace(/\s+/g, '_') : '') + (formattedEnd ? '_to_' + formattedEnd.replace(/\s+/g, '_') : '') + '.xls';
    }

    downloadLink = document.createElement('a');
    document.body.appendChild(downloadLink);

    if (window.Blob && window.URL && window.URL.createObjectURL) {
        var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
        var url = URL.createObjectURL(blob);
        downloadLink.href = url;
        downloadLink.download = filename;
        downloadLink.click();
        setTimeout(function() { URL.revokeObjectURL(url); }, 100);
    } else if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ';charset=utf-8,' + encodeURIComponent(tableHTML);
        downloadLink.download = filename;
        downloadLink.click();
    }
    document.body.removeChild(downloadLink);
}

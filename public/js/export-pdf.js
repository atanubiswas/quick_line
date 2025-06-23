// Remove ES6 imports and use global jsPDF and autoTable from CDN
window.exportTableToPDF = function(tableID) {
    var doc = new window.jspdf.jsPDF('l', 'pt', 'a4');
    var table = document.getElementById(tableID);
    if (!table) {
        alert('Table not found!');
        return;
    }
    // Get Centre Name and Dates
    var centreSelect = document.getElementById('centre_select');
    var centreName = '';
    if (centreSelect) {
        var selectedOption = centreSelect.options[centreSelect.selectedIndex];
        centreName = selectedOption ? selectedOption.text.trim() : '';
    }
    var startDate = '';
    var endDate = '';
    var startDateInput = document.getElementById('start_date');
    var endDateInput = document.getElementById('end_date');
    if (startDateInput) startDate = startDateInput.value;
    if (endDateInput) endDate = endDateInput.value;
    // Format date as '12th Jun 2025'
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
    // Header
    doc.setFontSize(18);
    doc.setTextColor('#1a237e');
    doc.text('Invoice', 40, 40);
    doc.setFontSize(12);
    doc.setTextColor('#000');
    var y = 70;
    if (centreName) {
        doc.setFontSize(14);
        doc.setTextColor('#1a237e');
        doc.text('Centre Name: ' + centreName, 40, y);
        y += 20;
    }
    if (startDate || endDate) {
        doc.setFontSize(14);
        doc.setTextColor('#1a237e');
        doc.text('Date Between: ' + (formatDateWithSuffix(startDate) || '') + (endDate ? ' to ' + formatDateWithSuffix(endDate) : ''), 40, y);
        y += 20;
    }
    // Table
    var columns = [];
    var rows = [];
    var ths = table.querySelectorAll('thead th');
    ths.forEach(function(th) {
        columns.push({ header: th.textContent.trim(), dataKey: th.textContent.trim() });
    });
    var trs = table.querySelectorAll('tbody tr');
    trs.forEach(function(tr) {
        var tds = tr.querySelectorAll('td');
        if (tds.length === columns.length) {
            var row = {};
            columns.forEach(function(col, idx) {
                row[col.dataKey] = tds[idx].textContent.trim();
            });
            rows.push(row);
        }
    });
    // Use correct global for autoTable
    var autoTable = window.jspdfAutoTable ? window.jspdfAutoTable.default : (window.jspdf && window.jspdf.autoTable ? window.jspdf.autoTable : null);
    if (!autoTable) {
        alert('jsPDF AutoTable plugin not loaded!');
        return;
    }
    autoTable(doc, {
        startY: y + 10,
        head: [columns.map(col => col.header)],
        body: rows.map(row => columns.map(col => row[col.dataKey])),
        styles: { fontSize: 10, cellPadding: 4 },
        headStyles: { fillColor: [230, 242, 255], textColor: [26, 35, 126], fontSize: 12, fontStyle: 'bold' },
        margin: { left: 40, right: 40 },
        theme: 'grid',
    });
    // Totals
    var totalStudy = rows.length;
    var totalAmount = 0;
    rows.forEach(function(row) {
        var val = row['Amount'] || row['amount'] || row['Amount '];
        var num = parseFloat(val);
        if (!isNaN(num)) totalAmount += num;
    });
    var finalY = doc.lastAutoTable.finalY + 20;
    doc.setFontSize(14);
    doc.setTextColor('#1a237e');
    doc.text('Total Number Of Study: ' + totalStudy, 40, finalY);
    doc.text('Total Amount: ' + totalAmount.toFixed(2), 300, finalY);
    doc.save('Bill.pdf');
};

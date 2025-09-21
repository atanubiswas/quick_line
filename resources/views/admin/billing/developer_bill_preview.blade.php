<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>Bill Period</th>
            <th>Total Cases</th>
            <th>Per Case (₹)</th>
            <th>Total Amount (₹)</th>
        </tr>
    </thead>
    <tbody id="billTable">
        <tr>
            <td>1</td>
            <td>{{\Carbon\Carbon::parse($startDate)->format('d-M-Y')}} To {{\Carbon\Carbon::parse($endDate)->format('d-M-Y')}}</td>
            <td>{{number_format($totalCase)}}</td>
            <td>&#8377;{{number_format($pricePerCase, 2)}}</td>
            <td>&#8377;{{number_format($totalAmount, 2)}}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right"><strong>Total</strong></td>
            <td>&#8377;{{number_format($totalAmount, 2)}}</td>
        </tr>
    </tfoot>
</table>
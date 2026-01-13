<h1>Daily Sales Report</h1>

<p><strong>Date:</strong> {{ $reportData['date'] }}</p>

<div style="margin: 20px 0; padding: 15px; background-color: #f3f4f6; border-radius: 4px;">
    <p style="margin: 0; font-size: 18px;">
        <strong>Total Sales:</strong> ${{ number_format($reportData['total_sales'], 2) }}
    </p>
    <p style="margin: 10px 0 0 0; font-size: 16px;">
        <strong>Orders Count:</strong> {{ $reportData['orders_count'] }}
    </p>
</div>

<h2 style="margin-top: 20px; font-size: 16px;">Products Sold</h2>

<table style="border-collapse: collapse; width: 100%; margin: 10px 0;">
    <thead>
        <tr style="background-color: #f3f4f6; border-bottom: 2px solid #d1d5db;">
            <th style="padding: 10px; text-align: left; font-weight: bold;">Product</th>
            <th style="padding: 10px; text-align: center; font-weight: bold;">Quantity Sold</th>
            <th style="padding: 10px; text-align: right; font-weight: bold;">Revenue</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reportData['products_sold'] as $product)
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 10px;">{{ $product['name'] }}</td>
                <td style="padding: 10px; text-align: center;">{{ $product['quantity_sold'] }}</td>
                <td style="padding: 10px; text-align: right;">${{ number_format($product['revenue'], 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="padding: 10px; text-align: center; color: #6b7280;">No products sold today.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p style="margin-top: 20px; color: #6b7280; font-size: 14px;">
    This is an automated report. Please do not reply to this email.
</p>

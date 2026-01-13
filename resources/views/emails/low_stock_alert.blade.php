<h1>Low Stock Alert</h1>

<p>The product <strong>{{ $product->name }}</strong> is running low on stock.</p>

<table style="border-collapse: collapse; width: 100%; margin: 20px 0;">
    <tr style="border-bottom: 1px solid #ddd;">
        <td style="padding: 10px; font-weight: bold;">Product ID</td>
        <td style="padding: 10px;">{{ $product->id }}</td>
    </tr>
    <tr style="border-bottom: 1px solid #ddd;">
        <td style="padding: 10px; font-weight: bold;">Current Stock</td>
        <td style="padding: 10px;">{{ $product->stock_quantity }} units</td>
    </tr>
    <tr>
        <td style="padding: 10px; font-weight: bold;">Product Price</td>
        <td style="padding: 10px;">${{ number_format($product->price, 2) }}</td>
    </tr>
</table>

<p>Please reorder stock as soon as possible to avoid stockouts.</p>

<p>
    <a href="{{ route('products.index') }}" style="display: inline-block; padding: 10px 20px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 4px;">View Products</a>
</p>

<p>
    Thanks,<br>
    {{ config('app.name') }}
</p>

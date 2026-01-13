<?php

namespace App\Observers;

use App\Jobs\LowStockNotification;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Trigger low stock notification if stock was reduced
        if ($product->isDirty('stock_quantity')) {
            LowStockNotification::dispatch($product);
        }
    }
}

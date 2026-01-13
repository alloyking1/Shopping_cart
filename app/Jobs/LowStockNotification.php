<?php

namespace App\Jobs;

use App\Mail\LowStockAlert;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class LowStockNotification implements ShouldQueue
{
    use Queueable;

    protected const LOW_STOCK_THRESHOLD = 10;

    public function __construct(
        public Product $product,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if stock is below threshold
        if ($this->product->stock_quantity >= self::LOW_STOCK_THRESHOLD) {
            return;
        }

        // Get all admin users (users with admin role or email containing 'admin')
        $admins = User::where('email', 'like', '%admin%')->get();

        if ($admins->isEmpty()) {
            return;
        }

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new LowStockAlert($this->product));
        }
    }
}

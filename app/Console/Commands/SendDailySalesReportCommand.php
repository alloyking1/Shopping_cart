<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReport;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:daily-report';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $today = Carbon::today();

        // Query orders from today
        $orders = Order::whereDate('created_at', $today)->with('orderItems.product', 'user')->get();

        if ($orders->isEmpty()) {
            $this->info('No orders found for today.');
            return self::SUCCESS;
        }

        // Calculate total sales
        $totalSales = $orders->sum('total_amount');

        // Get list of products sold
        $productsSold = $orders
            ->flatMap(fn($order) => $order->orderItems)
            ->groupBy('product_id')
            ->map(function ($items) {
                $product = $items->first()->product;

                return [
                    'name' => $product->name,
                    'quantity_sold' => $items->sum('quantity'),
                    'revenue' => $items->sum(fn($item) => $item->quantity * $item->price_at_purchase),
                ];
            })
            ->values();

        $reportData = [
            'date' => $today->format('Y-m-d'),
            'total_sales' => $totalSales,
            'orders_count' => $orders->count(),
            'products_sold' => $productsSold,
        ];

        // Get admin users and send report
        $admins = User::where('email', 'like', '%admin%')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new DailySalesReport($reportData));
        }

        $this->info("Daily sales report sent to {$admins->count()} admin(s).");

        return self::SUCCESS;
    }
}

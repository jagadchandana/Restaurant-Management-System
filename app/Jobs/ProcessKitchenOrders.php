<?php

namespace App\Jobs;

use App\Enums\OrderStatusEnum;
use App\Repositories\Eloquent\Order\OrderInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessKitchenOrders implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(OrderInterface $orderInterface): void
    {
        $now = Carbon::now()->format('Y-m-d H:i');
        $orders = $orderInterface->getByColumn(['status' => OrderStatusEnum::Pending->value, 'to_kitchen' => $now]);

        foreach ($orders as $order) {
            $order->update([
                'status' => OrderStatusEnum::InProgress->value,
            ]);
            // add order to kitchen(queue)
            $orderInterface->addOrRemoveOrder($order->id, true);
        }
    }
}

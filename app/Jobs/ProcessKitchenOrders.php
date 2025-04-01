<?php

namespace App\Jobs;

use App\Enums\InKitchenEnum;
use App\Enums\OrderStatusEnum;
use App\Repositories\Eloquent\Order\OrderInterface;
use App\Services\Order\OrderServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;

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
        $now = Carbon::now();
        $orders = $orderInterface->getByColumn(['status' => OrderStatusEnum::Pending->value, 'to_kitchen' => '<='.$now]);

        foreach ($orders as $order) {
           $order->update([
                'status' => OrderStatusEnum::InProgress->value,
            ]);
            $orderInterface->addOrRemoveOrder($order->id, true);
        }
    }
}

<?php

namespace App\Repositories\Eloquent\Order;

use App\Models\Order;
use App\Repositories\Base\BaseRepository;

// repository Class
class OrderRepository extends BaseRepository implements OrderInterface
{
    /**
     * @var Order
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * @param mixed $order
     * @param mixed $isAdded
     *
     * @return [type]
     */
    public function addOrRemoveOrder($orderId, $isAdded)
    {
        $order = $this->model->find($orderId);
        if ($isAdded) {
            $maxQueueOrder = $order->newQuery()->max('queue_order');
            $order->update([
                'queue_order' => $maxQueueOrder + 1,
            ]);
        } else {
            $currentQueueOrder = $order->queue_order;
            $order->update([
                'queue_order' => null,
            ]);

            $order->newQuery()
                ->where('queue_order', '>', $currentQueueOrder)
                ->orderBy('queue_order')
                ->chunkById(100, function ($orders) {
                    foreach ($orders as $order) {
                        $order->update([
                            'queue_order' => $order->queue_order - 1,
                        ]);
                    }
                });
        }
    }
}

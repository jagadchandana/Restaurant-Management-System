<?php

namespace App\Repositories\Eloquent\Order;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface OrderInterface extends EloquentRepositoryInterface
{
    /**
     * @param mixed $order
     * @param mixed $isAdded
     *
     * @return [type]
     */
    public function addOrRemoveOrder($orderId, $isAdded);


}

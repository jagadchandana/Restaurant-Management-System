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
}

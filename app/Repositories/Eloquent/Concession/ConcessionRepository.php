<?php

namespace App\Repositories\Eloquent\Concession;

use App\Models\Concession;
use App\Repositories\Base\BaseRepository;

// repository Class
class ConcessionRepository extends BaseRepository implements ConcessionInterface
{
    /**
     * @var Concession
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Concession $model)
    {
        $this->model = $model;
    }
}

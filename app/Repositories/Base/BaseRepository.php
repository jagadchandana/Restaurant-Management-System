<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // ss
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Method paginate
     *
     * @param  int  $number  [number of records per page]
     */
    public function paginate(int $number)
    {
        return $this->model->paginate($number);
    }


    /**
     * Find model by id.
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find model by id.
     *
     * @param  array  $modelId
     * @param  array  $appends
     */
    public function findByColumn(
        array $paramsAnddData,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->where($paramsAnddData)->first();
    }


    /**
     * Find model by columns.
     *
     * @param  array  $modelId
     * @param  array  $appends
     */
    public function getByColumn(
        array $paramsAnddData,
        array $columns = ['*'],
        array $relations = []
    ): ?Collection {
        return $this->model->select($columns)->with($relations)->where($paramsAnddData)->get();
    }

    /**
     * Find model by existsByColumn.
     *
     * @param  array  $modelId
     */
    public function existsByColumn(
        array $paramsAnddData,
        array $columns = ['*']
    ): ?bool {
        return $this->model->select($columns)->where($paramsAnddData)->exists();
    }



    /**
     * Create a model.
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    /**
     * Create or update a model.
     */
    public function createOrUpdate(array $attributes, array $values): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Method createMany
     *
     * @param  array  $payloadCollection  [collection of payload]
     */
    public function createMany(array $payloadCollection): ?Collection
    {
        return $this->model->createMany($payloadCollection);
    }


    /**
     * Update existing model.
     */
    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);

        return $model->update($payload);
    }

    /**
     * Delete model by id.
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }


    /**
     * Delete model by columns.
     *
     * @return int
     */
    public function deleteByColumn(array $paramsAndData)
    {
        return $this->model->where($paramsAndData)->delete();
    }



    /**
     * Method filter
     *
     * @param  array  $request  [Http Request]
     * @param  array  $with  [Relations]
     */
    public function filter($filters, $with = []): LengthAwarePaginator
    {
        $query = $this->model->filter($filters)->orderByColumn($filters['sortBy'], $filters['sortDirection']);
        if (count($with) > 0) {
            $query = $query->with($with);
        }

        return $query->paginate($filters['rowPerPage'])->appends($filters);
    }

}

<?php

namespace App\Repositories;

use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
abstract class BaseRepository
{
    /** @var int */
    protected $perPage = 50;
    /** @var Model */
    protected $model;

    /**
     * @param string $orderBy
     *
     * @param string $direction
     *
     * @return Collection|static[]
     */
    public function all(string $orderBy = null, string $direction = 'asc'): Collection
    {
        return $orderBy
            ? $this->model->orderBy($orderBy, $direction)->get()
            : $this->model->get();
    }

    /**
     * Return a model by ID from the database. If relationships are provided, eager load those relationships.
     *
     * @param int   $id
     * @param array $relationships
     *
     * @return Model|null
     */
    public function find(int $id, array $relationships = [])
    {
        return $this->model
            ->with($relationships)
            ->findOrFail($id);
    }

    /**
     * @param string $column
     * @param string $value
     * @param array  $relationships
     *
     * @return Builder[]|Collection|Model[]|\Illuminate\Support\Collection
     */
    public function findBy(string $column, string $value, array $relationships = [])
    {
        return $this->model
            ->with($relationships)
            ->where($column, $value)
            ->get();
    }

    /**
     * @param array $where
     * @param array $relationships
     *
     * @return Builder[]|Collection|Model[]|\Illuminate\Support\Collection
     */
    public function findWhere(array $where, array $relationships = [])
    {
        return $this->model
            ->with($relationships)
            ->where($where)
            ->get();
    }

    /**
     * Create a new Eloquent Query Builder instance
     *
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Update model
     *
     * @param int   $id
     * @param array $data
     *
     * @return bool
     */
    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }

    /**
     * @param array $ids
     * @param array $data
     *
     * @return bool|null
     */
    public function butchUpdate(array $ids, array $data)
    {
        return $this->model->whereIn('id', $ids)->update($data);
    }

    /**
     * @param array $ids
     *
     * @return bool|null
     * @throws \Exception
     */
    public function butchDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * @param int $id
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    /**
     * @param Model $model
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteModel(Model $model)
    {
        return $model->delete();
    }

    /**
     * Delete all models
     *
     * @param array $where
     *
     * @return bool|null
     *
     */
    public function deleteAll(array $where = []): ?bool
    {
        $query = $this->newQuery();

        if ($where) {
            $query->where($where);
        }

        return $query
            ->delete();
    }
}

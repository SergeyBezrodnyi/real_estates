<?php

namespace App\Repositories;

use App\Models\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

/**
 * Class StorageRepository
 *
 * @package App\Repositories
 *
 */
class StorageRepository extends BaseRepository
{
    /**
     * StorageRepository constructor.
     *
     * @param Storage $storage
     * @internal param Storage $storage
     */
    public function __construct(Storage $storage) {
        $this->model = $storage;
    }

    /**
     * @param array $data
     *
     * @return Storage|false
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance();
        $model->s3_path = $data['s3_path'];
        $model->real_estate_id = $data['real_estate_id'];
        $model->file_name = $data['file_name'];

        try {
            $model->save();
        } catch (QueryException $e) {
			throw new \Exception($e->getMessage());
        }
        return $model;
    }
}

<?php

namespace App\Repositories;

use App\Models\Agency;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

/**
 * Class AgencyRepository
 *
 * @package App\Repositories
 *
 */
class AgencyRepository extends BaseRepository
{
    /**
     * AgencyRepository constructor.
     *
     * @param Agency $agency
     * @internal param Agency $agency
     */
    public function __construct(Agency $agency) {
        $this->model = $agency;
    }

    /**
     * @param array $data
     *
     * @return Agency|false
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance();
        $model->name = $data['name'];

        try {
            $model->save();
        } catch (QueryException $e) {
			throw new \Exception($e->getMessage());
        }
        return $model;
    }
}

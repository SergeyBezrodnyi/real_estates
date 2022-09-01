<?php

namespace App\Repositories;

use App\Models\RealEstate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

/**
 * Class RealEstateRepository
 *
 * @package App\Repositories
 *
 */
class RealEstateRepository extends BaseRepository
{
    /**
     * RealEstateRepository constructor.
     *
     * @param RealEstate $realEstate
     * @internal param RealEstate $realEstate
     */
    public function __construct(RealEstate $realEstate) {
        $this->model = $realEstate;
    }

    /**
     * @param array $data
     *
     * @return RealEstate|false
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance();
        $model->address = $data['address'];
        $model->price = $data['price'];
        $model->number_of_rooms = $data['number_of_rooms'];
        if(isset($data['description'])) {
            $model->description = $data['description'];
        } 
        $model->is_rent = $data['is_rent'];
        if(isset($data['rented_at'])) {
            $model->rented_at = Carbon::parse($data['rented_at']);
        }
        $model->agency_id = $data['agency_id'];
        $model->type = $data['type'];
        if(isset($data['sold_date'])) {
            $model->sold_date = $data['sold_date'];
        }

        try {
            $model->save();
        } catch (QueryException $e) {
			throw new \Exception($e->getMessage());
        }
        return $model;
    }

    /**
     * @param array $data
     * 
     * @return RealEstate|false
     */
    public function listByAgencyAndMonth(array $data)
    {
        $agencyId = $data['agency_id'];
        $startDate = Carbon::createFromDate($data['year'], $data['month'])->startOfMonth();
        $endDate = Carbon::createFromDate($data['year'], $data['month'])->endOfMonth();
        
        $rentedEstates = RealEstate::where('agency_id', $agencyId)
            ->whereNotNull('rented_at')
            ->where('rented_at', '>=', $startDate)
            ->where('rented_at', '<=', $endDate)
            ->with('agency')
            ->with('images')
            ->get();

        $soldEstate = RealEstate::where('agency_id', $agencyId)
            ->whereNotNull('sold_date')
            ->where('sold_date', '>=', $startDate)
            ->where('sold_date', '<=', $endDate)
            ->with('agency')
            ->with('images')
            ->get();

        $merged = $rentedEstates->merge($soldEstate);
       
        return $merged;
    }
}

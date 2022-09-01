<?php

namespace App\Services;

use App\Http\Traits\CRUDService;
use App\Repositories\AgencyRepository;

/**
 * Class AgencyService
 *
 * @package App\Services
 */
class AgencyService
{
	use CRUDService;
	
    /** @var AgencyRepository */
    private AgencyRepository $repository;

    public function __construct(AgencyRepository $repository) {
        $this->repository = $repository;
    }
}

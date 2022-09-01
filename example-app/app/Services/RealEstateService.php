<?php

namespace App\Services;

use App\Http\Traits\CRUDService;
use App\Repositories\RealEstateRepository;

/**
 * Class RealEstateService
 *
 * @package App\Services
 */
class RealEstateService
{
	use CRUDService;
	
    /** @var RealEstateRepository */
    private RealEstateRepository $repository;

    public function __construct(RealEstateRepository $repository) {
        $this->repository = $repository;
    }
}

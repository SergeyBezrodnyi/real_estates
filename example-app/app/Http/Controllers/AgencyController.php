<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgencyService;
use App\Repositories\AgencyRepository;

class AgencyController extends Controller
{
    /** @var AgencyService */
	private $agencyService;
    /** @var AgencyRepository */
	private $agencyRepository;

    public function __construct(
		AgencyService $agencyService,
        AgencyRepository $agencyRepository
	) {
		$this->agencyService = $agencyService;
        $this->agencyRepository = $agencyRepository;
	}

    public function create(Request $request)
	{
		$agency = $this->agencyService->create($request->all());

		return response($agency);
	}

    public function update($id, Request $request)
	{
		$agency = $this->agencyRepository->find($id);
		$this->agencyService->update($agency, $request->all());
		$agency = $this->agencyRepository->find($id);

		return response($agency);
	}

    public function delete($id, Request $request)
	{
		$agency = $this->agencyRepository->find($id);
        
		return $this->agencyService->delete($agency);
	}
}

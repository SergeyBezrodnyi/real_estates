<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RealEstateService;
use App\Repositories\RealEstateRepository;
use App\Repositories\StorageRepository;
use Illuminate\Support\Facades\Storage;

class RealEstateController extends Controller
{
    /** @var RealEstateService */
	private $realEstateService;
    /** @var RealEstateRepository */
	private $realEstateRepository;
     /** @var StorageRepository */
	private $storageRepository;

    public function __construct(
		RealEstateService $realEstateService,
        RealEstateRepository $realEstateRepository,
        StorageRepository $storageRepository
	) {
		$this->realEstateService = $realEstateService;
        $this->realEstateRepository = $realEstateRepository;
        $this->storageRepository = $storageRepository;
	}

    public function create(Request $request)
	{
        $data = $request->all();
		$realEstate = $this->realEstateService->create($data);

        $files = $data['files'];
        $pathes = [];
        foreach($files as $file) {
            $imageName = $file->getClientOriginalName();
            $title = pathinfo($imageName, PATHINFO_FILENAME);

            $path = Storage::disk('s3')->putFileAs('images', $file, $imageName);
            $url = Storage::disk('s3')->url($path);
            $data = [
                's3_path' => $url,
                'real_estate_id' => $realEstate->id,
                'file_name' => $title,
            ];

            $this->storageRepository->create($data);
        }
    
		return response($realEstate);
	}

    public function update($id, Request $request)
	{
		$realEstate = $this->realEstateRepository->find($id);
		$this->realEstateService->update($realEstate, $request->all());
		$realEstate = $this->realEstateRepository->find($id);

		return response($realEstate);
	}

    public function delete($id, Request $request)
	{
		$realEstate = $this->realEstateRepository->find($id);
        
		return $this->realEstateService->delete($realEstate);
	}

    public function get($id, Request $request)
	{
		$realEstate = $this->realEstateRepository->find($id);
        
		return $realEstate;
	}

    public function list(Request $request)
	{
		$realEstates = $this->realEstateRepository->all();
		return response($realEstates);
	}

    public function listByType(Request $request)
	{
		$realEstates = $this->realEstateRepository->findBy('type', $request->get('type'));
		return response($realEstates);
	}

    public function listByAgencyAndMonth(Request $request)
	{
		$realEstates = $this->realEstateRepository->listByAgencyAndMonth($request->all());
		return response($realEstates);
	}
}

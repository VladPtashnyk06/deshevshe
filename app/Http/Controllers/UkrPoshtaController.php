<?php

namespace App\Http\Controllers;

use App\Services\MeestService;
use App\Services\NovaPoshtaService;
use App\Services\UkrPoshtaService;
use Illuminate\Http\Request;

class UkrPoshtaController extends Controller
{
    protected $ukrPoshtaService;

    public function __construct(UkrPoshtaService $ukrPoshtaService)
    {
        $this->ukrPoshtaService = $ukrPoshtaService;
    }

    public function index()
    {
        $regions = $this->ukrPoshtaService->getRegions();

        return view('site.example.ukrposhta.index', compact('regions'));
    }

    public function getCities(Request $request)
    {
        $regionId = $request->input('regionId');

        $cities = $this->ukrPoshtaService->getCities($regionId);

        return response()->json($cities);
    }

    public function getBranches(Request $request)
    {
        $cityId = $request->input('cityId');

        $branches = $this->ukrPoshtaService->getBranches($cityId);

        return response()->json($branches);
    }

    public function getCityByRef(Request $request, $cityId)
    {
        $regionDescr = $request->input('regionDescr');
        $regionId = $request->input('regionId');
        $cities = $this->ukrPoshtaService->getCities($regionDescr, $regionId);
        $city = collect($cities)->firstWhere('cityId', $cityId);

        return response()->json($city);
    }

    public function getBranchByRef(Request $request, $branchId)
    {
        $cityId = $request->input('cityId');
        $cityDescr = $request->input('cityDescr');
        $branches = $this->ukrPoshtaService->getBranches($cityId, $cityDescr);
        $branch = collect($branches)->firstWhere('branchId', $branchId);

        return response()->json($branch);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\MeestService;
use App\Services\NovaPoshtaService;
use Illuminate\Http\Request;

class MeestController extends Controller
{
    protected $meestService;

    public function __construct(MeestService $meestService)
    {
        $this->meestService = $meestService;
    }

    public function index()
    {
        $meestService = new MeestService();
        $regions = $meestService->getRegions();

        return view('site.example.meest.index', compact('regions'));
    }

    public function getCities(Request $request)
    {
        $regionDescr = $request->input('regionName');
        $regionId = $request->input('regionId');

        $cities = $this->meestService->getCities($regionDescr, $regionId);

        return response()->json($cities);
    }

    public function getBranches(Request $request)
    {
        $cityDescr = $request->input('cityDescr');
        $cityId = $request->input('cityId');

        $branches = $this->meestService->getBranches($cityDescr, $cityId);

        return response()->json($branches);
    }

    public function getCityByRef(Request $request, $cityId)
    {
        $regionDescr = $request->input('regionDescr');
        $regionId = $request->input('regionId');
        $cities = $this->meestService->getCities($regionDescr, $regionId);
        $city = collect($cities)->firstWhere('cityId', $cityId);

        return response()->json($city);
    }

    public function getBranchByRef(Request $request, $branchId)
    {
        $cityId = $request->input('cityId');
        $cityDescr = $request->input('cityDescr');
        $branches = $this->meestService->getBranches($cityId, $cityDescr);
        $branch = collect($branches)->firstWhere('branchId', $branchId);

        return response()->json($branch);
    }
}

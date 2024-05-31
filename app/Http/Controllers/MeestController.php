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
}

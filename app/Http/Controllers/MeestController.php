<?php

namespace App\Http\Controllers;

use App\Models\MeestCity;
use App\Models\MeestRegion;
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
        $regionId = $request->input('regionId');

        $region = MeestRegion::where('region_id', $regionId)->first();
        $cities = $region->cities()->get();

        return response()->json($cities);
    }

    public function getBranches(Request $request)
    {
        $cityId = $request->input('cityId');

        $city = MeestCity::where('city_id', $cityId)->first();

        $branches = $city->branches()->get();

        return response()->json($branches);
    }
}

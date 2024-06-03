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
}

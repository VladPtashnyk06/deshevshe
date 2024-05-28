<?php

namespace App\Http\Controllers;

use App\Services\NovaPoshtaService;
use Illuminate\Http\Request;

class DeliveryServiceController extends Controller
{
    protected $novaPoshtaService;

    public function __construct(NovaPoshtaService $novaPoshtaService)
    {
        $this->novaPoshtaService = $novaPoshtaService;
    }

    public function index()
    {
        $regions = $this->novaPoshtaService->getRegions();

        return view('site.example.index', compact('regions'));
    }

    public function getCities(Request $request)
    {
        $regionRef = $request->input('region');

        $cities = $this->novaPoshtaService->getCities($regionRef);

        return response()->json($cities);
    }

    public function getBranches(Request $request)
    {
        $cityRef = $request->input('city');
        $categoryOfWarehouse = $request->input('categoryOfWarehouse');

        $branches = $this->novaPoshtaService->getBranches($cityRef, $categoryOfWarehouse);

        return response()->json($branches);
    }
}

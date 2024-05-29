<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MeestService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.meest.api_key');
    }

    public function getRegions()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.meest.com/v3.0/openAPI/regionSearch', [
            'filters' => [
                'regionID' => '',
                'regionKATUU' => '',
                'regionDescr' => '',
                'countryID' => 'c35b6195-4ea3-11de-8591-001d600938f8',
                'countryDescr' => 'УКРАЇНА'
            ]
        ]);

        return $response->json()['result'];
    }

    public function getCities($regionDescr, $regionId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.meest.com/v3.0/openAPI/citySearch', [
            'filters' => [
                'cityID' => '',
                'cityKATUU'=> '',
                'cityDescr'=> '',
                'districtID'=> '',
                'districtDescr'=> '',
                'countryID'=> 'c35b6195-4ea3-11de-8591-001d600938f8',
                'regionID'=> $regionId,
                'regionDescr'=> $regionDescr,
                'isDeliveryInCity'=> true,
                'IsBranchInCity'=> true
            ]
        ]);

        return $response->json()['result'];
    }

    public function getBranches($cityDescr, $cityId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.meest.com/v3.0/openAPI/branchSearch', [
            'filters' => [
                'cityId' => $cityId,
                'cityDescr' => $cityDescr,
            ],
        ]);

        return $response->json()['result'];
    }
}

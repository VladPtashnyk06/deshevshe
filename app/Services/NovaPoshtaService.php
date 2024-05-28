<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NovaPoshtaService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.novaposhta.api_key');
    }

    public function getRegions()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'Address',
            'calledMethod' => 'getAreas',
        ]);

        return $response->json()['data'];
    }

    public function getCities($regionRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'Address',
            'calledMethod' => 'getCities',
            'methodProperties' => [
                'AreaRef' => $regionRef,
            ],
        ]);

        return $response->json()['data'];
    }

    public function getBranches($cityRef, $categoryOfWarehouse)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'CityRef' => $cityRef,
                'CategoryOfWarehouse' => $categoryOfWarehouse,
            ],
        ]);

        return $response->json()['data'];
    }
}

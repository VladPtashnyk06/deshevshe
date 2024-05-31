<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UkrPoshtaService
{
    protected $apiKey;
    public function __construct()
    {
        $this->apiKey = config('services.ukrposhta.api_key');
    }

    public function getRegions()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get('https://www.ukrposhta.ua/address-classifier-ws/get_regions_by_region_ua');

        return $response->json()['Entries']['Entry'];
    }

    public function getCities($regionId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get('https://www.ukrposhta.ua/address-classifier-ws/get_city_by_region_id_and_district_id_and_city_ua', [
            'region_id' => $regionId,
        ]);

        return $response->json()['Entries']['Entry'];
    }

    public function getBranches($cityId)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get('https://www.ukrposhta.ua/address-classifier-ws/get_postoffices_by_postcode_cityid_cityvpzid', [
            'city_id' => $cityId,
        ]);

        return $response->json()['Entries']['Entry'];
    }
}

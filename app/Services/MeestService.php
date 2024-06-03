<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MeestService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.meest.api_url');
        $this->apiKey = $this->getCachedToken();
    }

    private function getToken()
    {
        $username = config('services.meest.username');
        $password = config('services.meest.password');

        $response = Http::post("{$this->apiUrl}/auth", [
            'username' => $username,
            'password' => $password
        ]);

        if ($response->successful()) {

            $data = $response->json()['result'];
            $token = $data['token'];

            Cache::put('meest_token', $token, 86400);
            Cache::put('meest_token_created_at', now(), 86400);

            return $token;
        }
        return false;
    }

    private function getCachedToken()
    {
        $token = Cache::get('meest_token');
        $tokenCreatedAt = Cache::get('meest_token_created_at');

        if ($token && $tokenCreatedAt) {
            $tokenAge = now()->diffInSeconds(Carbon::parse($tokenCreatedAt));

            if ($tokenAge < 82800) {
                return $token;
            }
        }

        return $this->getToken();
    }

    public function getRegions()
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->apiUrl}/regionSearch", [
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
        ])->post("{$this->apiUrl}/citySearch", [
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
        ])->post("{$this->apiUrl}/branchSearch", [
            'filters' => [
                'cityId' => $cityId,
                'cityDescr' => $cityDescr,
            ],
        ]);

        return $response->json()['result'];
    }
}

<?php

namespace App\Services;

use App\Http\Controllers\Site\OrderController;
use App\Http\Controllers\UkrPoshtaController;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UkrPoshtaService
{
    protected $apiKey;
    protected $token;
    public function __construct()
    {
        $this->apiKey = config('services.ukrposhta.api_key');
//        $this->apiKey = '3d3b0242-3f14-3118-9765-968f8ca3fb2d';
        $this->token = 'ec6e7fbc-8a93-4008-bcca-d5500aa5c43c';
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

    public function getStreetByCityId($cityId, $street = "")
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get('https://www.ukrposhta.ua/address-classifier-ws/get_street_by_region_id_and_district_id_and_city_id_and_street_ua?region_id={regionId}&district_id={districtId}&city_id='.$cityId.'&street_ua='.$street.'');

        return $response->json()['Entries']['Entry'];
    }

    public function getPostcodes($streetId, $houseNumber)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get('https://www.ukrposhta.ua/address-classifier-ws/get_addr_house_by_street_id?street_id='.$streetId.'&housenumber='.$houseNumber);

        return $response->json()['Entries']['Entry'];
    }


    function createAddress($postcode, $city, $street, $houseNumber, $apartmentNumber) {
        $response = Http::withHeaders([
            'accept' => '*/*',
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post('https://dev.ukrposhta.ua/ecom/0.0.1/addresses', [
            'postcode' => $postcode,
            'city' => $city,
            'street' => $street,
            'houseNumber' => $houseNumber,
            'apartmentNumber' => $apartmentNumber,
        ]);

        return $response->json();
    }

    function createClient($type, $name, $firstName, $lastName, $middleName, $addressId, $phoneNumber, $edrpou) {
        $response = Http::withHeaders([
            'accept' => '*/*',
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post("https://dev.ukrposhta.ua/ecom/0.0.1/clients?token=" . $this->token, [
            'type' => $type,
            'name' => $name,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'middleName' => $middleName,
            'addressId' => $addressId,
            'phoneNumber' => (string)$phoneNumber,
            'edrpou' => $edrpou
        ]);

        return $response->json();
    }

    function getClientByPhone($phoneNumber) {
        $response = Http::withHeaders([
            'accept' => '*/*',
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])->get('https://dev.ukrposhta.ua/ecom/0.0.1/clients/phone', [
            'countryISO3166' => 'UA',
            'phoneNumber' => $phoneNumber,
            'token' => $this->token,
        ]);

        return $response->json();
    }

    function createShipment($senderUuid, $recipientUuid, $type, $deliveryType, $weight, $length, $width, $height, $price, $description) {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://dev.ukrposhta.ua/ecom/0.0.1/shipments?token=' . $this->token, [
            'sender' => [
                'uuid' => $senderUuid
            ],
            'recipient' => [
                'uuid' => $recipientUuid
            ],
            'type' => $type,
            'deliveryType' => $deliveryType,
            'postPay' => $price,
            'paidByRecipient' => 'true',
            'description' => $description,
            'parcels' => [[
                'weight' => $weight,
                'length' => $length,
                'width' => $width,
                'height' => $height,
                'declaredPrice' => $price
            ]]
        ]);

        return $response->json();
    }

    public function ttnPdf(Order $order)
    {
        $orderRef = $order->ref;
        $url = "https://www.ukrposhta.ua/ecom/0.0.1/shipments/$orderRef/sticker?token=$this->token";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to retrieve the PDF sticker'], $response->status());
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf');
    }
    public function destroy(Order $order)
    {
        $orderRef = $order->ref;
        $url = "https://dev.ukrposhta.ua/ecom/0.0.1/shipments/$orderRef?token=$this->token";

        $response = Http::withHeaders([
            'accept' => '*/*',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->delete($url);

        return response()->json(['error' => 'Failed to delete the shipment'], $response->status());
    }

}

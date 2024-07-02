<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getSettlementAreas',
        ]);

        return $response->json()['data'];
    }

    public function getDistricts($regionRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getSettlementCountryRegion',
            'methodProperties' => [
                'AreaRef' => $regionRef,
            ],
        ]);

        return $response->json()['data'];
    }

    public function getBranchesVillages()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'SettlementRef' => '',
            ],
        ]);

        return $response->json()['data'];
    }

    public function getVillages($districtRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getSettlements',
            'methodProperties' => [
                'RegionRef' => $districtRef,
                'Warehouse' => '1'
            ],
        ]);

        return $response->json()['data'];
    }

    public function getCities($regionRef, $findByString)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getSettlements',
            'methodProperties' => [
                'AreaRef' => $regionRef,
                'FindByString' => $findByString,
                'Warehouse' => '1',
                'Limit' => '1460',
                'Page' => '1'
            ],
        ]);

        return $response->json()['data'];
    }

    public function getCitiesByString($cityName)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'searchSettlements',
            'methodProperties' => [
                'CityName' => $cityName,
                'Page' => '1'
            ],
        ]);

        return $response->json()['data'];
    }

    public function getStreets($cityRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getStreet',
            'methodProperties' => [
                'CityRef' => $cityRef,
                'FindByString' => '',
            ],
        ]);

        return $response->json()['data'];
    }

    public function getDocumentList()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'InternetDocumentGeneral',
            'calledMethod' => 'getDocumentList',
            'methodProperties' => [
                'DateTimeFrom' => date('d.m.Y'),
                'DateTimeTo' => date('d.m.Y'),
                'GetFullList' => '1',
            ],
        ]);

        return $response->json()['data'];
    }

    public function getBranches($cityRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'SettlementRef' => $cityRef,
            ],
        ]);

        return $response->json()['data'];
    }

    public function getRef($cityName)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getCities',
            'methodProperties' => [
                'FindByString' => $cityName,
                'Page' => '1',
            ],
        ]);

        return $response->json()['data'];
    }

    public function getSenders()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'CounterpartyGeneral',
            'calledMethod' => 'getCounterparties',
            'methodProperties' => [
                'CounterpartyProperty' => 'Sender',
            ],
        ]);

        return $response->json()['data'];
    }

    public function getCounterpartyContactPersons($ref)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'CounterpartyGeneral',
            'calledMethod' => 'getCounterpartyContactPersons',
            'methodProperties' => [
                'Ref' => $ref,
                'Page' => '1'
            ],
        ]);

        return $response->json()['data'];
    }
    public function getWarehouses($cityRef)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getWarehouses',
            'methodProperties' => [
                'CityRef' => $cityRef,
            ],
        ]);

        return $response->json()['data'];
    }

    public function storeTTNForBranchOrCourier($payerType, $volumeGeneral, $weight, $serviceType, $description, $cost, $citySender, $senderRef, $senderAddress, $contactSender, $recipientsPhone, $recipientCityName, $recipientArea, $recipientAreaRegions, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $settlementType, $afterpaymentOnGoodsCost){
        $recipientNameParts = explode(' ', $recipientName, 2);
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            "modelName"  => "InternetDocumentGeneral",
            "calledMethod" => "save",
            "methodProperties" => [
                "PayerType" => $payerType,
                "PaymentMethod" => "Cash",
                "DateTime" => now()->format('d.m.Y'),
                "CargoType" => 'Parcel',
                "VolumeGeneral" => $volumeGeneral,
                "Weight" => $weight,
                "ServiceType" => $serviceType,
                "SeatsAmount" => "1",
                "Description" => $description,
                "Cost" => $cost,
                "CitySender" => $citySender,
                "Sender" => $senderRef,
                "SenderAddress" => $senderAddress,
                "ContactSender" => $contactSender,
                "SendersPhone" => "380673130651",
                "RecipientsPhone" => $recipientsPhone,
                "NewAddress" => "1",
                "RecipientCityName" => $recipientCityName,
                "RecipientArea" => $recipientArea,
                "RecipientAreaRegions" => $recipientAreaRegions,
                "RecipientAddressName" => $recipientAddressName,
                "RecipientHouse" => $recipientHouse,
                "RecipientFlat" => $recipientFlat,
                "RecipientName" => $recipientName,
                "RecipientType" => $recipientType,
                "SettlementType" => $settlementType,
                "OwnershipForm" => "",
                "RecipientContactName" => "",
                "EDRPOU" => "",
                "AfterpaymentOnGoodsCost" => $afterpaymentOnGoodsCost,
                "ContactRecipient" => [[
                    "FirstName" => $recipientNameParts[0],
                    "LastName" => $recipientNameParts[1] ?? ''
                ]]
            ]
        ]);

        return $response->json();
    }

    public function storeTTNForPostomat($payerType, $weight, $serviceType, $description, $cost, $citySender, $senderRef, $senderAddress, $contactSender, $recipientsPhone, $recipientCityName, $recipientArea, $recipientAreaRegions, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $settlementType, $volumeGeneral, $volumetricWidth, $volumetricLength, $volumetricHeight, $afterpaymentOnGoodsCost){
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            "modelName"  => "InternetDocumentGeneral",
            "calledMethod" => "save",
            "methodProperties" => [
                "PayerType" => $payerType,
                "PaymentMethod" => "Cash",
                "DateTime" => now()->format('d.m.Y'),
                "CargoType" => 'Parcel',
                "Weight" => $weight,
                "ServiceType" => $serviceType,
                "SeatsAmount" => "1",
                "Description" => $description,
                "Cost" => $cost,
                "CitySender" => $citySender,
                "Sender" => $senderRef,
                "SenderAddress" => $senderAddress,
                "ContactSender" => $contactSender,
                "SendersPhone" => "380673130651",
                "RecipientsPhone" => $recipientsPhone,
                "NewAddress" => "1",
                "RecipientCityName" => $recipientCityName,
                "RecipientArea" => $recipientArea,
                "RecipientAreaRegions" => $recipientAreaRegions,
                "RecipientAddressName" => $recipientAddressName,
                "RecipientHouse" => $recipientHouse,
                "RecipientFlat" => $recipientFlat,
                "RecipientName" => $recipientName,
                "RecipientType" => $recipientType,
                "SettlementType" => $settlementType,
                "OwnershipForm" => "",
                "RecipientContactName" => "",
                "EDRPOU" => "",
                "OptionsSeat" => [[
                    "volumetricVolume" => $volumeGeneral,
                    "volumetricWidth" => $volumetricWidth,
                    "volumetricLength" => $volumetricLength,
                    "volumetricHeight" => $volumetricHeight,
                    "weight" => $weight,
                ]],
                "AfterpaymentOnGoodsCost" => $afterpaymentOnGoodsCost,
                "ContactRecipient" => ''
            ]
        ]);

        return $response->json();
    }

    public function ttnPdf(Order $order)
    {
        $orderRef = $order->ref;
        $url = "https://my.novaposhta.ua/orders/printMarking100x100/orders[]/$orderRef/type/pdf/apiKey/$this->apiKey/zebra";

        return redirect()->to($url);
    }

    public function destroy($refTTN)
    {
        Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            "modelName"  => "InternetDocumentGeneral",
            "calledMethod" => "delete",
            "methodProperties" => [
                "DocumentRefs" => $refTTN
            ]
        ]);
    }
}

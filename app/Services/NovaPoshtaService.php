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

    public function getDocumentList()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            'modelName' => 'InternetDocumentGeneral',
            'calledMethod' => 'getDocumentList',
            'methodProperties' => [
                'DateTimeFrom' => '12.06.2024',
                'DateTimeTo' => '12.06.2024',
                'GetFullList' => '1',
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

    public function storeTTNForBranchOrCourier($payerType, $volumeGeneral, $weight, $serviceType, $description, $cost, $recipientsPhone, $recipientCityName, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $afterpaymentOnGoodsCost){
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            "modelName"  => "InternetDocumentGeneral",
            "calledMethod" => "save",
            "methodProperties" => [
                "PayerType" => $payerType,
                "PaymentMethod" => "Cash",
                "DateTime" => now()->format('d.m.Y'),
                "CargoType" => "Cargo",
                "VolumeGeneral" => $volumeGeneral,
                "Weight" => $weight,
                "ServiceType" => $serviceType,
                "SeatsAmount" => "1",
                "Description" => $description,
                "Cost" => $cost,
                "CitySender" => "e71f8e8f-4b33-11e4-ab6d-005056801329",
                "Sender" => "7fabb148-938f-11ee-a60f-48df37b921db",
                "SenderAddress" => "0d545f60-e1c2-11e3-8c4a-0050568002cf",
                "ContactSender" => "093f2700-940f-11ee-a60f-48df37b921db",
                "SendersPhone" => "380673130651",
                "RecipientsPhone" => $recipientsPhone,
                "NewAddress" => "1",
                "RecipientCityName" => $recipientCityName,
                "RecipientArea" => "",
                "RecipientAreaRegions" => "",
                "RecipientAddressName" => $recipientAddressName,
                "RecipientHouse" => $recipientHouse,
                "RecipientFlat" => $recipientFlat,
                "RecipientName" => $recipientName,
                "RecipientType" => $recipientType,
                "SettlementType" => "місто",
                "OwnershipForm" => "",
                "RecipientContactName" => "",
                "EDRPOU" => "",
                "AfterpaymentOnGoodsCost" => $afterpaymentOnGoodsCost
            ]
        ]);

        return $response->json();
    }

    public function storeTTNForPostomat($payerType, $weight, $serviceType, $description, $cost, $recipientsPhone, $recipientCityName, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $volumeGeneral, $volumetricWidth, $volumetricLength, $volumetricHeight){
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            "modelName"  => "InternetDocumentGeneral",
            "calledMethod" => "save",
            "methodProperties" => [
                "PayerType" => $payerType,
                "PaymentMethod" => "Cash",
                "DateTime" => now()->format('d.m.Y'),
                "CargoType" => "Cargo",
                "Weight" => $weight,
                "ServiceType" => $serviceType,
                "SeatsAmount" => "1",
                "Description" => $description,
                "Cost" => $cost,
                "CitySender" => "e71f8e8f-4b33-11e4-ab6d-005056801329",
                "Sender" => "7fabb148-938f-11ee-a60f-48df37b921db",
                "SenderAddress" => "0d545f60-e1c2-11e3-8c4a-0050568002cf",
                "ContactSender" => "093f2700-940f-11ee-a60f-48df37b921db",
                "SendersPhone" => "380673130651",
                "RecipientsPhone" => $recipientsPhone,
                "NewAddress" => "1",
                "RecipientCityName" => $recipientCityName,
                "RecipientArea" => "",
                "RecipientAreaRegions" => "",
                "RecipientAddressName" => $recipientAddressName,
                "RecipientHouse" => $recipientHouse,
                "RecipientFlat" => $recipientFlat,
                "RecipientName" => $recipientName,
                "RecipientType" => $recipientType,
                "SettlementType" => "місто",
                "OwnershipForm" => "",
                "RecipientContactName" => "",
                "EDRPOU" => "",
                "OptionsSeat" => [
                    "volumetricVolume" => $volumeGeneral,
                    "volumetricWidth" => $volumetricWidth,
                    "volumetricLength" => $volumetricLength,
                    "volumetricHeight" => $volumetricHeight,
                    "weight" => $weight,
                ]
            ]
        ]);

        return $response->json();
    }

    public function ttnPdf(Order $order)
    {
        $orderId = $order->int_doc_number;
        $url = "https://my.novaposhta.ua/orders/printDocument/orders[]/" . $orderId . "/type/pdf/apiKey/$this->apiKey";

        return redirect()->to($url);
    }

    public function destroy($refTTN)
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $this->apiKey,
            "modelName"  => "InternetDocumentGeneral",
            "calledMethod" => "delete",
            "methodProperties" => [
                "DocumentRefs" => $refTTN
            ]
        ]);
    }
}

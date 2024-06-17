<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Services\NovaPoshtaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NovaPoshtaController extends Controller
{
    protected $novaPoshtaService;

    public function __construct(NovaPoshtaService $novaPoshtaService)
    {
        $this->novaPoshtaService = $novaPoshtaService;
    }

    public function getCities(Request $request)
    {
        $regionRef = $request->input('region');

        $cities = $this->novaPoshtaService->getCities($regionRef);

        return response()->json($cities);
    }

    public function getCitiesByName(Request $request)
    {
        $cityName = $request->input('city_name');

        $citiesByName = $this->novaPoshtaService->getCitiesByString($cityName);

        return response()->json($citiesByName);
    }

    public function getBranches(Request $request)
    {
        $cityRef = $request->input('city');
        $categoryOfWarehouse = $request->input('categoryOfWarehouse');

        $branches = $this->novaPoshtaService->getBranches($cityRef, $categoryOfWarehouse);

        return response()->json($branches);
    }

    public function getDocumentList()
    {
        $documentList = $this->novaPoshtaService->getDocumentList();

        return response()->json($documentList);
    }

    public function getCounterpartyContactPersons(Request $request)
    {
        $senderRef = $request->input('sender_ref');
        $contactPersons = $this->novaPoshtaService->getCounterpartyContactPersons($senderRef);

        return response()->json($contactPersons);
    }

    public function getWarehouses(Request $request)
    {
        $cityRef = $request->input('city_ref_hidden');
        $warehouses = $this->novaPoshtaService->getWarehouses($cityRef);

        return response()->json($warehouses);
    }

    public function createTTN(Order $order)
    {
        $senders = $this->novaPoshtaService->getSenders();
//        dd($senders);
        $delivery = Delivery::where('order_id', $order->id)->first();
        $recipientAddressName = '';
        $recipientHouse = '';
        $recipientFlat = '';
        if ($delivery->delivery_method == 'courier') {
            list($recipientAddressName, $recipientHouse, $recipientFlat) = $this->parseAddress($delivery->address);
        }
        return view('admin.orders.novaPoshta.createTTN', compact('order', 'delivery', 'recipientAddressName', 'recipientHouse', 'recipientFlat', 'senders'));
    }

    public function storeTTN(Request $request, NovaPoshtaService $novaPoshtaService, Delivery $delivery)
    {
        if ($request->post('order_id')) {
            $order = Order::find($request->post('order_id'));
        }
        if (isset($order)) {
            if ($order->cost_delivery == 'За Ваш рахунок') {
                $payerType = 'Recipient';
            } else {
                $payerType = 'Sender';
            }
            if (isset($order->total_price)) {
                $cost = $order->total_price;
            }
            if (isset($order->user_phone)) {
                $recipientsPhone = $order->user_phone;
            }
        }
        if (!empty($request->post('width')) && !empty($request->post('height')) && !empty($request->post('length'))) {
            $volumetricWidth =  $request->post('width') / 100;
            $volumetricLength = $request->post('height') / 100;
            $volumetricHeight = $request->post('length') / 100;
            $volumetricVolume = $request->post('width') * $request->post('height') * $request->post('length');
            $volumeGeneral = $volumetricWidth * $volumetricLength * $volumetricHeight;
        }
        if (!empty($request->post('weight'))) {
            $weight = strval($request->post('weight'));
        }
        if ($delivery->delivery_method == 'courier') {
            $serviceType = "WarehouseDoors";
            if ($request->post('recipient_address_name')) {
                $recipientAddressName = 'вул. '. $request->post('recipient_address_name');
            }
            if ($request->post('recipient_house')) {
                $recipientHouse = $request->post('recipient_house');
            }
            if ($request->post('recipient_flat')) {
                $recipientFlat = $request->post('recipient_flat');
            }
        } else {
            $serviceType = 'WarehouseWarehouse';
            $recipientAddressName = $this->extractBranchNumber($delivery->branch);
            $recipientHouse = '';
            $recipientFlat = '';
        }
        if ($request->post('description')) {
            $description = $request->post('description');
        }
        if (isset($delivery->city)) {
            $recipientCityName = $delivery->city;
        }
        if (isset($order->user_name) && isset($order->user_last_name)) {
//            $recipientName = $order->user_name .' '. $order->user_last_name;
            $recipientName = 'Тест Тест';
        }
        if ($request->post('recipient_type')) {
            $recipientType = $request->post('recipient_type');
        }
        if ($order->paymentMethod->title == 'Оплата при доставці') {
            $afterpaymentOnGoodsCost = $order->total_price;
        } else {
            $afterpaymentOnGoodsCost = '';
        }
        if ($request->post('sender_ref')) {
            $senderRef = $request->post('sender_ref');
        }
        if ($request->post('city_ref_hidden')) {
            $citySender = $request->post('city_ref_hidden');
        }
        if ($request->post('contacts_person_ref')) {
            $contactSender = $request->post('contacts_person_ref');
        }
        if ($request->post('sender_address')) {
            $senderAddress = $request->post('sender_address');
        }
        if ($delivery->delivery_method == 'postomat') {
            $response = $novaPoshtaService->storeTTNForPostomat($payerType, $weight, $serviceType, $description, $cost, $citySender, $senderRef, $senderAddress, $contactSender, $recipientsPhone, $recipientCityName, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $volumeGeneral, $volumetricWidth, $volumetricLength, $volumetricHeight, $afterpaymentOnGoodsCost);
        } else {
            $response = $novaPoshtaService->storeTTNForBranchOrCourier($payerType, $volumeGeneral, $weight, $serviceType, $description, $cost, $citySender, $senderRef, $senderAddress, $contactSender, $recipientsPhone, $recipientCityName, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $afterpaymentOnGoodsCost);
        }

        if (isset($response) && $response && $response['data'][0]['Ref']) {
            $order->update([
                'int_doc_number' => $response['data'][0]['IntDocNumber'],
                'ref' => $response['data'][0]['Ref']
            ]);
        }

        return $response;
    }

    public function thankTTN(Order $order)
    {
        return view('admin.orders.thankTTN', ['order' => $order]);
    }

    private function parseAddress($address)
    {
        $pattern = '/^(.*)\s(\d+),?\s?кв?\s?(\d+)?$/u';
        preg_match($pattern, $address, $matches);

        $street = isset($matches[1]) ? $matches[1] : '';
        $house = isset($matches[2]) ? $matches[2] : '';
        $flat = isset($matches[3]) ? $matches[3] : '';

        return [$street, $house, $flat];
    }

    function extractBranchNumber($branch) {
        if (preg_match('/№(\d+)/', $branch, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function ttnPdf(NovaPoshtaService $novaPoshtaService, Order $order)
    {
        return $novaPoshtaService->ttnPdf($order);
    }

    public function destroy(NovaPoshtaService $novaPoshtaService, Order $order)
    {
        $novaPoshtaService->destroy($order->ref);
        $order->update([
            'ref' => '',
            'int_doc_number' => ''
        ]);
        return redirect()->back();
    }
}

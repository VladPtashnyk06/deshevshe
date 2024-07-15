<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\NovaPoshtaDistrict;
use App\Models\NovaPoshtaSettlement;
use App\Models\NovaPoshtaRegion;
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
        $regionRef = $request->input('region_ref');
        $region = NovaPoshtaRegion::where('ref', $regionRef)->first();
        $cities = $region->cities()->get();

        return response()->json($cities);
    }

    public function getCitiesByName(Request $request)
    {
        $cityName = $request->input('city_name');

        $citiesByName = $this->novaPoshtaService->getCitiesByString($cityName);

        return response()->json($citiesByName);
    }

    public function getStreets(Request $request)
    {
        $cityName = $request->input('city_name');

        $ref = $this->novaPoshtaService->getRef($cityName);

        $streets = $this->novaPoshtaService->getStreets($ref[0]['Ref']);

        return response()->json($streets);
    }

    public function getBranches(Request $request)
    {
        $cityRef = $request->input('city_ref');
        $settlementType = $request->input('settlementType');

        if ($settlementType === 'місто') {
            $city = NovaPoshtaSettlement::where('ref', $cityRef)->first();
            return response()->json($city);
        } else {
            $city = NovaPoshtaSettlement::where('ref', $cityRef)->first();
        }

//        $branches = $city->warehouses()->get();
//
//        return response()->json($branches);

        if ($city) {
            $branches = $city->warehouses()->get();
            return response()->json($branches);
        } else {
            return response()->json(['error' => 'City not found'], 404);
        }
    }

    public function getDistricts(Request $request)
    {
        $regionRef = $request->input('region_ref');
        $region = NovaPoshtaRegion::where('ref', $regionRef)->first();
        $districts = $region->districts()->get();

        return response()->json($districts);
    }

    public function getVillages(Request $request)
    {
        $districtRef = $request->input('district_ref');

        $district = NovaPoshtaDistrict::where('ref', $districtRef)->first();

        $villages = $district->villages()->get();

        return response()->json($villages);
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
        $delivery = Delivery::where('order_id', $order->id)->first();

        return view('admin.orders.novaPoshta.createTTN', compact('order', 'delivery', 'senders'));
    }

    public function storeTTN(Request $request, NovaPoshtaService $novaPoshtaService, Delivery $delivery)
    {
        if ($request->post('order_id')) {
            $order = Order::find($request->post('order_id'));
        }
        if (isset($order)) {
            $payerType = ($order->cost_delivery == 'За Ваш рахунок') ? 'Recipient' : 'Sender';
            $cost = $order->total_price ?? null;
            $recipientsPhone = $order->user_phone ?? null;
        }

        if (!empty($request->post('width')) && !empty($request->post('height')) && !empty($request->post('length'))) {
            $volumetricWidth =  $request->post('width') / 100;
            $volumetricLength = $request->post('height') / 100;
            $volumetricHeight = $request->post('length') / 100;
            $volumeGeneral = $volumetricWidth * $volumetricLength * $volumetricHeight;
        }
        $weight = !empty($request->post('weight')) ? strval($request->post('weight')) : '';
        $recipientArea = $delivery->region;
        $recipientAreaRegions = $delivery->district ? $delivery->district : '';
        $recipientCityName = $delivery->city ? $delivery->city : (stripos($delivery->village, 'село ') === 0 ? str_replace('село ', '', $delivery->village) : (stripos($delivery->village, 'селище міського типу ') === 0 ? str_replace('селище міського типу ', '', $delivery->village) : ''));
        if ($delivery->delivery_method == 'courier') {
            $serviceType = "WarehouseDoors";
            $recipientAddressName = $delivery->street;
            $recipientHouse = $delivery->house;
            $recipientFlat = $delivery->flat ? $delivery->flat : '';
        } else {
            $serviceType = 'WarehouseWarehouse';
            $recipientAddressName = $delivery->branchNumber;
            $recipientHouse = '';
            $recipientFlat = '';
        }

        $description = $request->post('description') ?? '';

//        $recipientName = $order->user_name && $order->user_last_name ? $order->user_name .' '. $order->user_last_name : 'Тест Тест';
        $recipientName = 'Влад Пташник';
        if ($request->post('recipient_type')) {
            $recipientType = $request->post('recipient_type');
        }
        $afterpaymentOnGoodsCost = ($order->paymentMethod->title == 'Оплата при доставці') ? $order->total_price : '';

        $senderRef = $request->post('sender_ref') ?? '';
        $citySender = $request->post('city_ref_hidden') ?? '';
        $contactSender = $request->post('contacts_person_ref') ?? '';
        $senderAddress = $request->post('sender_address') ?? '';
        $settlementType = $delivery->village ? $this->getSettlementType($delivery->village) : 'місто';

        if ($delivery->delivery_method == 'postomat') {
            $response = $novaPoshtaService->storeTTNForPostomat($payerType, $weight, $serviceType, $description, $cost, $citySender, $senderRef, $senderAddress, $contactSender, $recipientsPhone, $recipientCityName, $recipientArea, $recipientAreaRegions, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $settlementType, $volumeGeneral, $volumetricWidth, $volumetricLength, $volumetricHeight, $afterpaymentOnGoodsCost);
        } else {
            $response = $novaPoshtaService->storeTTNForBranchOrCourier($payerType, $volumeGeneral, $weight, $serviceType, $description, $cost, $citySender, $senderRef, $senderAddress, $contactSender, $recipientsPhone, $recipientCityName, $recipientArea, $recipientAreaRegions, $recipientAddressName, $recipientHouse, $recipientFlat, $recipientName, $recipientType, $settlementType, $afterpaymentOnGoodsCost);
        }

        if (isset($response) && $response && $response['data'][0]['Ref']) {
            $order->update([
                'int_doc_number' => $response['data'][0]['IntDocNumber'],
                'ref' => $response['data'][0]['Ref']
            ]);
        }

        return $response;
    }

    function getSettlementType($village) {
        if (strpos($village, 'село') !== false) {
            return 'село';
        } elseif (strpos($village, 'селище міського типу') !== false) {
            return 'селище міського типу';
        } else {
            return 'місто';
        }
    }

    public function thankTTN(Order $order)
    {
        return view('admin.orders.thankTTN', ['order' => $order]);
    }

    public function ttnPdf(NovaPoshtaService $novaPoshtaService, Order $order)
    {
        return $novaPoshtaService->ttnPdf($order);
    }

    public function destroy(NovaPoshtaService $novaPoshtaService, Order $order)
    {
        $novaPoshtaService->destroy($order->ref);
        $order->update([
            'ref' => null,
            'int_doc_number' => null
        ]);
        return redirect()->back();
    }
}

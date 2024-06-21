<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Services\MeestService;
use App\Services\NovaPoshtaService;
use App\Services\UkrPoshtaService;
use Illuminate\Http\Request;

class UkrPoshtaController extends Controller
{
    protected $ukrPoshtaService;

    public function __construct(UkrPoshtaService $ukrPoshtaService)
    {
        $this->ukrPoshtaService = $ukrPoshtaService;
    }

    public function getCities(Request $request)
    {
        $districtId = $request->input('district_id');
        $regionId = $request->input('region_id');
        $cityUa = $request->input('city_ua', '');
        $koatuu = $request->input('koatuu', '');
        $katottg = $request->input('katottg', '');

        $cities = $this->ukrPoshtaService->getCities($districtId, $regionId, $cityUa, $koatuu, $katottg);

        return response()->json($cities);
    }

    public function getBranches(Request $request)
    {
        $cityId = $request->input('cityId');

        $branches = $this->ukrPoshtaService->getBranches($cityId);

        return response()->json($branches);
    }

    public function getDistricts(Request $request)
    {
        $regionId = $request->input('regionId');

        $districts = $this->ukrPoshtaService->getDistricts($regionId);

        return response()->json($districts);
    }

    public function getStreetByCityId(Request $request)
    {
        $cityId = $request->input('cityId');
        $street = '';

        return $this->ukrPoshtaService->getStreetByCityId($cityId, $street);
    }

    public function getPostcodes($streetId, $houseNumber)
    {
        return $this->ukrPoshtaService->getPostcodes($streetId, $houseNumber);
    }

    public function storeAddressForSender(UkrPoshtaService $ukrPoshtaService, $postcode, $city)
    {
        return $ukrPoshtaService->createAddress($postcode, $city, '', '', '');
    }

    public function storeAddressForClient(UkrPoshtaService $ukrPoshtaService, Delivery $delivery)
    {
        $city = $delivery->city ? $delivery->city : '';
        $street = $delivery->street ? $delivery->street : '';
        $streetId = $delivery->streetRef ? $delivery->streetRef : '';
        $houseNumber = $delivery->house ? $delivery->house : '';
        $apartmentNumber = $delivery->flat ? $delivery->flat : '';
        if ($streetId && $houseNumber) {
            $postcode = $this->getPostcodes($streetId, $houseNumber)[0]['POSTCODE'];
        }

        return $ukrPoshtaService->createAddress($postcode, $city, $street, $houseNumber, $apartmentNumber);
    }

    public function getSenderByPhone(Request $request, Order $order)
    {
        $phone = $request->input('sender_phone');
        if ($phone) {
            if (!str_starts_with($phone, '+380')) {
                if (str_starts_with($phone, '0')) {
                    $request->merge([
                        'sender_phone' => '+38' . $phone,
                    ]);
                } else {
                    $request->merge([
                        'sender_phone' => '+380' . $phone,
                    ]);
                }
            }
        }
        $request->validate([
            'sender_phone' => ['required', 'regex:/^\+380(39|67|68|96|97|98|50|66|95|99|63|73|93)\d{7}$/'],
        ]);
        $phone = $request->input('sender_phone');
        if ($phone) {
            $sender = $this->ukrPoshtaService->getClientByPhone($phone);
//            dd($sender);
            if (!empty($sender) && $sender[0]) {
                if ($sender[0]['type'] == 'COMPANY') {
                    $sender = $sender[0];
                    return view('admin.orders.ukrPoshta.createTTN', compact('sender', 'phone', 'order'));
                }
            }
        }
        $sender = false;
        return view('admin.orders.ukrPoshta.createTTN', compact('sender', 'phone', 'order'));
    }

    public function getClientByPhone($clientPhone)
    {
        if ($clientPhone) {
            $client = $this->ukrPoshtaService->getClientByPhone($clientPhone);
            if (!empty($client) && $client[0]) {
                if ($client[0]['type'] == 'INDIVIDUAL') {
                    return $client[0];
                }
            }
        }
        return false;
    }

    public function storeSender(UkrPoshtaService $ukrPoshtaService, $name, $addressId, $phoneNumber, $edrpou)
    {
        return $ukrPoshtaService->createClient('COMPANY', $name, '', '', '', $addressId, $phoneNumber , $edrpou);
    }

    public function storeClient(UkrPoshtaService $ukrPoshtaService, $firstName, $lastName, $middleName, $addressId, $phoneNumber)
    {
        return $ukrPoshtaService->createClient('INDIVIDUAL', '', $firstName, $lastName, $middleName, $addressId, $phoneNumber , '');
    }

    public function storeTTN(Request $request, UkrPoshtaService $ukrPoshtaService, Delivery $delivery)
    {
        $request->validate([
            'width' => 'required|numeric|min:1',
            'length' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1|max:30',
            'description' => 'nullable|string',
            'sender_postcode' => 'nullable|numeric',
            'sender_city' => 'nullable|string',
            'sender_name' => 'nullable|string',
            'sender_phone_number' => 'nullable|string',
            'sender_edrpou' => 'nullable|numeric',
            'sender_uuid' => 'nullable|uuid',
        ]);

        $senderUUID = $request->post('sender_uuid');
        if (empty($senderUUID)) {
            $senderPostcode = $request->post('sender_postcode');
            $senderCity = $request->post('sender_city');
            if (!$senderPostcode || !$senderCity) {
                return response()->json(['error' => 'Sender address is required'], 400);
            }

            try {
                $senderAddress = $this->storeAddressForSender($ukrPoshtaService, $senderPostcode, $senderCity);
                $senderAddressId = $senderAddress['id'];
                $senderName = $request->post('sender_name');
                $senderPhoneNumber = $request->post('sender_phone_number');
                $senderEDRPOU = $request->post('sender_edrpou');
                $sender = $this->storeSender($ukrPoshtaService, $senderName, $senderAddressId, $senderPhoneNumber, $senderEDRPOU);
                $senderUUID = $sender['uuid'];
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to create sender: ' . $e->getMessage()], 500);
            }
        }

        $clientPhone = $delivery->order->user_phone;
        $cleanedPhoneNumber = str_replace('+', '', $clientPhone);

        try {
            $client = $this->getClientByPhone($cleanedPhoneNumber);
            if ($client) {
                $clientUUID = $client['uuid'];
            } else {
                $clientAddress = $this->storeAddressForClient($ukrPoshtaService, $delivery);
                $clientAddressId = $clientAddress['id'];
                $clientFirstName = $delivery->order->user_name;
                $clientLastName = $delivery->order->user_last_name;
                $clientMiddleName = $delivery->order->user_middle_name;
                $clientPhoneNumber = $delivery->order->user_phone;
                $client = $this->storeClient($ukrPoshtaService, $clientFirstName, $clientLastName, $clientMiddleName, $clientAddressId, $clientPhoneNumber);
                $clientUUID = $client['uuid'];
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to process client: ' . $e->getMessage()], 500);
        }

        $type = in_array($delivery->delivery_method, ['exspresCourier', 'exspresDelivery']) ? 'EXPRESS' : 'STANDARD';
        $deliveryType = in_array($delivery->delivery_method, ['branch', 'exspresBranch']) ? 'W2W' : 'W2D';

        $weight = $request->post('weight') * 100;
        $length = $request->post('length');
        $width = $request->post('width');
        $height = $request->post('height');
        $price = $delivery->order->total_price;
        $description = $request->post('description');

        $response = $ukrPoshtaService->createShipment($senderUUID, $clientUUID, $type, $deliveryType, $weight, $length, $width, $height, $price, $description);

        if (isset($response) && $response && $response['uuid']) {
            $delivery->order->update([
                'ref' => $response['uuid']
            ]);
        }

        return $response;
    }

    public function thankTTN(Order $order)
    {
        return view('admin.orders.thankTTN', ['order' => $order]);
    }

    public function ttnPdf(UkrPoshtaService $ukrPoshtaService, Order $order)
    {
        return $ukrPoshtaService->ttnPdf($order);
    }

    public function destroy(UkrPoshtaService $ukrPoshtaService, Order $order)
    {
        $response = $ukrPoshtaService->destroy($order);
        if ($response) {
            $order->update([
                'int_doc_number' => null,
                'ref' => null
            ]);
        }

        return redirect()->back();
    }
}

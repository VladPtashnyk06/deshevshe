<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class UpdateOrders extends Command
{
    protected $signature = 'orders:update';
    protected $description = 'Update orders with document information from Nova Poshta';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $apiKey = config('services.novaposhta.api_key');
        $today = date('d.m.Y');

        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => $apiKey,
            'modelName' => 'InternetDocumentGeneral',
            'calledMethod' => 'getDocumentList',
            'methodProperties' => [
                'DateTimeFrom' => $today,
                'DateTimeTo' => $today,
                'GetFullList' => '1',
            ],
        ]);

        $documents = $response->json()['data'];

        foreach ($documents as $document) {
            $recipientPhone = $document['RecipientContactPhone'];
            $intDocNumber = $document['IntDocNumber'];
            $intDocNumberRef = $document['Ref'];

            $this->info($recipientPhone .' '. $intDocNumber);

            $order = Order::where('user_phone',  '+'.$recipientPhone)->first();

            $this->info($order);

            if ($order) {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update(['int_doc_number' => $intDocNumber, 'ref' => $intDocNumberRef]);
            }
        }

        $this->info('Orders updated successfully.');
    }
}

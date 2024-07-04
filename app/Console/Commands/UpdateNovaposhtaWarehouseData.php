<?php

namespace App\Console\Commands;

use App\Models\NovaPoshtaWarehouse;
use Illuminate\Console\Command;
use App\Models\NovaPoshtaRegion;
use App\Models\NovaPoshtaDistrict;
use App\Models\NovaPoshtaSettlement;
use Illuminate\Support\Facades\Http;

class UpdateNovaposhtaWarehouseData extends Command
{
    protected $signature = 'novaposhta:warehouse-update-data';
    protected $description = 'Update Novaposhta data';

    public function handle()
    {
        $this->updateWarehouses();
        $this->info('Novaposhta Warehouse data updated successfully');
    }

    public function updateWarehouses()
    {
        $settlements = NovaPoshtaSettlement::all();
        $timeout = 120;
        $limit = 500;
        $maxRetries = 5;

        foreach ($settlements as $settlement) {
            $page = 1;
            $hasMoreData = true;

            while ($hasMoreData) {
                $attempts = 0;

                while ($attempts < $maxRetries) {
                    try {
                        $response = Http::timeout($timeout)->post('https://api.novaposhta.ua/v2.0/json/', [
                            'apiKey' => config('services.novaposhta.api_key'),
                            'modelName' => 'AddressGeneral',
                            'calledMethod' => 'getWarehouses',
                            'methodProperties' => [
                                'SettlementRef' => $settlement->ref,
                                'Page' => $page,
                                'Limit' => $limit,
                            ],
                        ]);

                        if ($response->successful()) {
                            $warehouses = $response->json()['data'];

                            if (count($warehouses) < $limit) {
                                $hasMoreData = false;
                            } else {
                                $page++;
                            }

                            foreach ($warehouses as $warehouse) {
                                NovaPoshtaWarehouse::updateOrCreate(
                                    [
                                        'ref' => $warehouse['Ref'],
                                    ],
                                    [
                                        'settlement_id' => $settlement->id,
                                        'description' => $warehouse['Description'],
                                        'short_address' => $warehouse['ShortAddress'],
                                        'type_of_warehouse' => $warehouse['TypeOfWarehouse'],
                                        'number' => $warehouse['Number'],
                                    ]
                                );
                            }
                            break;
                        } else {
                            throw new \Exception('Неуспішна відповідь');
                        }
                    } catch (\Exception $e) {
                        $attempts++;
                        \Log::error('Не вдалося оновити склади', [
                            'settlement' => $settlement->ref,
                            'page' => $page,
                            'attempt' => $attempts,
                            'error' => $e->getMessage(),
                        ]);

                        sleep(pow(2, $attempts));
                    }
                }

                if ($attempts >= $maxRetries) {
                    \Log::error('Досягнуто максимальну кількість повторних спроб. Перехід до наступного населеного пункту.', [
                        'settlement' => $settlement->ref,
                        'page' => $page,
                    ]);
                    $hasMoreData = false;
                }
            }
        }
    }

}

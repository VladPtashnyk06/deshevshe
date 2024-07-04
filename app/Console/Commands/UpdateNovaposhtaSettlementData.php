<?php

namespace App\Console\Commands;

use App\Models\NovaPoshtaWarehouse;
use Illuminate\Console\Command;
use App\Models\NovaPoshtaRegion;
use App\Models\NovaPoshtaDistrict;
use App\Models\NovaPoshtaSettlement;
use Illuminate\Support\Facades\Http;

class UpdateNovaposhtaSettlementData extends Command
{
    protected $signature = 'novaposhta:settlement-update-data';
    protected $description = 'Update Novaposhta Settlement data';

    public function handle()
    {
        $this->updateCities();
        $this->updateOtherSettlements();
        $this->info('Novaposhta data updated successfully');
    }

    private function updateCities()
    {
        $regions = NovaPoshtaRegion::all();
        $timeout = 120;
        $limit = 1500;
        $maxRetries = 5;

        foreach ($regions as $region) {
            $page = 1;
            $hasMoreData = true;

            while ($hasMoreData) {
                $attempts = 0;

                while ($attempts < $maxRetries) {
                    try {
                        $response = Http::timeout($timeout)->post('https://api.novaposhta.ua/v2.0/json/', [
                            'apiKey' => config('services.novaposhta.api_key'),
                            'modelName' => 'AddressGeneral',
                            'calledMethod' => 'getSettlements',
                            'methodProperties' => [
                                'AreaRef' => $region->ref,
                                'Warehouse' => '1',
                                'Page' => $page,
                                'Limit' => $limit,
                            ],
                        ]);

                        if ($response->successful()) {
                            $cities = $response->json()['data'];

                            foreach ($cities as $city) {
                                if ($city['SettlementTypeDescription'] == 'місто') {
                                    NovaPoshtaSettlement::updateOrCreate(
                                        [
                                            'ref' => $city['Ref'],
                                        ],
                                        [
                                            'region_id' => $region->id,
                                            'description' => $city['Description'],
                                            'settlement_type_description' => $city['SettlementTypeDescription'],
                                        ]
                                    );
                                }
                            }

                            if (count($cities) < $limit) {
                                $hasMoreData = false;
                            } else {
                                $page++;
                            }

                            break;
                        } else {
                            throw new \Exception('Неуспішна відповідь');
                        }
                    } catch (\Exception $e) {
                        $attempts++;
                        \Log::error('Не вдалося оновити міста', [
                            'region' => $region->ref,
                            'page' => $page,
                            'attempt' => $attempts,
                            'error' => $e->getMessage(),
                        ]);

                        sleep(pow(2, $attempts));
                    }
                }

                if ($attempts >= $maxRetries) {
                    \Log::error('Досягнуто максимальну кількість повторних спроб. Перехід до наступного регіону.', [
                        'region' => $region->ref,
                        'page' => $page,
                    ]);
                    $hasMoreData = false;
                }
            }
        }

        $this->info('Nova Poshta cities updated successfully.');
    }

    private function updateOtherSettlements()
    {
        $regions = NovaPoshtaRegion::all();
        $timeout = 120;
        $limit = 150;
        $maxRetries = 5;

        foreach ($regions as $region) {
            $districts = $region->districts()->get();

            foreach ($districts as $district) {
                $page = 1;
                $hasMoreData = true;

                while ($hasMoreData) {
                    $attempts = 0;

                    while ($attempts < $maxRetries) {
                        try {
                            $response = Http::timeout($timeout)->post('https://api.novaposhta.ua/v2.0/json/', [
                                'apiKey' => config('services.novaposhta.api_key'),
                                'modelName' => 'AddressGeneral',
                                'calledMethod' => 'getSettlements',
                                'methodProperties' => [
                                    'AreaRef' => $region->ref,
                                    'RegionRef' => $district->ref,
                                    'Warehouse' => '1',
                                    'Page' => $page,
                                    'Limit' => $limit,
                                ],
                            ]);

                            if ($response->successful()) {
                                $settlements = $response->json()['data'];

                                foreach ($settlements as $settlement) {
                                    if ($settlement['SettlementTypeDescription'] != 'місто') {
                                        NovaPoshtaSettlement::updateOrCreate(
                                            [
                                                'ref' => $settlement['Ref'],
                                            ],
                                            [
                                                'region_id' => $region->id,
                                                'district_id' => $district->id,
                                                'description' => $settlement['Description'],
                                                'settlement_type_description' => $settlement['SettlementTypeDescription'],
                                            ]
                                        );
                                    }
                                }

                                if (count($settlements) < $limit) {
                                    $hasMoreData = false;
                                } else {
                                    $page++;
                                }

                                break;
                            } else {
                                throw new \Exception('Неуспішна відповідь');
                            }
                        } catch (\Exception $e) {
                            $attempts++;
                            \Log::error('Не вдалося оновити інші населені пункти', [
                                'region' => $region->ref,
                                'district' => $district->ref,
                                'page' => $page,
                                'attempt' => $attempts,
                                'error' => $e->getMessage(),
                            ]);

                            sleep(pow(2, $attempts));
                        }
                    }

                    if ($attempts >= $maxRetries) {
                        \Log::error('Досягнуто максимальну кількість повторних спроб. Перехід до наступного району.', [
                            'region' => $region->ref,
                            'district' => $district->ref,
                            'page' => $page,
                        ]);
                        $hasMoreData = false;
                    }
                }
            }
        }

        $this->info('Nova Poshta settlements updated successfully.');
    }
}

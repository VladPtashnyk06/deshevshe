<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NovaPoshtaRegion;
use App\Models\NovaPoshtaDistrict;
use Illuminate\Support\Facades\Http;

class UpdateNovaposhtaData extends Command
{
    protected $signature = 'novaposhta:update-data';
    protected $description = 'Update Novaposhta data';

    public function handle()
    {
        $this->updateRegions();
        $this->updateDistricts();
        $this->info('Novaposhta data updated successfully');
    }

    private function updateRegions()
    {
        $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
            'apiKey' => config('services.novaposhta.api_key'),
            'modelName' => 'AddressGeneral',
            'calledMethod' => 'getSettlementAreas',
        ]);

        $regions = $response->json()['data'];

        foreach ($regions as $region) {
            NovaPoshtaRegion::updateOrCreate(
                [
                    'ref' => $region['Ref'],
                ],
                [
                    'description' => $region['Description'],
                ]
            );
        }
    }

    private function updateDistricts()
    {
        $regions = NovaPoshtaRegion::all();

        foreach ($regions as $region) {
            $response = Http::post('https://api.novaposhta.ua/v2.0/json/', [
                'apiKey' => config('services.novaposhta.api_key'),
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getSettlementCountryRegion',
                'methodProperties' => [
                    'AreaRef' => $region->ref,
                ],
            ]);

            $districts = $response->json()['data'];
            foreach ($districts as $district) {
                NovaPoshtaDistrict::updateOrCreate(
                    [
                        'ref' => $district['Ref'],
                    ],
                    [
                        'region_id' => $region->id,
                        'description' => $district['Description'],
                    ]
                );
            }
        }
    }
}

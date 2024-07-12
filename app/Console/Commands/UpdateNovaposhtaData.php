<?php

namespace App\Console\Commands;

use App\Services\NovaPoshtaService;
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
        $novaPoshtaService = new NovaPoshtaService;
        $regions = $novaPoshtaService->getRegions();

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
        $novaPoshtaService = new NovaPoshtaService;

        foreach ($regions as $region) {
            $districts = $novaPoshtaService->getDistricts($region->ref);
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

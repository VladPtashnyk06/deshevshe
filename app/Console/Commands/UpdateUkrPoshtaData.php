<?php

namespace App\Console\Commands;

use App\Models\UkrPoshtaBranch;
use App\Models\UkrPoshtaDistrict;
use App\Models\UkrPoshtaRegion;
use App\Models\UkrPoshtaSettlement;
use App\Services\UkrPoshtaService;
use Illuminate\Console\Command;

class UpdateUkrPoshtaData extends Command
{
    protected $signature = 'ukrposhta:update-data';
    protected $description = 'Update Ukr Poshta data';

    public function handle()
    {
        $this->updateRegions();
        $this->updateDistricts();
        $this->updateSettlements();
        $this->updateBranches();
        $this->info('Meest data updated successfully');
    }

    private function updateRegions()
    {
        $ukrPoshta = new UkrPoshtaService();
        $regions = $ukrPoshta->getRegions();

        foreach ($regions as $region) {
            UkrPoshtaRegion::updateOrCreate(
                [
                    'region_id' => $region['REGION_ID'],
                ],
                [
                    'description' => $region['REGION_UA']
                ]
            );
        }
        $this->info('UkrPoshta regions updated successfully.');
    }

    public function updateDistricts()
    {
        $regions = UkrPoshtaRegion::all();

        foreach ($regions as $region) {
            $ukrPoshta = new UkrPoshtaService();
            $cities = $ukrPoshta->getDistricts($region->region_id);

            foreach ($cities as $city) {
                UkrPoshtaDistrict::updateOrCreate(
                    [
                        'district_id' => $city['DISTRICT_ID'],
                    ],
                    [
                        'region_id' => $region->id,
                        'description' => $city['DISTRICT_UA'],
                    ]
                );
            }

        }

        $this->info('UkrPoshta districts updated successfully.');
    }

    private function updateSettlements()
    {
        $regions = UkrPoshtaRegion::all();

        foreach ($regions as $region) {
            $districts = $region->districts()->get();

            foreach ($districts as $district) {
                $ukrPoshta = new UkrPoshtaService();
                $cities = $ukrPoshta->getCities($district->district_id, $region->region_id);

                foreach ($cities as $city) {
                    UkrPoshtaSettlement::updateOrCreate(
                        [
                            'settlement_id' => $city['CITY_ID'],
                        ],
                        [
                            'region_id' => $region->id,
                            'district_id' => $district->id,
                            'description' => $city['CITY_UA'],
                            'settlement_type' => $city['CITYTYPE_UA'],
                        ]
                    );
                }
            }
        }

        $this->info('UkrPoshta settlements updated successfully.');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\MeestBranch;
use App\Models\MeestCity;
use App\Models\MeestRegion;
use App\Models\NovaPoshtaWarehouse;
use App\Services\MeestService;
use Illuminate\Console\Command;
use App\Models\NovaPoshtaRegion;
use App\Models\NovaPoshtaDistrict;
use App\Models\NovaPoshtaSettlement;
use Illuminate\Support\Facades\Http;

class UpdateMeestData extends Command
{
    protected $signature = 'meest:update-data';
    protected $description = 'Update Meest data';

    public function handle()
    {
        $this->updateRegions();
        $this->updateCities();
        $this->updateWarehouses();
        $this->info('Meest data updated successfully');
    }

    private function updateRegions()
    {
        $meest = new MeestService();
        $regions = $meest->getRegions();

        foreach ($regions as $region) {
            MeestRegion::updateOrCreate(
                [
                    'region_id' => $region['regionID'],
                ],
                [
                    'description' => $region['regionDescr']['descrUA']
                ]
            );
        }
    }

    private function updateCities()
    {
        $regions = MeestRegion::all();

        foreach ($regions as $region) {
            $meest = new MeestService();
            $cities = $meest->getCities($region->description, $region->region_id);

            foreach ($cities as $city) {
                MeestCity::updateOrCreate(
                    [
                        'city_id' => $city['cityID'],
                    ],
                    [
                        'region_id' => $region->id,
                        'city_type' => $city['viewCity'],
                        'description' => $city['cityDescr']['descrUA'],
                    ]
                );
            }

        }

        $this->info('Meest cities updated successfully.');
    }

    public function updateWarehouses()
    {
        $cities = MeestCity::all();

        foreach ($cities as $city) {
            $meest = new MeestService();
            $branches = $meest->getBranches($city->description, $city->city_id);
            foreach ($branches as $branch) {
                MeestBranch::updateOrCreate(
                    [
                        'branch_id' => $branch['branchID'],
                    ],
                    [
                        'city_id' => $city->id,
                        'branch_number' => $branch['branchNumber'],
                        'branch_type' => $branch['branchType'],
                        'branch_type_id' => $branch['branchTypeID'],
                        'description' => $branch['branchDescr']['descrUA'],
                        'network_partner' => $branch['networkPartner'],
                        'address' => $branch['branchDescr']['descrSearchUA'],
                    ]
                );
            }
        }
    }
}

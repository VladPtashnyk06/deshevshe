<?php

namespace App\Console\Commands;

use App\Models\Material;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportMaterialsCsvCommand extends Command
{
    protected $signature = 'import:materials-csv';
    protected $description = 'Import materials from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = '1c_files/materials.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedMaterialsIds = [];
        foreach ($records as $record) {
            $importedMaterialsIds[] = $record['id'];
            Material::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Material::whereNotIn('id', $importedMaterialsIds)->delete();

        $this->info('Materials imported successfully.');
    }
}

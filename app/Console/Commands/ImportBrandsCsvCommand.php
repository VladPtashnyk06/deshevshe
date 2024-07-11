<?php

namespace App\Console\Commands;

use App\Models\Brand;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportBrandsCsvCommand extends Command
{
    protected $signature = 'import:brands-csv';
    protected $description = 'Import brands from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = storage_path('app/1с/brands.csv');

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedBrandIds = [];

        foreach ($records as $record) {
            $importedBrandIds[] = $record['id'];
            Brand::updateOrCreate(
                ['id' => $record['id']],
                [
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Brand::whereNotIn('id', $importedBrandIds)->delete();

        $this->info('Brands imported and cleaned up successfully.');
    }
}

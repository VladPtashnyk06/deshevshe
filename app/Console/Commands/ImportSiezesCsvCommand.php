<?php

namespace App\Console\Commands;

use App\Models\Size;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Reader;

class ImportSiezesCsvCommand extends Command
{
    protected $signature = 'import:sizes-csv';
    protected $description = 'Import categories from CSV file';

    public function handle()
    {
        $filePath = storage_path('app/1с/sizes.csv');

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedSizesIds = [];
        foreach ($records as $record) {
            $importedSizesIds[] = $record['id'];
            Size::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Size::whereNotIn('id', $importedSizesIds)->delete();

        $this->info('Sizes imported successfully.');
    }
}

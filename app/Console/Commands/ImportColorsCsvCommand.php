<?php

namespace App\Console\Commands;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;
use App\Models\Category;

class ImportColorsCsvCommand extends Command
{
    protected $signature = 'import:colors-csv';
    protected $description = 'Import categories from CSV file';

    public function handle()
    {
        $filePath = storage_path('app/1с/colors.csv');

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        foreach ($records as $record) {
            Color::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        $this->info('Colors imported successfully.');
    }
}

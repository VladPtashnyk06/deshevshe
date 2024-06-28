<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;
use App\Models\Category;

class ImportOrdersCsvCommand extends Command
{
    protected $signature = 'import:categories-csv';
    protected $description = 'Import categories from CSV file';

    public function handle()
    {
        $filePath = storage_path('app/1с/categories.csv');

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $records = iterator_to_array($csv->getRecords(['id', 'title', 'parent_id', 'level']));

        foreach ($records as &$record) {
            if ($record['parent_id'] == '') {
                $record['parent_id'] = null;
            }
        }

        foreach ($records as $record) {
            $this->info('Processing category ID: ' . $record['id']);
            Category::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'parent_id' => $record['parent_id'],
                    'level' => $record['level'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        $this->info('Categories imported successfully.');
    }
}

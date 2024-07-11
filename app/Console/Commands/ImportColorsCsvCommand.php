<?php

namespace App\Console\Commands;

use App\Models\Color;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Reader;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedColorsIds = [];
        foreach ($records as $record) {
            $importedColorsIds[] = $record['id'];
            Color::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'title_en' => $this->translateColor($record['title']) ?? null,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Color::whereNotIn('id', $importedColorsIds)->delete();

        $this->info('Colors imported successfully.');
    }

    function translateColor($colorInUkrainian) {
        $tr = new GoogleTranslate('en');
        $tr->setSource('uk');
        return $tr->translate($colorInUkrainian);
    }
}

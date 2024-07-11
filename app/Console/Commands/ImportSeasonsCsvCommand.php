<?php

namespace App\Console\Commands;

use App\Models\Season;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportSeasonsCsvCommand extends Command
{
    protected $signature = 'import:seasons-csv';
    protected $description = 'Import seasons from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = storage_path('app/1с/seasons.csv');

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedSeasonsIds = [];
        foreach ($records as $record) {
            $importedSeasonsIds[] = $record['id'];
            Season::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Season::whereNotIn('id', $importedSeasonsIds)->delete();

        $this->info('Seasons imported successfully.');
    }
}

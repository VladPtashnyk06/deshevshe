<?php

namespace App\Console\Commands;

use App\Models\Style;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportStylesCsvCommand extends Command
{
    protected $signature = 'import:styles-csv';
    protected $description = 'Import styles from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = '1c_files/styles.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedStylesIds = [];
        foreach ($records as $record) {
            $importedStylesIds[] = $record['id'];
            Style::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Style::whereNotIn('id', $importedStylesIds)->delete();

        $this->info('Styles imported successfully.');
    }
}

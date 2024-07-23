<?php

namespace App\Console\Commands;

use App\Models\Fashion;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportFashionsCsvCommand extends Command
{
    protected $signature = 'import:fashions-csv';
    protected $description = 'Import fashions from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = '1c_files/fashions.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedFashionsIds = [];
        foreach ($records as $record) {
            $importedFashionsIds[] = $record['id'];
            Fashion::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Fashion::whereNotIn('id', $importedFashionsIds)->delete();

        $this->info('Fashions imported successfully.');
    }
}

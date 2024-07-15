<?php

namespace App\Console\Commands;

use App\Models\Gender;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportGendersCsvCommand extends Command
{
    protected $signature = 'import:genders-csv';
    protected $description = 'Import genders from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = '1c_files/genders.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedGendersIds = [];
        foreach ($records as $record) {
            $importedGendersIds[] = $record['id'];
            Gender::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Gender::whereNotIn('id', $importedGendersIds)->delete();

        $this->info('Genders imported successfully.');
    }
}

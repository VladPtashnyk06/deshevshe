<?php

namespace App\Console\Commands;

use App\Models\FabricComposition;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class ImportFabricCompositionsCsvCommand extends Command
{
    protected $signature = 'import:compositions-csv';
    protected $description = 'Import compositions from CSV file';

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public function handle()
    {
        $filePath = '1c_files/compositions.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedFabricCompositionsIds = [];
        foreach ($records as $record) {
            $importedFabricCompositionsIds[] = $record['id'];
            FabricComposition::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        FabricComposition::whereNotIn('id', $importedFabricCompositionsIds)->delete();

        $this->info('Compositions imported successfully.');
    }
}

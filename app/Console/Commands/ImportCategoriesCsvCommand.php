<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Reader;
use App\Models\Category;

class ImportCategoriesCsvCommand extends Command
{
    protected $signature = 'import:categories-csv';
    protected $description = 'Import categories from CSV file';

    public function handle()
    {
        $filePath = '1c_files/categories.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return ;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title', 'parent_id', 'level']));

        $importedCategoriesIds = [];
        foreach ($records as $category) {
            $importedCategoriesIds[] = $category['id'];
            Category::updateOrCreate(
                ['id' => $category['id']],
                [
                    'id' => $category['id'],
                    'title' => $category['title'],
                    'parent_id' => $category['parent_id'] == '' ? null : $category['parent_id'],
                    'level' => $category['level'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Category::whereNotIn('id', $importedCategoriesIds)->delete();

        $this->info('Categories imported successfully.');
    }
}

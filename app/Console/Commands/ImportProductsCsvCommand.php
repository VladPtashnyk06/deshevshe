<?php

namespace App\Console\Commands;

use App\Models\Characteristic;
use App\Models\Price;
use App\Models\Producer;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use App\Models\Product;

class ImportProductsCsvCommand extends Command
{
    protected $signature = 'import:products-csv';
    protected $description = 'Import products from CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filePath = storage_path('app/1с/goods.csv');

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(['product_code', 'model', 'title', 'category_id', 'quantity', 'img', 'length', 'width', 'price', 'producer', 'color_id', 'img_color', 'size_id']);

        foreach ($records as $record) {
            Producer::updateOrCreate(
                ['title' => $record['producer']]
            );
            $characteristic = Characteristic::updateOrCreate(
                ['width' => $record['width'], 'length' => $record['length']],
            );
            $product = Product::updateOrCreate(
                ['code' => $record['product_code'],'characteristic_id' => $characteristic->id, 'title' => $record['title']],
                [
                    'category_id' => $record['category_id'],
                    'producer_id' => '2',
                    'status_id' => 1,
                    'package_id' => null,
                    'material_id' => 1,
                    'description' => '',
                    'model' => $record['model'] == '' ? null : $record['model'],
                ]
            );
            ProductVariant::updateOrCreate(
                [
                'product_id' => $product->id,
                'color_id' => $record['color_id'],
                'size_id' => $record['size_id'],
                ],
                ['quantity' => $record['quantity']]
            );
            Price::updateOrCreate(
                ['product_id' => $product->id],
                ['retail' => $record['price']]
            );
        }

        $this->info('Products imported successfully.');
    }
}

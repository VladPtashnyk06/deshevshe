<?php

namespace App\Console\Commands;

use App\Models\Characteristic;
use App\Models\Price;
use App\Models\Producer;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
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
        $filePath = '1c_files/goods.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['product_code', 'model', 'title', 'category_id', 'quantity', 'img', 'length', 'width', 'price', 'producer', 'color_id', 'img_color', 'size_id', 'material_id', 'style_id', 'season_id', 'fashion_id', 'fabric_composition_id', 'gender_id', 'brand_id']));

        $importedProductCodes = [];
        $importedProductVariantKeys = [];

        foreach ($records as $record) {
            $importedProductCodes[] = $record['product_code'];
            $producer = Producer::updateOrCreate(
                ['title' => $record['producer']]
            );

            $characteristic = Characteristic::updateOrCreate(
                ['width' => $record['width'], 'length' => $record['length']]
            );

            $product = Product::updateOrCreate(
                ['code' => $record['product_code']],
                [
                    'characteristic_id' => $characteristic->id,
                    'title' => $record['title'],
                    'category_id' => $record['category_id'],
                    'producer_id' => $producer->id,
                    'status_id' => 1,
                    'material_id' => $record['material_id'] !== '' ? $record['material_id'] : null,
                    'brand_id' => $record['brand_id'] !== '' ? $record['brand_id'] : null,
                    'style_id' => $record['style_id'] !== '' ? $record['style_id'] : null,
                    'season_id' => $record['season_id'] !== '' ? $record['season_id'] : null,
                    'fashion_id' => $record['fashion_id'] !== '' ? $record['fashion_id'] : null,
                    'fabric_composition_id' => $record['fabric_composition_id'] !== '' ? $record['fabric_composition_id'] : null,
                    'gender_id' => $record['gender_id'] !== '' ? $record['gender_id'] : null,
                    'img_path' => $record['img'] !== '' ? $record['img'] : null,
                ]
            );

            $importedProductVariantKeys[$product->id][] = $record['color_id'] . '_' . $record['size_id'];

            ProductVariant::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'color_id' => $record['color_id'],
                    'size_id' => $record['size_id']
                ],
                ['quantity' => $record['quantity']]
            );

            Price::updateOrCreate(
                ['product_id' => $product->id],
                ['retail' => $record['price']]
            );
        }

        $productsToDelete = Product::whereNotIn('code', $importedProductCodes)->get();
        foreach ($productsToDelete as $product) {
            $product->delete();
        }

        foreach ($importedProductVariantKeys as $productId => $variantKeys) {
            $existingVariants = ProductVariant::where('product_id', $productId)->get();
            foreach ($existingVariants as $variant) {
                $variantKey = $variant->color_id . '_' . $variant->size_id;
                if (!in_array($variantKey, $variantKeys)) {
                    $variant->delete();
                }
            }
        }

        $this->info('Products and product variants imported and cleaned up successfully.');
    }
}

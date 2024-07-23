<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\FabricComposition;
use App\Models\Fashion;
use App\Models\Gender;
use App\Models\Material;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Season;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Console\Command;
use Carbon\Carbon;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ImportProductDataCsvCommand extends Command
{
    protected $signature = 'import:product-data';
    protected $description = 'Import product-data from CSVs file';

    /**
     * @return void
     */
    public function handle()
    {
        $this->importBrands();
        $this->importCategories();
        $this->importColors();
        $this->importFashions();
        $this->importGenders();
        $this->importMaterials();
        $this->importFabricComposition();
        $this->importSeasons();
        $this->importSizes();
        $this->importStyles();
        $this->importProducts();
        $this->info('All import.');
    }

    public function importBrands()
    {
        $filePath = '1c_files/brands.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedBrandIds = [];

        foreach ($records as $record) {
            $importedBrandIds[] = $record['id'];
            Brand::updateOrCreate(
                ['id' => $record['id']],
                [
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Brand::whereNotIn('id', $importedBrandIds)->delete();

        $this->info('Brands imported and cleaned up successfully.');
    }

    public function importCategories()
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

    public function importColors()
    {
        $filePath = '1c_files/colors.csv';

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

    public function importSizes()
    {
        $filePath = '1c_files/sizes.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedSizesIds = [];
        foreach ($records as $record) {
            $importedSizesIds[] = $record['id'];
            Size::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Size::whereNotIn('id', $importedSizesIds)->delete();

        $this->info('Sizes imported successfully.');
    }

    public function importFabricComposition()
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

    public function importFashions()
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

    public function importGenders()
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

    public function importMaterials()
    {
        $filePath = '1c_files/materials.csv';

        if (!file_exists($filePath)) {
            $this->error('CSV file not found.');
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');

        $records = iterator_to_array($csv->getRecords(['id', 'title']));

        $importedMaterialsIds = [];
        foreach ($records as $record) {
            $importedMaterialsIds[] = $record['id'];
            Material::updateOrCreate(
                ['id' => $record['id']],
                [
                    'id' => $record['id'],
                    'title' => $record['title'],
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                ]
            );
        }

        Material::whereNotIn('id', $importedMaterialsIds)->delete();

        $this->info('Materials imported successfully.');
    }

    public function importSeasons()
    {
        $filePath = '1c_files/seasons.csv';

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

    public function importStyles()
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

    public function importProducts()
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
                [
                    'quantity' => $record['quantity'],
                    'img_path' => $record['img_color'],
                ]
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

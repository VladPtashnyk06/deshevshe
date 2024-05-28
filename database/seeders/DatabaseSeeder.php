<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\DeliveryMethod;
use App\Models\DeliveryService;
use App\Models\Material;
use App\Models\OrderStatus;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Region;
use App\Models\Size;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
             'name' => 'Admin',
             'last_name' => 'Admin',
             'phone' => '+380971037978',
             'email' => 'Admin@gmail.com',
             'role' => 'Admin',
             'password' => \Hash::make('admin'),
         ]);
        \App\Models\User::factory()->create([
             'name' => 'User',
             'last_name' => 'User',
             'phone' => '+380686464949',
             'email' => 'User@gmail.com',
             'password' => \Hash::make('user'),
         ]);
        \App\Models\User::factory()->create([
            'name' => 'Operator 1',
            'last_name' => 'Operator 1',
            'phone' => '+380686463838',
            'email' => 'operator@gmail.com',
            'role' => 'Operator',
            'password' => \Hash::make('operator'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Operator 2',
            'last_name' => 'Operator 2',
            'phone' => '+380631198197',
            'email' => 'operator2@gmail.com',
            'role' => 'Operator',
            'password' => \Hash::make('operator'),
        ]);

        //PaymentMethods
        PaymentMethod::create([
            'title' => 'Оплата при доставці'
        ]);
        PaymentMethod::create([
            'title' => 'Банківський переказ'
        ]);

        //Statuses
        Status::create([
            'title' => 'Є у наявності'
        ]);
        Status::create([
            'title' => 'Немає у наявності'
        ]);
        Status::create([
            'title' => 'Скоро буде у наявності'
        ]);

        //Producers
        Producer::create([
            'title' => 'Китай'
        ]);
        Producer::create([
            'title' => 'Україна'
        ]);
        Producer::create([
            'title' => 'Польща'
        ]);

        //Packages
        Package::create([
            'title' => 4
        ]);
        Package::create([
            'title' => 12
        ]);
        Package::create([
            'title' => 10
        ]);
        Package::create([
            'title' => 8
        ]);

        //Materials
        Material::create([
            'title' => 'Тканина'
        ]);
        Material::create([
            'title' => 'Пластик'
        ]);
        Material::create([
            'title' => 'Двухнитка'
        ]);

        //Characteristics
        Characteristic::create([
            'height' => 12,
            'width' => 12,
            'length' => 12,
        ]);
        Characteristic::create([
            'height' => 10,
            'width' => 10,
            'length' => 10,
        ]);
        Characteristic::create([
            'height' => 12,
            'width' => 10,
            'length' => 8,
        ]);

        //Colors
        Color::create([
            'title' => 'Червоний'
        ]);
        Color::create([
            'title' => 'Чорний'
        ]);
        Color::create([
            'title' => 'Білий'
        ]);
        Color::create([
            'title' => 'Сірий'
        ]);
        Color::create([
            'title' => 'Синій'
        ]);

        //Sizes
        Size::create([
            'title' => 'M'
        ]);
        Size::create([
            'title' => 'XL'
        ]);
        Size::create([
            'title' => '2XL'
        ]);
        Size::create([
            'title' => '3XL'
        ]);
        Size::create([
            'title' => '4XL'
        ]);
        Size::create([
            'title' => '14'
        ]);
        Size::create([
            'title' => '28'
        ]);
        Size::create([
            'title' => '33'
        ]);
        Size::create([
            'title' => '46'
        ]);
        Size::create([
            'title' => '48'
        ]);
        Size::create([
            'title' => '50'
        ]);

        //Categories
        Category::create([
            'title' => 'Чоловічий одяг',
            'parent_id' => null,
            'level' => 1,
        ]);
        Category::create([
            'title' => 'Жіночий одяг',
            'parent_id' => null,
            'level' => 1,
        ]);
        Category::create([
            'title' => 'Спортивні штани',
            'parent_id' => 1,
            'level' => 2,
        ]);
        Category::create([
            'title' => 'Футболки "Імпорт"	',
            'parent_id' => 1,
            'level' => 2,
        ]);
        Category::create([
            'title' => 'Джинси"	',
            'parent_id' => 2,
            'level' => 2,
        ]);

        //Blogs
        $newBlog = Blog::create([
            'title' => 'Про нас',
            'description' => 'SUPERPRICE.UA – ЦЕ ОПТОВИЙ ІНТЕРНЕТ-МАГАЗИН. МИ ПРОПОНУЄМО НАШИМ КЛІЄНТАМ УНІКАЛЬНУ ЛІНІЙКУ ТОВАРІВ – ОДЯГ, ВЗУТТЯ, БІЛИЗНА, АКСЕСУАРИ, СУМКИ, РЮКЗАКИ, ТОВАРИ ДЛЯ ДОМУ ТА КУХНІ, ТЕКСТИЛЬ ВІД УКРАЇНСЬКИХ ТА ЗАКОРДОННИХ ВИРОБНИКІВ. МЕНЕДЖЕРИ SUPERPRICE.UA (SUPERЦІНА) НА УКРАЇНСЬКИХ ТА ТУРЕЦЬКИХ СКЛАДАХ КОНТРОЛЮЮТЬ ПРОЦЕС УПАКОВКИ І ЯКОСТІ ТОВАРУ ПЕРЕД ВІДПРАВКОЮ, СПІЛКУЮТЬСЯ ІЗ ПОСТАЧАЛЬНИКАМИ НАПРЯМУ ТА ДОМОВЛЯЮТЬСЯ ПРО НАЙВИГІДНІШУ ЦІНУ. НАША ГОЛОВНА МЕТА – НИЗЬКІ ЦІНИ НА ЯКІСНІ ТОВАРИ.'
        ]);
        $sourcePath = database_path('seeders/images/super price.png');
        $temporaryPath = storage_path('app/temp/super price.png');
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }
        copy($sourcePath, $temporaryPath);
        if (file_exists($temporaryPath)) {
            $newBlog->addMedia($temporaryPath)
                ->withCustomProperties([
                    'alt' => $newBlog->title,
                    'main_image' => 1,
                ])
                ->toMediaCollection('blog'.$newBlog->id);
        } else {
            echo "Файл не знайдено: " . $temporaryPath;
        }

        //OrderStatuses
        OrderStatus::create([
            'title' => 'Нове'
        ]);
        OrderStatus::create([
            'title' => 'В обробці'
        ]);
        OrderStatus::create([
            'title' => 'Пакують'
        ]);
        OrderStatus::create([
            'title' => 'Відравлено'
        ]);
        OrderStatus::create([
            'title' => 'Отримано'
        ]);
        OrderStatus::create([
            'title' => 'Має дозамовити товар'
        ]);
        OrderStatus::create([
            'title' => 'Не відповідає'
        ]);
        OrderStatus::create([
            'title' => 'Неправильні дані'
        ]);
        OrderStatus::create([
            'title' => 'Повернення'
        ]);
        OrderStatus::create([
            'title' => 'Скасоване клієнтом'
        ]);

        //Products
        $newProduct = Product::create([
            'category_id' => 3,
            'producer_id' => 1,
            'status_id' => 1,
            'package_id' => 2,
            'material_id' => 1,
            'title' => 'Чоловічі спортивні штани',
            'description' => 'Чоловічі спортивні штани м.1 1уп. 5шт. р.46-48-50-52-54',
            'code' => 226298,
        ]);
        $sourcePath = database_path('seeders/images/Спортивні штани.jpg');
        $temporaryPath = storage_path('app/temp/Спортивні штани.jpg');
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }
        copy($sourcePath, $temporaryPath);
        if (file_exists($temporaryPath)) {
            $newProduct->addMedia($temporaryPath)
                ->withCustomProperties([
                    'alt' => $newProduct->title,
                    'main_image' => 1,
                ])
                ->toMediaCollection($newProduct->id);
        } else {
            echo "Файл не знайдено: " . $temporaryPath;
        }
        $newProduct = Product::create([
            'category_id' => 3,
            'producer_id' => 1,
            'status_id' => 1,
            'package_id' => 2,
            'material_id' => 1,
            'title' => 'Чоловічі спортивні штани',
            'description' => 'Чоловічі спортивні штани м.2 1уп. 5шт. р.46-48-50-52-54',
            'code' => 226297,
        ]);
        $sourcePath = database_path('seeders/images/Спортивні штани 2.jpg');
        $temporaryPath = storage_path('app/temp/Спортивні штани 2.jpg');
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }
        copy($sourcePath, $temporaryPath);
        if (file_exists($temporaryPath)) {
            $newProduct->addMedia($temporaryPath)
                ->withCustomProperties([
                    'alt' => $newProduct->title,
                    'main_image' => 1,
                ])
                ->toMediaCollection($newProduct->id);
        } else {
            echo "Файл не знайдено: " . $temporaryPath;
        }
        $newProduct = Product::create([
            'category_id' => 4,
            'producer_id' => 2,
            'status_id' => 1,
            'package_id' => 3,
            'material_id' => 1,
            'title' => 'Чоловiча футболка',
            'description' => 'Чоловiча футболка (однотон\батал\кулірка) 1уп. 4шт. р.3XL-4XL-5XL-6XL',
            'code' => 219804,
        ]);
        $sourcePath = database_path('seeders/images/Футболка.jpg');
        $temporaryPath = storage_path('app/temp/Футболка.jpg');
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }
        copy($sourcePath, $temporaryPath);
        if (file_exists($temporaryPath)) {
            $newProduct->addMedia($temporaryPath)
                ->withCustomProperties([
                    'alt' => $newProduct->title,
                    'main_image' => 1,
                ])
                ->toMediaCollection($newProduct->id);
        } else {
            echo "Файл не знайдено: " . $temporaryPath;
        }
        $newProduct = Product::create([
            'category_id' => 5,
            'producer_id' => 1,
            'status_id' => 1,
            'package_id' => 4,
            'material_id' => 1,
            'title' => 'Жіночі джинси',
            'description' => 'Жіночі джинси м.1300 1уп. (6шт) р.28-33',
            'code' => 214110,
        ]);
        $sourcePath = database_path('seeders/images/Джинси.jpg');
        $temporaryPath = storage_path('app/temp/Джинси.jpg');
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }
        copy($sourcePath, $temporaryPath);
        if (file_exists($temporaryPath)) {
            $newProduct->addMedia($temporaryPath)
                ->withCustomProperties([
                    'alt' => $newProduct->title,
                    'main_image' => 1,
                ])
                ->toMediaCollection($newProduct->id);
        } else {
            echo "Файл не знайдено: " . $temporaryPath;
        }

        //ProductVariants
        ProductVariant::create([
            'product_id' => 1,
            'color_id' => 4,
            'size_id' => 9,
            'quantity' => 12,
        ]);
        ProductVariant::create([
            'product_id' => 1,
            'color_id' => 4,
            'size_id' => 10,
            'quantity' => 10,
        ]);
        ProductVariant::create([
            'product_id' => 2,
            'color_id' => 4,
            'size_id' => 11,
            'quantity' => 12,
        ]);
        ProductVariant::create([
            'product_id' => 3,
            'color_id' => 3,
            'size_id' => 4,
            'quantity' => 8,
        ]);
        ProductVariant::create([
            'product_id' => 3,
            'color_id' => 3,
            'size_id' => 5,
            'quantity' => 6,
        ]);
        ProductVariant::create([
            'product_id' => 4,
            'color_id' => 5,
            'size_id' => 7,
            'quantity' => 13,
        ]);
        ProductVariant::create([
            'product_id' => 4,
            'color_id' => 5,
            'size_id' => 8,
            'quantity' => 12,
        ]);
        ProductVariant::create([
            'product_id' => 2,
            'color_id' => 2,
            'size_id' => 10,
            'quantity' => 12,
        ]);

        //Price
        Price::create([
            'product_id' => 1,
            'pair' => 210,
            'rec_pair' => 225,
            'package' => 1050,
            'rec_package' => 1250,
            'retail' => 359
        ]);
        Price::create([
            'product_id' => 2,
            'pair' => 210,
            'rec_pair' => 225,
            'package' => 1050,
            'rec_package' => 1250,
            'retail' => 359
        ]);
        Price::create([
            'product_id' => 3,
            'pair' => 130,
            'rec_pair' => 145,
            'package' => 520,
            'rec_package' => 555,
            'retail' => 349
        ]);
        Price::create([
            'product_id' => 4,
            'pair' => 249,
            'rec_pair' => 256,
            'package' => 1494,
            'rec_package' => 1494,
            'retail' => 1700
        ]);
    }
}

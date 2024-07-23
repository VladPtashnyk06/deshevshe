<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Blog;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Producer;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Адміністратор',
            'last_name' => 'Адміністратор',
            'phone' => '+380971037978',
            'email' => 'Admin@gmail.com',
            'role' => 'Admin',
            'password' => \Hash::make('admin'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Влад',
            'last_name' => 'Пташник',
            'phone' => '+380686464949',
            'email' => 'User@gmail.com',
            'password' => \Hash::make('user'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Артем',
            'last_name' => 'Гаврилюк',
            'phone' => '+380971037979',
            'email' => 'artem@gmail.com',
            'password' => \Hash::make('user'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Миколай',
            'last_name' => 'Кайдаш',
            'phone' => '+380971037980',
            'email' => 'mukola@gmail.com',
            'password' => \Hash::make('user'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Оператор 1',
            'last_name' => 'Оператор 1',
            'phone' => '+380686463838',
            'email' => 'operator@gmail.com',
            'role' => 'Operator',
            'password' => \Hash::make('operator'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Оператор 2',
            'last_name' => 'Оператор 2',
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
                ->toMediaCollection('blog' . $newBlog->id);
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
            'title' => 'Очікування на проплату'
        ]);
        OrderStatus::create([
            'title' => 'Оплачено'
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
            'title' => 'Не оплачено'
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
    }
}

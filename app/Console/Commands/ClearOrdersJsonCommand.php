<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearOrdersJsonCommand extends Command
{

    protected $signature = 'orders:clear-json';
    protected $description = 'Clear the contents of the orders.json file';

    public function handle()
    {
        $filePath = storage_path('app/orders/orders.json');

        if (file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
            $this->info('The orders.json file has been cleared.');
        } else {
            $this->error('The orders.json file does not exist.');
        }
    }
}

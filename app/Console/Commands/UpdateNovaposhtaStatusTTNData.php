<?php

namespace App\Console\Commands;

use App\Mail\OrderClientMail;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Notifications\OrderStatusUpdate;
use App\Services\NovaPoshtaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdateNovaposhtaStatusTTNData extends Command
{
    protected $signature = 'novaposhta:update-status-ttn-data';
    protected $description = 'Update Novaposhta Status TTN data';

    public function handle()
    {
        try {
            $this->updateOrderStatusTTN();
            $this->info('Novaposhta Status TTN data updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating Novaposhta Status TTN data: ' . $e->getMessage());
            $this->error('Error updating Novaposhta Status TTN data. Check logs for more details.');
        }
    }

    private function updateOrderStatusTTN()
    {
        $novaPoshtaService = new NovaPoshtaService;
        $getDocumentList = $novaPoshtaService->getDocumentList();

        foreach ($getDocumentList as $parcel) {
            $order = Order::where('user_phone', '=', '+'.$parcel['RecipientsPhone'])
                ->whereDate('created_at', now()->format('Y-m-d'))
                ->whereNull('int_doc_number')
                ->first();

            if ($order) {
                $orderData = [
                    'int_doc_number' => $parcel['IntDocNumber'],
                    'ref' => $parcel['Ref']
                ];

                if ($parcel['StateName'] == 'У дорозі') {
                    $status = OrderStatus::where('title', '=', 'Відправлено')->first();
                    if ($status) {
                        $orderData['order_status_id'] = $status->id;
                    }
                }

                $order->update($orderData);

                if ($order->orderStatus->title == 'Відправлено') {
                    Mail::to($order->user_email)->send(new OrderClientMail($order));

                    $userPhone = str_replace('+', '', $order->user_phone);
                    $message = "Ваше замовлення було відправлено. Ваша ТТН: {$order->int_doc_number}. Дякуємо Вам за замовлення.";

//                    \File::put(storage_path('logs/laravel.log'), '');
//                    if ($userPhone) {
//                        \Log::info("Відправлене SMS до {$userPhone} з повідомленям: {$message}");
//                        $order->notify(new OrderStatusUpdate($message));
//                    }
                }
            }
        }
    }
}

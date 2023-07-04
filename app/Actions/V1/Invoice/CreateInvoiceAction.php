<?php

namespace App\Actions\V1\Invoice;

use App\Models\Invoice;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateInvoiceAction
{
    public function execute(array $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {

            $invoice = Invoice::query()->create([
                'user_id' => $user->id,
                'receiver_name' => $data['receiver_name'],
                'receiver_email' => $data['receiver_email'],
                'receiver_phone' =>$data['receiver_phone'],
                'due_date' => $data['due_date'],
            ]);

            $invoiceItems = $data['items'];

            $totalAmount = 0;

            foreach ($invoiceItems as $invoiceItem) {
                $item = Item::query()->find($invoiceItem['item_id']);
                $amount = ($invoiceItem['quantity_purchased'] * $item->price);
                $totalAmount += $amount;

                $invoice->items()->attach($item->id, [
                    'quantity_purchased' => $invoiceItem['quantity_purchased'],
                    'amount' => $amount,
                ]);
            }

            $invoice->update(['amount_payable' => $totalAmount]);

            return $invoice;
        });
    }
}

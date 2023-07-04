<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'invoice_code' => $this->invoice_code,
            'amount_payable' => $this->amount_payable,
            'receiver_name' => $this->receiver_name,
            'receiver_email' => $this->receiver_email,
            'receiver_phone' => $this->receiver_phone,
            'created_at' => $this->created_at,
            'due_date' => $this->due_date,
            'updated_at' => $this->updated_at,
            'invoice_items' => ItemResource::collection($this->items),
        ];
    }
}

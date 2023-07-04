<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'quantity' => $this->quantity,
            'amount' => $this->whenPivotLoaded('invoice_item', function () {
                return $this->pivot->amount;
            }),
            'quantity_purchased' => $this->whenPivotLoaded('invoice_item', function () {
                return $this->pivot->quantity_purchased;
            }),
        ];
    }
}

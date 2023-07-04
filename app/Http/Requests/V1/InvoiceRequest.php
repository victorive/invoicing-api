<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'receiver_name' => ['required'],
            'receiver_email' => ['required', 'email'],
            'receiver_phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/',],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'items.*.item_id' => ['required', 'distinct:strict', 'exists:items,id'],
            'items.*.quantity_purchased' => ['required', 'integer'],
        ];
    }
}

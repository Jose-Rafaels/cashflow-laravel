<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PaymentMethod;

class PaymentMethodRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'method_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Membersihkan nama metode (tanpa spasi dan case-insensitive)
                    $methodName = strtolower(trim($value));

                    // Periksa apakah ada metode pembayaran dengan nama yang sama (case-insensitive dan tanpa spasi)
                    $existingMethod = PaymentMethod::whereRaw('LOWER(REPLACE(method_name, " ", "")) = ?', [strtolower(str_replace(' ', '', $methodName))])->first();

                    if ($existingMethod) {
                        $fail('Metode pembayaran ini sudah ada.');
                    }
                },
            ],
        ];
    }
}

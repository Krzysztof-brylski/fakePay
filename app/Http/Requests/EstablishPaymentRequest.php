<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablishPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'originUrl'=>'required|string|max:100',
            'statusUpdateUrl'=>'required|string|max:100',
            'toPay'=>'required',
            'clientEmail'=>'required|string|max:50',
        ];
    }
}

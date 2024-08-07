<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTransactionRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'timestamp' => 'required|date_format:Y-m-d\TH:i:s.v\Z'
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'O campo amount é obrigatório.',
            'amount.numeric' => 'O campo amount deve ser preenchido com dados numéricos.',
            'timestamp.required' => 'O campo timestamp é obrigatório.',
            'timestamp.date_format' => 'O campo timestamp não esta no formato necessário.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 400));
    }
}

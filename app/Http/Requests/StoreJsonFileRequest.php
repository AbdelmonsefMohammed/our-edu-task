<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Treblle\Tools\Http\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

final class StoreJsonFileRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'file' => ['required','file','mimes:json'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], Status::UNPROCESSABLE_CONTENT->value));
    }

}

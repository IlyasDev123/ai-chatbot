<?php

namespace App\Domains\LeafLetMap\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeafLetMapRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => 'required|string'
        ];
    }
}

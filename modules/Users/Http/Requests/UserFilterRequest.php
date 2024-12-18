<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|alpha_num|min:1',
            'page' => 'nullable|integer|min:1',
            'order' => 'nullable|string|in:asc,desc',
            'col' => 'nullable|alpha_num|in:name,email',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Ошибка в параметрах фильтра',
            'errors' => $validator->errors(),
        ], 422));
    }
}

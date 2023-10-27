<?php

namespace App\Http\Requests\Api\Votes;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterRecordRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'filters' => 'nullable|array',
            'filters.voting_booth_id' => 'nullable|exists:voting_booths,id',
            'filters.number_table' => 'nullable|array'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'code' => 422,
            'errors' => $validator->errors(),
            'message' => 'Incorrect data validation'
        ], 422));
    }
}

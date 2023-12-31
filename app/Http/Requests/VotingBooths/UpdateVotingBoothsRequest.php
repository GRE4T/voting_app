<?php

namespace App\Http\Requests\VotingBooths;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVotingBoothsRequest extends FormRequest
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
            'name' =>'required|string|max:255',
            'number_tables' =>'required|integer|min:0|max:50',
        ];
    }
}

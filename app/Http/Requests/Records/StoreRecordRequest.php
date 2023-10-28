<?php

namespace App\Http\Requests\Records;

use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

class StoreRecordRequest extends FormRequest
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
            'voting_booth_id' => 'required|exists:voting_booths,id',
            'image' =>'nullable|image',
            'number_table' => 'required|integer',
            'votes' => 'required|array',
            'votes.*.*' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $params = explode('.', $attribute);
                    $party = Party::where('id', $params[1])->first();
                    if(!$party || $params[2] > $party->number_candidates) {
                        $fail('Invalido');
                    }
                }
            ]
        ];
    }

/*    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'code' => 422,
            'errors' => $validator->errors(),
            'message' => 'Incorrect data validation'
        ], 422));
    }*/
}

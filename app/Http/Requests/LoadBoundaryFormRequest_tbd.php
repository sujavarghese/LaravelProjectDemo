<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadBoundaryFormRequest extends FormRequest
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
            'selBoundaryType' => 'required',
            'selBoundaryName' => 'required',
            'boundaryCsvFile' => 'required',
            'chkAgreeBoundaryLoader' => 'required'
        ];
    }
}

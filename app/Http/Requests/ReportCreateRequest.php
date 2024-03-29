<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportCreateRequest extends FormRequest
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
            'fingerprint' => 'required|max:255',
            'url' => 'required|url|max:255',
            'highlighted' => 'required|max:255',
            'description' => 'nullable|max:255',
            'type' => 'required|max:12'
        ];
    }
}

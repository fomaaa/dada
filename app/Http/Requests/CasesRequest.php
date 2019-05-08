<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class CasesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ru' => 'required',
            'title_en' => 'required',
            'url'   => array(
                        'required',
                'regex:/^[A-Za-z0-9][A-Za-z0-9\d-]*$/',
                       )
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title_ru.required' => __('errors.crudTitleRuRequired'),
            'title_en.required' => __('errors.crudTitleRuRequired'),
            'url.regex' => __('errors.crudUrlRegex'),
            'url.required' => __('errors.crudUrlRequired'),
            //
        ];
    }
}

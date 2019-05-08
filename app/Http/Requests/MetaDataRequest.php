<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MetaDataRequest extends FormRequest
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
            'description_ru' => 'required',
            'description_en' => 'required',
            'image' => 'required',
            // 'name' => 'required|min:5|max:255'
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

            'title_ru.required' => __('errors.crudMetaTitleRuRequired'),
            'title_en.required' => __('errors.crudMetaTitleEnRequired'),
            'description_ru.required' => __('errors.crudMetaDescriptionRuRequired'),
            'description_en.required' => __('errors.crudMetaDescriptionEnRequired'),
            'image.required' => __('errors.crudMetaImageRequired'),
            //
        ];
    }
}

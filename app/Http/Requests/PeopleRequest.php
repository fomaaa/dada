<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Rules\ImageSize;
use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
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
            'name_ru' => 'required',
            'name_en' => 'required',
            'position' => 'required',
            'photo_white' => ['required', new ImageSize],
            'photo_black' => ['required', new ImageSize],
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
            'name_ru.required' => __('errors.crudPeopleNameRuRequired'),
            'name_en.required' => __('errors.crudPeopleNameEnRequired'),
            'position.required' => __('errors.crudPeoplePositionRequired'),
            'photo_white.required' => __('errors.crudPeoplePhotoWhiteRequired'),
            'photo_black.required' => __('errors.crudPeoplePhotoBlackRequired'),
            //
        ];
    }
}

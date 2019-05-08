<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Rules\TagRequired;
use App\Rules\GalleryImagesRequired;
use Illuminate\Foundation\Http\FormRequest;

class BlocksRequest extends FormRequest
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
            // 'name' => 'required|min:5|max:255'
        ];
    }

    public static function validateContent($request, $data)
    {
        $type=$request->get('type');
        // Проводим валидацию полей в зависимости от типа блока
        switch($type){
            case 0: //0 => 'Head Image',
            case 7: //7 => 'Medium Image',
                // $data->validate($request,
                //     [
                //         'image' => 'required',
                //     ],
                //     [
                //         'image.required' => __('errors.crudImageRequired'),
                //     ]);
                break;
            case 1: //1 => 'Main Letterhead & Navigation Links',
                $data->validate($request,
                    [
                        'site_url' => 'nullable|active_url',
                        'tags' => [ new TagRequired],
                    ],
                    [
                        'site_url.active_url' => __('errors.crudSiteUrlActive'),
                    ]);
                break;
            case 2: //2 => 'Lead text',
            case 3: //3 => 'Text',
            $data->validate($request,
                [
                    'text_en' => 'required',
                    'text_ru' => 'required',
                ],
                [
                    'text_en.required' => __('errors.crudTextEnRequired'),
                    'text_ru.required' => __('errors.crudTextRuRequired'),
                ]);
            break;
            case 4: //4 => 'Video Container',
                $data->validate($request,
                [
                    'video_url' => 'required|active_url',
                ],                
                [
                    'video_preview' => 'required'
                ],
                [
                    'video_url.required' => __('errors.crudVideoUrlRequired'),
                    'video_url.active_url' => __('errors.crudVideoUrlActive'),
                ]);
                break;
            case 5:  //5 => 'Big Image',
                $data->validate($request,
                    [
                        'image' => 'required',
                    ],
                    [
                        'image.required' => __('errors.crudImageRequired'),
                    ]);
                break;
            case 6: //6 => 'Mini Images',
                $data->validate($request,
                    [
                        'image' => 'required',
                        'image2' => 'required',
                    ],
                    [
                        'image.required' => __('errors.crudImageRequired'),
                        'image2.required' => __('errors.crudImage2Required'),
                    ]);
                break;
            case 8: //8 => 'Image Gallery',
                $data->validate($request,
                    [
                        'gallery' => [new GalleryImagesRequired],
                    ]);
                break;
            case 9: //9 => 'Two Videos',
                // $data->validate($request,
                //     [
                //         'video_url' => 'required|active_url',
                //         'video_url2' => 'required|active_url',
                //     ],
                //     [
                //         'video_url.required' => __('errors.crudVideoUrlRequired'),
                //         'video_url.active_url' => __('errors.crudVideoUrlActive'),
                //         'video_url2.required' => __('errors.crudVideoUrlRequired'),
                //         'video_url2.active_url' => __('errors.crudVideoUrlActive'),
                //     ]);

        }

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
            //
        ];
    }
}

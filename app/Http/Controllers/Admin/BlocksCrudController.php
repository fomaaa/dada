<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cases;
use App\Rules\TagRequired;
use App\Http\Requests\BlocksRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Blocks;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\BlocksRequest as StoreRequest;
use App\Http\Requests\BlocksRequest as UpdateRequest;
use Illuminate\Support\Facades\App;

/**
 * Class BlocksCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BlocksCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Blocks');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blocks');
        $this->crud->setEntityNameStrings(__('blocks.add'), __('blocks.table'));

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        // Готовим список кейсов для фильтра
        $cases = Cases::get(['id' , 'title_ru', 'title_en']);
        $locale=App::getLocale();
        $casesArray = array();
        foreach($cases as $key => $case)
        {
            if ($locale == 'en') {
                $casesArray[$case->id] = $case->title_en;
            }
            else{
                $casesArray[$case->id] = $case->title_ru;
            }
        }

        //$this->crud->setFromDb();
        $this->crud->addFields([
        [
            'label' => __('blocks.case_id'),
            'type' => 'select',
            'name' => 'case_id', // the db column for the foreign key
            'entity' => 'cases', // the method that defines the relationship in your Model
            'attribute' => __('blocks.case_title'), // foreign key attribute that is shown to user
            'model' => "App\Models\Cases" // foreign key model
        ],
        [
            'label' => __('blocks.type'),
            'name' => 'type',
            'type' => 'toggle',
            'inline' => false,
            'options' => Blocks::BLOCK_TYPES,
            //0 => 'Head Image',
            //1 => 'Main Letterhead & Navigation Links',
            //2 => 'Lead text',
            //3 => 'Text',
            //4 => 'Video Container',
            //5 => 'Big Image',
            //6 => 'Mini Images',
            //7 => 'Medium Image',
            //8 => 'Image Gallery',
            //9 => 'Two video',
            'hide_when' => [
                0 => ['site_url', 'wide', 'text_ru', 'text_en', 'text2_ru', 'text2_en', 'title','indent',  'image2', 'video_url', 'video_url2', 'description_ru', 'description_en', 'description2_ru', 'description2_en', 'tags', 'gallery', 'image','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                1 => ['video_url', 'wide','title','indent', 'image', 'image2', 'video_url2', 'description2_ru', 'description2_en', 'description_ru', 'description_en',  'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link', 'head_block_type', 'head_cursor_color', 'head_block_image','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                2 => ['site_url', 'wide','text2_ru', 'text2_en', 'title','indent', 'image', 'image2', 'video_url', 'video_url2', 'description_ru', 'description_en', 'description2_ru', 'description2_en' , 'tags', 'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link', 'head_block_type', 'head_cursor_color', 'head_block_image','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                3 => ['site_url', 'wide','text2_ru', 'text2_en', 'title','indent', 'image', 'image2', 'video_url', 'video_url2', 'description_ru', 'description_en', 'description2_ru', 'description2_en' , 'tags', 'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link' , 'head_block_type', 'head_cursor_color','separator','separator2','separator3' , 'head_block_image','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                4 => ['site_url', 'text_ru', 'text_en','text2_ru', 'text2_en', 'title','indent', 'image', 'image2', 'video_url2', 'description2_ru', 'description2_en' , 'tags', 'gallery', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup' , 'popup_video_link' , 'head_block_type', 'head_cursor_color', 'head_block_image' ,'video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_preview', 'video_cursor_1', 'video_cursor_2'],
                5 => ['site_url', 'wide','text_ru', 'text_en','text2_ru', 'text2_en', 'title', 'video_url', 'video_url2', 'image2', 'description2_ru', 'description2_en' , 'tags', 'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link' , 'head_block_type', 'head_cursor_color', 'head_block_image','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2' ],
                6 => ['site_url', 'wide','text_ru', 'text_en','text2_ru', 'text2_en', 'title', 'video_url', 'video_url2', 'tags', 'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link', 'head_block_type', 'head_cursor_color' , 'head_block_image','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                7 => ['site_url', 'wide','text_ru', 'text_en','text2_ru', 'text2_en', 'title', 'video_url', 'video_url2', 'image2', 'description2_ru', 'description2_en' , 'tags', 'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link', 'head_block_type', 'head_cursor_color', 'head_block_image' ,'video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                8 => ['site_url', 'wide','text_ru', 'text_en','text2_ru', 'text2_en', 'title', 'video_url', 'video_url2', 'indent',  'image', 'image2', 'description_ru', 'description_en', 'description2_ru', 'description2_en' , 'tags', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link' , 'head_block_type', 'head_cursor_color', 'head_block_image', 'cursor_color','video_block_type1','video_block_video_type_1','video_block_image1','video_block_link1','video_block_video1','popup_video1','video_url1','video_block_type2','video_block_video_type_2','video_block_image2','video_block_link2','video_block_video2','popup_video2','video_url2', 'video_cursor_1', 'video_cursor_2'],
                9 => ['site_url', 'text_ru', 'text_en','text2_ru', 'text2_en', 'title','indent', 'wide', 'image', 'image2', 'tags', 'gallery', 'video_preview', 'popup', 'preview_type', 'cursor_color', 'video_preview_type', 'image_preview', 'link_preview', 'popup_video_link' , 'head_block_type', 'head_cursor_color', 'head_block_image', 'video_url', ],
            ],
            'default' => 0
        ],
        [
            'label' => 'Тип блока',
            'name' => 'head_block_type',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Изображение',
                '1' => 'Видео',
            ],

            'hide_when' => [
                0 => ['head_block_video_type', 'head_block_video', 'head_cursor_color'],
                1 => ['head_block_image'],
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => __('blocks.image'),
            'name' => 'image',
            'type' => 'imagenodelete',
            'upload' => true,
            'fake' => true,
            'crop' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Изображение',
            'name' => 'head_block_image',
            'type' => 'image',
            'upload' => true,
            'fake' => true,
            // 'crop' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Тип видео',
            'name' => 'head_block_video_type',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Загрузка файла',
                '1' => 'Ссылка'
            ],

            'hide_when' => [
                0 => ['head_block_video_link'],
                1 => ['head_block_video']
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'head_block_video_link',
            'label' => 'Ссылка на видео',
            'fake' => true,
            'store_in' => 'content',
        ], 
        [
            'label' => 'Видео превью',
            'name' => 'head_block_video',
            'type' => 'upload',
            'upload' => true,
            'fake' => true,
            'store_in' => 'content',
        ],        
        [
            'label' => 'Цвет курсора для видео',
            'fake' => true,
            'type' => 'radio',
            'name' => 'head_cursor_color', 
            'options' => [
                    0 => 'Белый',
                    1 => 'Черный'
            ],
            'default' => 0,
            'inline' => true,
            'store_in' => 'content',
        ], 
        [
            'name' => 'popup',
            'label' => 'Открывать в popup-окне ',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Нет',
                '1' => 'Да'
            ],

            'hide_when' => [
                0 => ['popup_video_link'],
                1 => [''],
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'popup_video_link',
            'label' => 'Ссылка на видео в popup окне',
            'fake' => true,
            'store_in' => 'content',
        ], 
        [
            'name' => 'title',
            'label' => __('blocks.title'),
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'tags',
            'label' => __('blocks.tags'),
            'fake' => true,
            'type' => 'table',
            'columns' => [
                'tag' => __('blocks.tag'),
            ],
            'min' => 1,
            'store_in' => 'content',
        ],
        [
            'label' => 'Тип превью (видео 1)',
            'name' => 'video_block_type1',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Видео',
                '1' => 'Изображение'
            ],

            'hide_when' => [
                0 => ['video_block_image1'],
                1 => ['video_block_video_type_1', 'video_cursor_1', 'video_block_video1']
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Тип видео (видео 1)',
            'name' => 'video_block_video_type_1',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Загрузка файла',
                '1' => 'Ссылка'
            ],

            'hide_when' => [
                0 => ['video_block_link1'],
                1 => ['video_block_video1']
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Изображение (видео 1)',
            'name' => 'video_block_image1',
            'type' => 'image',
            'upload' => true,
            'fake' => true,
            'store_in' => 'content',
        ],
       [
            'name' => 'video_block_link1',
            'label' => 'Ссылка на видео (видео 1)',
            'fake' => true,
            'store_in' => 'content',
        ], 
        [
            'label' => 'Видео превью (видео 1)',
            'name' => 'video_block_video1',
            'type' => 'upload',
            'upload' => true,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'popup_video1',
            'label' => 'Открывать в popup-окне (видео 1)',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Нет',
                '1' => 'Да'
            ],

            'hide_when' => [
                0 => ['video_url1'],
                1 => [''],
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'video_url1',
            'label' => __('blocks.video'),
            'fake' => true,
            'store_in' => 'content',
        ],        
        [
            'name' => 'video_url',
            'label' => __('blocks.video'),
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Цвет курсора для (видео 1)',
            'fake' => true,
            'type' => 'radio',
            'name' => 'video_cursor_1', 
            'options' => [
                    0 => 'Белый',
                    1 => 'Черный'
            ],
            'default' => 0,
            'inline' => true,
            'store_in' => 'content',
        ], 
        [
            'name' => 'site_url',
            'label' => __('blocks.site'),
            'fake' => true,
            'store_in' => 'content',
        ],

        [
            'name' => 'indent',
            'fake' => true,
            'label' => __('blocks.indent'),
            'type' => 'checkbox',
            'store_in' => 'content',
        ],
        [
            'name' => 'wide',
            'fake' => true,
            'label' => __('blocks.wide'),
            'type' => 'checkbox',
            'store_in' => 'content',
        ],
        [
            'name' => 'description_ru',
            'label' => __('blocks.description_ru'),
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'description_en',
            'label' => __('blocks.description_en'),
            'fake' => true,
            'store_in' => 'content',
        ],
        //video 2
        [
            'label' => 'Тип превью (видео 2)',
            'name' => 'video_block_type2',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Видео',
                '1' => 'Изображение'
            ],

            'hide_when' => [
                0 => ['video_block_image2'],
                1 => ['video_block_video_type_2', 'video_cursor_2', 'video_block_video2']
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Тип видео (видео 2)',
            'name' => 'video_block_video_type_2',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Загрузка файла',
                '1' => 'Ссылка'
            ],

            'hide_when' => [
                0 => ['video_block_link2'],
                1 => ['video_block_video2']
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Изображение (видео 2)',
            'name' => 'video_block_image2',
            'type' => 'image',
            'upload' => true,
            'fake' => true,
            'store_in' => 'content',
        ],
       [
            'name' => 'video_block_link2',
            'label' => 'Ссылка на видео (видео 2)',
            'fake' => true,
            'store_in' => 'content',
        ], 
        [
            'label' => 'Видео превью (видео 2)',
            'name' => 'video_block_video2',
            'type' => 'upload',
            'upload' => true,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'popup_video2',
            'label' => 'Открывать в popup-окне (видео 2)',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Нет',
                '1' => 'Да'
            ],

            'hide_when' => [
                0 => ['video_url2'],
                1 => [''],
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'video_url2',
            'label' => __('blocks.video'),
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Цвет курсора для (видео 2)',
            'fake' => true,
            'type' => 'radio',
            'name' => 'video_cursor_2', 
            'options' => [
                    0 => 'Белый',
                    1 => 'Черный'
            ],
            'default' => 0,
            'inline' => true,
            'store_in' => 'content',
        ], 
        [
            'label' => __('blocks.second_image'),
            'name' => 'image2',
            'type' => 'imagenodelete',
            'upload' => true,
            'fake' => true,
            'crop' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'description2_ru',
            'label' => __('blocks.description_ru'),
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'description2_en',
            'label' => __('blocks.description_en'),
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'name' => 'text_ru',
            'label' => __('blocks.text_ru'),
            'fake' => true,
            'type' => 'wysiwyg',
            'store_in' => 'content',
        ],
        [
            'name' => 'text_en',
            'label' => __('blocks.text_en'),
            'fake' => true,
            'type' => 'wysiwyg',
            'store_in' => 'content',
        ],
        [
            'name' => 'text2_ru',
            'label' => __('blocks.text2_ru'),
            'fake' => true,
            'type' => 'wysiwyg',
            'store_in' => 'content',
        ],
        [
            'name' => 'text2_en',
            'label' => __('blocks.text2_en'),
            'fake' => true,
            'type' => 'wysiwyg',
            'store_in' => 'content',
        ],
        [
            'name' => 'gallery',
            'label' => __('blocks.slider'),
            'fake' => true,
            'upload' => true,
            'type' => 'image_multiple',
            'crop-gallery' => true,
            //'aspect_ratio' => 1.5,
            'store_in' => 'content',
        ],

        [
            'name' => 'clone',
            'fake' => true,
            'type' => 'image_multiple_clone',
            'crop-gallery' => true,
            //'aspect_ratio' => 1.5,
        ],
        [
            'name' => 'sort',
            'label' => __('blocks.sort'),
        ],
        [
            'label' => 'Тип превью для списка работ',
            'name' => 'preview_type',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Изображение',
                '1' => 'Видео',
                '2' => "Нет"
            ],

            'hide_when' => [
                0 => ['video_preview', 'video_preview_type', 'cursor_color'],
                1 => ['image_preview'],
                2 => ['video_preview', 'video_preview_type', 'image_preview', 'link_preview', 'cursor_color', ]
            ],
            'default' => 3,
            'fake' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Тип видео превью',
            'name' => 'video_preview_type',
            'type' => 'toggle',
            'inline' => true,
            'options' => [
                '0' => 'Загрузка файла',
                '1' => 'Ссылка'
            ],

            'hide_when' => [
                0 => ['link_preview'],
                1 => ['video_preview']
            ],
            'default' => 0,
            'fake' => true,
            'store_in' => 'content',
        ],
          [
            'name' => 'link_preview',
            'label' => 'Ссылка на видео для списка работ',
            'fake' => true,
            'store_in' => 'content',
        ], 
        [
            'label' => 'Видео превью для списка работ',
            'name' => 'video_preview',
            'type' => 'upload',
            'upload' => true,
            'fake' => true,
            'store_in' => 'content',
        ],        
        [
            'label' => 'Фото превью для списка работ',
            'name' => 'image_preview',
            'type' => 'image',
            'upload' => true,
            'fake' => true,
            // 'crop' => true,
            'store_in' => 'content',
        ],
        [
            'label' => 'Цвет курсора для списка работ',
            'fake' => true,
            'type' => 'radio',
            'name' => 'cursor_color', 
            'options' => [
                    0 => 'Белый',
                    1 => 'Черный'
            ],
            'default' => 0,
            'inline' => true,
            'store_in' => 'content',
        ], 
        ]);
        /*$this->crud->addField([   // Upload
            'name' => 'imagess',
            'label' => 'Image',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'uploads' // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
        ])->afterField('image2');*/

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);
        $this->crud->addColumn(
            [
                'name' => 'type',
                'type' => 'select_from_array',
                'options' => Blocks::BLOCK_TYPES,
                'label' => __('blocks.type'),
            ]);
        $this->crud->addColumn(
            [
                'name' => 'sort',
                'type' => 'text',
                'label' => __('blocks.sort'),
            ]);
        $this->crud->addColumn(
            [
                'name' => 'case_id',
                'label' => __('blocks.case_id'),
                'type' => 'select',
                'entity' => 'cases',
                'model' => 'App\Models\Cases',
                'attribute' => __('blocks.case_title'),
            ]);
        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // add asterisk for fields that are required in BlocksRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        //$this->crud->enableListRow();
        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        //$this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        $this->crud->addFilter(
            [
                'type' => 'dropdown',
                'name' => 'case_id',
                'label' => __('blocks.case_id')
            ],
            $casesArray,
            function ($value) {
                $this->crud->addClause('where', 'case_id', $value);
            });
        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '=', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        BlocksRequest::validateContent($request, $this);
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        BlocksRequest::validateContent($request, $this);
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

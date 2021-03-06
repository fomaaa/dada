<?php

namespace App\Models;

use App\Block;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


class Blocks extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const BLOCK_TYPES = [
        0 => 'Head Image',
        1 => 'Main Letterhead & Navigation Links',
        2 => 'Lead text',
        3 => 'Text',
        4 => 'Video Container',
        5 => 'Big Image',
        6 => 'Mini Images',
        7 => 'Medium Image',
        8 => 'Image Gallery',
        9 => 'Two Videos',
    ];

    protected $table = 'blocks';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fakeColumns = ['content'] ;
    protected $fillable = [
        'content', 'case_id', 'type', 'sort',
    ];

    protected $casts = [
        'content' => 'array',
        'tags' => 'array',
        'gallery' => 'array'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function removeTags($text, $lang)
    {
        $fullText ='';

        if(isset($text['text_'.$lang])) {
            $fullText .= $text['text_'.$lang];
        }
        if(isset($text['text2_'.$lang])) {
            $fullText .= ' '.$text['text2_'.$lang];
        }

        $body = strip_tags($fullText);
        $body = html_entity_decode($body);
        $body = trim(preg_replace('/\s\s+/', ' ', $body));
        function strposa($haystack, $needles=array(), $offset=0) {
            $chr = array();
            foreach($needles as $needle) {
                $res = strpos($haystack, $needle, $offset);
                if ($res !== false) $chr[$needle] = $res;
            }
            if(empty($chr)) return false;
            return min($chr);
        }
        // Если одно предложение без знака конца предложения
        if(!strposa($body, ['.', '!', '?'], 0))
        {
            return $body.'...';
        }
        //Два первых предложения
        $pos= strposa($body, ['.', '!', '?'],
            strposa($body, ['.', '!', '?'], 0)+1);

        if(!$pos) { // Нет двух предложений
            return substr($body, 0, -1).'...';
        }
        else {
            $substring = substr($body, 0, $pos+1);
        }
        return substr($substring, 0, -1).'...';
    }
    public static function sortBlocks($blocks) {
        $sort = $blocks->where('sort', '!=',  null);
        $null = $blocks->where('sort',  null);
        $sort = $sort->sortBy('sort');
        $null = $null->sortBy('id');
        $filtered = $sort->merge($null);
        return $filtered;
    }

    public static function fillContentData($block, $item,  $lang)
    {
        if (isset($item->content['is_published']) && $item->content['is_published'] == 1) {
            $block->is_published = true;
        } else {
            $block->is_published = false;
        }

        switch ($block->type) {
            case 0: //0 => 'Head Image'
                if (isset($item->content['image'])) {
                    $block->image = $item->content['image'];
                }
                // if (isset($item->content['preview_type'])) {
                    $block->preview_type = $item->content['preview_type'];
                // }

                if (isset($item->content['video_preview'])) {
                    $block->video_preview = $item->content['video_preview'];
                }
                if (isset($item->content['video_preview_type'])) {
                    $block->video_preview_type = $item->content['video_preview_type'];
                }
                if (isset($item->content['link_preview'])) {
                    $block->link_preview = $item->content['link_preview'];
                }
                if (isset($item->content['cursor_color'])) {
                    $block->cursor_color = $item->content['cursor_color'];
                }
                if (isset($item->content['image_preview'])) {
                    $block->image_preview = $item->content['image_preview'];
                }

                if (isset($item->content['image_preview_thumb'])) {
                    $block->image_preview_thumb = $item->content['image_preview_thumb'];
                }
                if (isset($item->content['show_this_block_head'])) {
                    $block->show_this_block = $item->content['show_this_block_head'];
                }
                if (isset($item->content['this_block_video_link'])) {
                    $block->this_block_video_link = $item->content['this_block_video_link'];
                }
                if (isset($item->content['show_this_block_head'])) {
                    if (isset($item->content['show_this_block_head'])) {
                        $block->show_this_block = $item->content['show_this_block_head'];
                    }

                    if (isset($item->content['show_this_block_video_type'])) {
                        $block->this_block_video_type = $item->content['show_this_block_video_type'];
                    }
                    if (isset($item->content['this_block_video_link'])) {
                        $block->this_block_video_link = $item->content['this_block_video_link'];
                    }

                    if (isset($item->content['this_block_video_url'])) {
                        $block->this_block_video_url = $item->content['this_block_video_url'];
                    }
                }
                break;
            case 1: //1 => 'Main Letterhead & Navigation Links'
                $block->tags = $item->content['tags'];
                if (isset($item->content['text_' . $lang])) {
                    $block->text = $item->content['text_' . $lang];
                } else {
                    $block->text = null;
                }
                if (isset($item->content['text2_' . $lang])) {
                    $block->text2 = $item->content['text2_' . $lang];
                } else {
                    $block->text2 = null;
                }
                if (isset($item->content['site_url'])) {
                    $block->site_url = $item->content['site_url'];
                } else {
                    $block->site_url = null;
                }
                break;
            case 2: //2 => 'Lead text'
                $block->text = $item->content['text_' . $lang];
                break;
            case 3: //3 => 'Text';
                $block->text = $item->content['text_' . $lang];
                break;
            case 4: //4 => 'Video Container'

                if (isset($item->content['wide']) && $item->content['wide'] == 1) {
                    $block->wide = true;
                } else {
                    $block->wide = false;
                }                
                if (isset($item->content['indent']) && $item->content['indent'] == 1) {
                    $block->indent = true;
                } else {
                    $block->indent = false;
                }
                if (isset($item->content['popup']) && $item->content['popup'] == 1) {
                    $block->popup = true;
                    $block->popup_link = $item->content['popup_video_link'];
                } else {
                    $block->popup = false;
                }

                if (isset($item->content['description_' . $lang])) {
                    $block->description = $item->content['description_' . $lang];
                } else {
                    $block->description = null;
                }
                if (isset($item->content['head_cursor_color'])) {
                    $block->cursor_color = $item->content['head_cursor_color'];
                }

                if (isset($item->content['head_block_type'])) {
                    $block->content_type = $item->content['head_block_type'];

                    if ($block->content_type == 0) {
                        $block->block_image = $item->content['head_block_image'];
                        $block->block_image_thumb = $item->content['head_block_image_thumb'];
                    } else {
                        $block->video_type = $item->content['head_block_video_type'];


                        if ($block->video_type == 0) {
                            if (isset($item->content['head_block_video'])) {
                                $block->video = $item->content['head_block_video'];
                            }
                        } else {
                            if (isset($item->content['head_block_video_link'])) {
                                $block->video_link = $item->content['head_block_video_link'];
                            }
                        }
                    }

                }

                if (isset($item->content['show_this_block_head'])) {
                    $block->show_this_block = $item->content['show_this_block_head'];

                    if (isset($item->content['show_this_block_video_type'])) {
                        $block->show_this_block_video_type = $item->content['show_this_block_video_type'];
                    }
                    if (isset($item->content['this_block_video_link'])) {
                        $block->this_block_video_link = $item->content['this_block_video_link'];
                    }

                    if (isset($item->content['this_block_video_url'])) {
                        $block->this_block_video_url = $item->content['this_block_video_url'];
                    }
                }

                break;
            case 5:
            case 7://5 => 'Big Image'
                if (isset($item->content['image'])) {
                    $block->image = $item->content['image'];
                }

                if (isset($item->content['image_thumb'])) {
                    $block->image_thumb = $item->content['image_thumb'];
                }
                $block->description = $item->content['description_' . $lang];
                if (isset($item->content['indent']) && $item->content['indent'] == 1) {
                    $block->indent = true;
                } else {
                    $block->indent = false;
                }
                break;
            case 6: //6 => 'Mini Images'
                if (isset($item->content['image'])) {
                    $block->image = $item->content['image'];
                }
                if (isset($item->content['image_thumb'])) {
                    $block->image_thumb = $item->content['image_thumb'];
                }
                $block->description = $item->content['description_' . $lang];
                if (isset($item->content['indent']) && $item->content['indent'] == 1) {
                    $block->indent = true;
                } else {
                    $block->indent = false;
                }
                if (isset($item->content['image2'])) {
                    $block->image2 = $item->content['image2'];
                }
                if (isset($item->content['image2_thumb'])) {
                    $block->image2_thumb = $item->content['image2_thumb'];
                }
                $block->description2 = $item->content['description2_' . $lang];
                break;
            case 8: //8 => 'Image Gallery'
                $arr = array();
                foreach ($item->content['gallery'] as $keys => $i) {

                    if ($lang == 'en') {
                        $arr [] = array_merge($item->content['gallery'][$keys], ['descr' => $i['descr_en']]);
                    } else {
                        $arr [] = array_merge($item->content['gallery'][$keys], ['descr' => $i['descr_ru']]);
                    }
                    $arr[$keys]['img'] = '/storage/app/public' . $arr[$keys]['img'];
                }
                $block->gallery = $arr;
                break;
            case 9: //9 => 'Two Videos'
                if (isset($item->content['description_' . $lang])) {
                    $block->description = $item->content['description_' . $lang];
                } else {
                    $block->description = null;
                }
                if (isset($item->content['description2_' . $lang])) {
                    $block->description2 = $item->content['description2_' . $lang];
                } else {
                    $block->description2 = null;
                }
                if (isset($item->content['video_cursor_1'])) {
                    $block->video_cursor_1 = $item->content['video_cursor_1'];
                }

                if (isset($item->content['video_block_type1'])) {
                    $block->video_block_type1 = $item->content['video_block_type1'];
                }

                if (isset($item->content['popup_video1'])) {
                    $block->popup_video1 = $item->content['popup_video1'];
                }

                if ( $block->popup_video1) {
                    $block->video_url1 = $item->content['video_url1'];
                }

                if (isset($item->content['video_block_type1'])) {
                    if ($block->video_block_type1 == 0) {
                        $block->video_block_video_type_1 = $item->content['video_block_video_type_1'];

                        if ($block->video_block_video_type_1 == 0) {
                            if (isset($item->content['video_block_video1'])) {
                                $block->video_block_video1 = $item->content['video_block_video1'];

                            }
                        } elseif ($block->video_block_video_type_1 == 1) {
                            if (isset($item->content['video_block_link1'])) {
                                $block->video_block_link1 = $item->content['video_block_link1'];
                            }
                        }
                    } elseif ($block->video_block_type1 == 1) {
                        $block->video_block_image1 = $item->content['video_block_image1'];

                        if (isset($item->content['video_block_image1_thumb'])) {
                            $block->video_block_image1_thumb = $item->content['video_block_image1_thumb'];
                        }
                    }

                }
                // if (isset($item->content['show_this_block1'])) {
                //     $block->show_this_block1 = $item->content['show_this_block1'];
                // }
                //video2
                if (isset($item->content['video_cursor_2'])) {
                    $block->video_cursor_2 = $item->content['video_cursor_2'];
                }
                if (isset($item->content['video_block_type2'])) {
                    $block->video_block_type2 = $item->content['video_block_type2'];

                }
                if (isset($item->content['popup_video2'])) {
                    $block->popup_video2 = $item->content['popup_video2'];
                }




                if ( $block->popup_video2) {
                    $block->video_url2 = $item->content['video_url2'];
                }
                if (isset($item->content['video_block_type2'])) {
                    if ($block->video_block_type2 == 0) {
                        $block->video_block_video_type_2 = $item->content['video_block_video_type_2'];

                        if ($block->video_block_video_type_2 == 0) {
                            if (isset($item->content['video_block_video2'])) {

                                $block->video_block_video2 = $item->content['video_block_video2'];
                            }
                        } elseif ($block->video_block_video_type_2 == 1) {
                            if (isset($item->content['video_block_link2'])) {
                                $block->video_block_link2 = $item->content['video_block_link2'];
                            }
                        }
                    } elseif ($block->video_block_type2 == 1) {
                        $block->video_block_image2 = $item->content['video_block_image2'];
                        if (isset($item->content['video_block_image2_thumb'])) {
                            $block->video_block_image2_thumb = $item->content['video_block_image2_thumb'];
                        }
                    }

                }
                // if (isset($item->content['show_this_block2'])) {
                //     $block->show_this_block2 = $item->content['show_this_block2'];
                // }
                break;
        }
    }
    public function uploadFile($file) {
        $disk = 'public';
        $destinationPath = 'blocks/videos/';
        $extension = $file->getClientOriginalExtension();
        $filename = md5($file->getFilename() . time()) . '.' . $extension;
        // if (!$file->getError()) {
	        if (!$filename) {
	        	$filename =  md5(data('Ymdd') . time()) . '.' . $extension;
	        }

	        \Storage::disk($disk)->put($destinationPath . '/' . $filename, File::get($file));

	        return '/'.$destinationPath.$filename;
        // }
    }

    public function uploadImage($value, $type = null, $width=null, $height=null)
    {
        \Tinify\setKey("9KvDsXlhjjRqYZsNPjlhBp6WKWlNYDVL");
       $disk = 'public';
       $destinationPath = 'blocks/images/';
       $thumbPath = 'blocks/images/thumbs/';
       if (starts_with($value, 'data:image')) {
           $image = Image::make($value);

           if(($width!=null) && ($height!=null))
           {
               $image->resize($width, $height, function ($constraint) {
                   $constraint->upsize();
               });
           }

           //for gif's , need another way for save animation.
           if ($image->mime() == 'image/gif') {
                $img = str_replace('data:image/gif;base64,', '', $value);
                $img = str_replace(' ', '+', $img);
                $filename = md5(time() + rand(0, 999) . 'gif' . time()) . '.gif';
                \Storage::disk($disk)->put($destinationPath . '/' . $filename, base64_decode($img));
           } else {
                $extension = substr($value, strpos($value, '/') + 1, strpos($value, ';') - strpos($value, '/') - 1);
                $filename = md5($value . time()) . '.'.$extension;
                \Storage::disk($disk)->put($destinationPath . '/' . $filename, $image->stream());

                $source = \Tinify\fromFile(base_path() .'/storage/app/public/'.$destinationPath.$filename);


                $resized = $source->resize(array(
                    "method" => "fit",
                    "width" => 150,
                    "height" => 150
                ));

                $source->toFile(base_path() .'/storage/app/public/'.$destinationPath.$filename);
                $resized->toFile(base_path() .'/storage/app/public/blocks/images/thumbs/'.$filename);
           }


           // Ресайз картинок
           /*switch($type)
           {
               case 0: // Head Image
               case 5: // Big Image
               $image->resize(1920, null, function ($constraint) {
                   $constraint->upsize();
                   $constraint->aspectRatio();
               });
               break;
               case 8: // Image Gallery
               case 6: // Mini Images
               $image->resize(1200, null, function ($constraint) {
                   $constraint->upsize();
                   $constraint->aspectRatio();
               });
               break;
               case 7: // Medium Image
               $image->resize(1440, null, function ($constraint) {
                   $constraint->upsize();
                   $constraint->aspectRatio();
               });
               break;
           }
           */
           // Оптимизация картинок
           //$image = base64_decode($value);
           /*
           $extension = substr($value, strpos($value, '/') + 1, strpos($value, ';') - strpos($value, '/') - 1);
           $filename = md5($value . time()) . '.'.$extension;
           // 2. Store the image on disk.
           $filename_before='old'.$filename;
           $path=storage_path('app/public/blocks/images/'.$filename_before);
           // Оптимизируем
           \Storage::disk($disk)->put($destinationPath . '/' . $filename_before, $image->stream());
           //$api = new \ImageOptim\API("nlbhtdbfzm");
           $api = new \ImageOptim\API("vlqppjrnwq");
           $imageData = $api->imageFromPath($path)->getBytes();
           $image2 = Image::make($imageData);
           \Storage::disk($disk)->put($destinationPath . '/' . $filename, $image2->stream());

           \Storage::disk($disk)->delete($destinationPath . '/' . $filename_before);
            */
           // echo '<pre>';
           // print_r(\Storage::disk('public'));
            // echo base_path() .'/storage/app/public/' .$destinationPath.$filename;
            // exit();



           // return '/'.$destinationPath.$filename;
           if ($image->mime() == 'image/gif') {
               return array(
                 'image'  => '/'.$destinationPath.$filename,
               );
           } else {
               return array(
                 'image'  => '/'.$destinationPath.$filename,
                 'thumb' => '/'. $thumbPath . $filename,
               );
           }
       }
       // Не base64, значит пришёл путь до картинки
       else {
           if ($value == null) return null;


           $pos = strpos($value, '/blocks');
           $imgpath=substr($value, $pos, 999);


           $filename = explode('/', $value);
           $count = count($filename);
           $filename = $filename[$count - 1];

            if (!file_exists (base_path() .'/storage/app/public/blocks/images/thumbs/'.$filename)) {
                $source = \Tinify\fromFile($value);
                $resized = $source->resize(array(
                    "method" => "fit",
                    "width" => 150,
                    "height" => 150
                ));
                $resized->toFile(base_path() .'/storage/app/public/blocks/images/thumbs/'.$filename);

            }

           return array(
                 'image'  => $imgpath,
                 'thumb' => '/blocks/images/thumbs/'.$filename,
            );
       }

    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function cases()
    {
        return $this->belongsTo('App\Models\Cases', 'case_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeWithText($query, $lang)
    {
        return $query->where('content', 'like', '%"text_'.$lang.'":"%' )
            ->orWhere('content', 'like', '%"text2_'.$lang.'":"%' );
    }

    public function scopeSort($query)
    {
        return $query->orderBy(DB::raw('CASE
                WHEN sort IS NULL THEN \'created_at ASC\'
                ELSE 1
                END,
                sort'))
            ->orderBy('created_at', 'DESC');
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function getImageAttribute()
    {
        $fileName = $this->attributes['image'];
        if($fileName!= null)
        {
            $pathway = '/storage/app/public';
            return $pathway.$fileName;
        }
        else return null;
    }

    public function getImage2Attribute()
    {
        $fileName = $this->attributes['image2'];
        if($fileName!= null)
        {
            $pathway = '/storage/app/public';
            return $pathway.$fileName;
        }
        else return null;
    }


    public function setContentAttribute($value)
    {
        if (isset($this->attributes['content'])) {
            $old = json_decode($this->attributes['content']);
        }
        // Определяем тип блока
        $type=$this->attributes['type'];
        $data=[
            'image' => null,
            'text_en' => null,
            'text_ru' => null,
            'text2_en' => null,
            'text2_ru' => null,
            'indent' => null,
            'wide' => null,
            'video_url' => null,
            'description_ru' => null,
            'description_en' => null,
            'image2' => null,
            'description2_ru' => null,
            'description2_en' => null,
            'site_url' => null,
            'tags' => null,
            'gallery' => null,
            'video_preview' => null,
            'image_preview' => null,
            'popup' => null,
            'cursor_color' => null,
            'preview_type' => null
        ];

        switch($type)
        {
            case 0: //0 => 'Head Image'
                // if (!empty($value['preview_type'])) {
                $data['preview_type'] = $value['preview_type'];

                // }
                $data['cursor_color'] = $value['cursor_color'];

                if ($value['preview_type'] == 0) {
                    if (isset($value['image_preview'])) {
                        $images = Blocks::uploadImage($value['image_preview']);

                        $data['image_preview'] = '/storage/app/public' . $images['image'];

                        if (isset($images['thumb'])) {
                            $data['image_preview_thumb'] = '/storage/app/public'. $images['thumb'];
                        }
                    }
                } elseif ($data['preview_type'] == 1) {
                    if (isset($value['video_preview_type'])) {
                        $data['video_preview_type'] = $value['video_preview_type'];
                        if (isset($value['video_preview'])) {
                            $file = $value['video_preview'];
                            $file = $this->uploadFile($file);
                            if ($file) {
                                $data['video_preview'] = '/storage/app/public' . $file;
                            }
                        } else if ($old->video_preview) {
                             $data['video_preview'] = $old->video_preview;
                        }
                        if (isset($value['link_preview'])) {
                            $data['link_preview'] = $value['link_preview'];
                        }
                    }
                }
                $data['head_block_type'] = $value['head_block_type'];
                $data['head_cursor_color'] = $value['head_cursor_color'];

                if ($data['head_block_type'] == 1) {
                    if (isset($value['head_block_video_type'])) {
                        $data['head_block_video_type'] = $value['head_block_video_type'];
                        if (isset($value['head_block_video'])) {
                            $file = $value['head_block_video'];
                            $file = $this->uploadFile($file);
                            if ($file) {
                                $data['head_block_video'] = '/storage/app/public' . $file;
                            }
                        } else if ($old->head_block_video) {
                             $data['head_block_video'] = $old->head_block_video;
                        }
                        if (isset($value['head_block_video_link'])) {
                            $data['head_block_video_link'] = $value['head_block_video_link'];
                        }
                    }
                } else {
                    $images = Blocks::uploadImage($value['head_block_image']);
                    $data['head_block_image']=   '/storage/app/public' . $images['image'];
                    if (isset($images['thumb'])) {
                        $data['head_block_image_thumb']=   '/storage/app/public' . $images['thumb'];
                    }
                }

                 $data['popup']= $value['popup'];

                 if ($data['popup']) {
                    $data['popup_video_link'] = $value['popup_video_link'];
                 }

                break;
            case 1: //1 => 'Main Letterhead & Navigation Links'
                // Теги в нижний кейс
                foreach($value['tags'] as $key => $tag)
                {
                    $tag->tag=mb_strtolower($tag->tag, 'UTF-8');
                }
                $data['tags']= $value['tags'];
                $data['text_en']= $value['text_en'];
                $data['text_ru']= $value['text_ru'];
                $data['text2_en']= $value['text2_en'];
                $data['site_url']= $value['site_url'];
                $data['text2_ru']= $value['text2_ru'];
                break;
            case 2: //2 => 'Lead text'
                $data['text_en']= $value['text_en'];
                $data['text_ru']= $value['text_ru'];
                break;
            case 3: //3 => 'Text'
                $data['text_en']= $value['text_en'];
                $data['text_ru']= $value['text_ru'];
                break;
            case 4: //4 => 'Video Container'
            // dd($value);
                $data['head_block_type'] = $value['head_block_type'];
                $data['head_cursor_color'] = $value['head_cursor_color'];
                if (isset($value['indent'])) {
                    $data['indent']=$value['indent'];
                }
                if ($data['head_block_type'] == 1) {
                    if (isset($value['head_block_video_type'])) {
                        $data['head_block_video_type'] = $value['head_block_video_type'];
                        if (isset($value['head_block_video'])) {
                            $file = $value['head_block_video'];
                            $file = $this->uploadFile($file);

                            if ($file) {
                                $data['head_block_video'] = '/storage/app/public' . $file;
                            }
                        } else if (isset($old->head_block_video)) {
                             $data['head_block_video'] = $old->head_block_video;
                        }
                        if (isset($value['head_block_video_link'])) {
                            $data['head_block_video_link'] = $value['head_block_video_link'];
                        }
                    }
                } else {
                	if ($value['head_block_image']) {
	                    $images = Blocks::uploadImage($value['head_block_image']);
	                    $data['head_block_image']=   '/storage/app/public' . $images['image'];
	                    if (isset($images['thumb'])) {
	                        $data['head_block_image_thumb']=   '/storage/app/public' . $images['thumb'];
	                    }
                	}
                }

                 $data['popup']= $value['popup'];

                 if ($data['popup']) {
                    $data['popup_video_link'] = $value['popup_video_link'];
                 } else {
                    $data['show_this_block_head'] = $value['show_this_block_head'];
                    if ($data['show_this_block_head']) {
                        $data['show_this_block_video_type'] = $value['show_this_block_video_type'];
                        if ($data['show_this_block_video_type'] == 0) {
                            if ($value['this_block_video_url']) {
	                            $file = $value['this_block_video_url'];
	                            $file = $this->uploadFile($file);

	                            if ($file) {
	                                $data['this_block_video_url'] = '/storage/app/public' . $file;
	                            }
                            } else {
                                if (isset($old->this_block_video_url)) {
                                    $data['this_block_video_url'] = $old->this_block_video_url;
                                }
                            }
                        } else if ($data['show_this_block_video_type'] == 1) {
                            $data['this_block_video_link'] = $value['this_block_video_link'];

                        }
                    }
                 }

                $data['wide']= $value['wide'];

                if(isset($value['description_ru'])){
                    $data['description_ru']= $value['description_ru'];
                }
                if(isset($value['description_en'])){
                    $data['description_en']= $value['description_en'];
                }
                break;
            case 5: //5 => 'Big Image'
                $images=Blocks::uploadImage($value['image'], 5);
                $data['image']= $images['image'];

                if (isset($images['thumb'])) {
                    $data['image_thumb']= '/storage/app/public' . $images['thumb'];
                }
                $data['indent']=$value['indent'];
                $data['description_ru']=$value['description_ru'];
                $data['description_en']=$value['description_en'];
                break;
            case 6: //6 => 'Mini Images'
                $images=Blocks::uploadImage($value['image'], 6);

                $data['image']=  $images['image'];
                if (isset($images['thumb'])) {
                    $data['image_thumb']=  '/storage/app/public' . $images['thumb'];
                }
                $data['description_ru']=$value['description_ru'];
                $data['description_en']=$value['description_en'];
                $images2 = Blocks::uploadImage($value['image2'], 6);
                $data['image2']= $images2['image'];
                if (isset($images2['thumb'])) {
                    $data['image2_thumb']= '/storage/app/public' . $images2['thumb'];
                }
                $data['description2_ru']=$value['description2_ru'];
                $data['description2_en']=$value['description2_en'];
                $data['indent']=$value['indent'];
                break;
            case 7: //7 => 'Medium Image'
                $images = Blocks::uploadImage($value['image'], 7);
                $data['image']= $images['image'];
                if (isset($images['thumb'])) {
                    $data['image_thumb']= '/storage/app/public' . $images['thumb'];
                }
                $data['indent']=$value['indent'];
                $data['description_ru']=$value['description_ru'];
                $data['description_en']=$value['description_en'];
                break;
            case 8: //8 => 'Image Gallery'
                $arr = $value['gallery'];

                $galleryData = array();
                //Для каждого элемента слайдера
                foreach($arr as $item)
                {
                    if ($item != null) {
                        $images = Blocks::uploadImage($item, 8);

                        $descr_ru = null;
                        $descr_en = null;
                        if (isset($item->descr_ru)) {
                            $descr_ru = $item->descr_ru;
                        }
                        if (isset($item->descr_en)) {
                            $descr_en = $item->descr_en;
                        }
                        $toPush =
                            [
                                'img' => $images['image'],
                                'descr_ru' => $descr_ru,
                                'descr_en' => $descr_en,
                            ];
                        array_push($galleryData, $toPush);
                    }
                }
                $data['gallery']= $galleryData;
                break;
            case 9: //4 => 'Two Videos'

                if(isset($value['description_ru'])){
                    $data['description_ru'] = $value['description_ru'];
                }
                if(isset($value['description_en'])){
                    $data['description_en'] = $value['description_en'];
                }
                if(isset($value['description2_ru'])){
                    $data['description2_ru'] = $value['description2_ru'];
                }
                if(isset($value['description2_en'])){
                    $data['description2_en'] = $value['description2_en'];
                }
                // dd($value);
                //video1
                $data['video_cursor_1'] = $value['video_cursor_1'];
                $data['video_block_type1'] = $value['video_block_type1'];
                $data['popup_video1'] = $value['popup_video1'];

                if ($data['popup_video1']) {
                    $data['video_url1'] = $value['video_url1'];
                }
                // else {
                //     $data['show_this_block1'] = $value['show_this_block1'];
                // }
                // dd($value);
                if ($data['video_block_type1'] == 0) {
                    $data['video_block_video_type_1'] = $value['video_block_video_type_1'];

                    if ($data['video_block_video_type_1'] == 0) {
                        if (isset($value['video_block_video1'])) {
                            $data['video_block_video1'] = '/storage/app/public' . Blocks::uploadFile($value['video_block_video1']);
                        } else {
                            if (isset($old->video_block_video1)) {
                                $data['video_block_video1'] = $old->video_block_video1;
                            }
                        }
                    } elseif ($data['video_block_video_type_1'] == 1) {
                        $data['video_block_link1'] = $value['video_block_link1'];
                    }
                } elseif ($data['video_block_type1'] == 1) {
                    $images = Blocks::uploadImage($value['video_block_image1']);
                    $data['video_block_image1'] = '/storage/app/public' . $images['image'];
                    if (isset($images['thumb'])) {
                        $data['video_block_image1_thumb'] = '/storage/app/public' . $images['thumb'];
                    }


                }

                //video2
                $data['video_cursor_2'] = $value['video_cursor_2'];
                $data['video_block_type2'] = $value['video_block_type2'];

                $data['popup_video2'] = $value['popup_video2'];
                if ($data['popup_video2']) {
                    $data['video_url2'] = $value['video_url2'];
                }
                // else {
                //     $data['show_this_block2'] = $value['show_this_block2'];
                // }

                if ($data['video_block_type2'] == 0) {
                    $data['video_block_video_type_2'] = $value['video_block_video_type_2'];

                    if ($data['video_block_video_type_2'] == 0) {
                        if (isset($value['video_block_video2'])) {
                            $data['video_block_video2'] = '/storage/app/public' . Blocks::uploadFile($value['video_block_video2']);
                        } else {
                            if (isset($old->video_block_video2)) {
                                $data['video_block_video2'] = $old->video_block_video2;
                            }
                        }
                    } elseif ($data['video_block_video_type_2'] == 1) {
                        $data['video_block_link2'] = $value['video_block_link2'];
                    }
                } elseif ($data['video_block_type2'] == 1) {
                    $images = Blocks::uploadImage($value['video_block_image2']);
                    $data['video_block_image2'] = '/storage/app/public' . $images['image'];
                    if (isset($images['thumb'])) {
                        $data['video_block_image2_thumb'] = '/storage/app/public' . $images['thumb'];
                    }
                }


                break;
        }
        $data['is_published']= $value['is_published'];
        //Записываем в Content

        $content = json_encode($data);
        // dd($content);
        $this->attributes['content'] = $content;
    }

}

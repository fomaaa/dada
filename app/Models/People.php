<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class People extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'people';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable =
    [
        'sort',
        'position',
        'name_ru',
        'name_en',
        'photo_white',
        'photo_black',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function uploadPhoto($value)
    {
        $disk = 'public';
        $destinationPath = 'people/photos/';

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // 0. Make the image
            $image = Image::make($value);
            $image->resize(null,960, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            });


            // 1. Generate a filename.
            $extension = substr($value, strpos($value, '/') + 1, strpos($value, ';') - strpos($value, '/') - 1);
            $filename = md5($value . time()) . '.'.$extension;
            // 2. Store the image on disk.
            $filename_before='old'.$filename;
            //\Storage::disk($disk)->put($destinationPath . '/' . $filename, $image->stream());
            $path=storage_path('app/public/people/photos/'.$filename_before);
            // Оптимизируем
            //$image->save(public_path($filename));
            \Storage::disk($disk)->put($destinationPath . '/' . $filename_before, $image->stream());
            //$api = new \ImageOptim\API("nlbhtdbfzm");
            $api = new \ImageOptim\API("vlqppjrnwq");
            $imageData = $api->imageFromPath($path)->getBytes();
            $image2 = Image::make($imageData);

            \Storage::disk($disk)->put($destinationPath . '/' . $filename, $image2->stream());
            //File::delete($filename);
            /*$factory = new \ImageOptimizer\OptimizerFactory();
            $optimizer = $factory->get();
            $optimizer->optimize($path);
            */
            \Storage::disk($disk)->delete($destinationPath . '/' . $filename_before);
            // 3. Save the path to the database
            //$this->attributes[$attributeName] = 'storage/' . $destinationPath . '/' . $filename;
            return '/'.$destinationPath.$filename;

        }
        // Не base64, значит пришёл путь до картинки
        else
        {
            if($value==null)
            {
                return null;
            }
            $pos=strpos($value, '/people');
            $imgpath=substr($value, $pos, 999);
            return $imgpath;
        }

    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

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

    public function getPhotoWhiteAttribute()
    {
        $fileName = $this->attributes['photo_white'];
        if($fileName!= null)
        {
            $pathway = '/storage/app/public';
            return $pathway.$fileName;
        }
        else return null;
    }

    public function getPhotoBlackAttribute()
    {
        $fileName = $this->attributes['photo_black'];
        if($fileName!= null)
        {
            $pathway = '/storage/app/public';
            return $pathway.$fileName;
        }
        else return null;
    }

    public function setPhotoWhiteAttribute($value)
    {
        $img=People::UploadPhoto($value);
        $this->attributes['photo_white']=$img;
    }
    public function setPhotoBlackAttribute($value)
    {
        $img=People::UploadPhoto($value);
        $this->attributes['photo_black']=$img;
    }
}

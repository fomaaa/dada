<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class MetaData extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const PAGE_MAIN = 0;
    const PAGE_WORKS = 1;
    const PAGE_AGENCY = 2;

    protected $table = 'meta_data';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'title_ru',
        'title_en',
        'description_ru',
        'description_en',
        'image',
        'page',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function uploadImage($value)
    {
        $disk = 'public';
        $destinationPath = 'meta/';

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value . time()) . '.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destinationPath . '/' . $filename, $image->stream());
            $path=storage_path('app/public/meta/'.$filename);
            $factory = new \ImageOptimizer\OptimizerFactory();
            $optimizer = $factory->get();
            $optimizer->optimize($path);
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
            $pos=strpos($value, '/meta');
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

    public function setImageAttribute($value)
    {
        $img=MetaData::uploadImage($value);
        $this->attributes['image']= $img;
    }
}

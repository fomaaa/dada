<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\DB;

class Cases extends Model
{
    use CrudTrait;

    protected $appends = ['tags', 'preview'];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'cases';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable =
        [
            'title_ru',
            'campaign_en',
            'campaign_ru',
            'title_en',
            'sort',
            'url',
        ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getPreviewAttribute()
    {
        foreach ($this->blocks as $b) {
            if($b->type == 0) {
                $preview=$b->content['image'];

                return '/storage/app/public'.$preview;
            }
        }
    }
    public function getTagsAttribute()
    {
        foreach ($this->blocks as $b) {
            if($b->type == 1) {
                $tagsCompact=$b->content['tags'];
                $tagsArray = array();
                foreach($tagsCompact as $key => $tag)
                {
                    $tagsArray[$key]=$tag['tag'];
                }
                return $tagsArray;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function blocks()
    {
        return $this->hasMany('App\Models\Blocks', 'case_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeSort($query)
    {
            return $query->orderBy(DB::raw('CASE
                WHEN sort IS NULL THEN \'created_at DESC\'
                ELSE 1
                END,
                sort'))
                ->orderBy('created_at', 'DESC');
    }
    /*public function scopeSortReverse($query)
    {
        return $query->orderBy(DB::raw('CASE
                WHEN sort IS NULL THEN \'created_at DESC\'
                ELSE 1
                END,
                sort'), 'desc');
    }
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

    public function setUrlAttribute($value)
    {
        $this->attributes['URL']=strtolower($value);
    }
}

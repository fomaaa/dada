<?php


namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;


class ImageSize implements Rule
{
    public function passes($attribute, $value)
    {
        $size_in_bytes = (int) (strlen(rtrim($value, '=')) * 3 / 4);
        $size_in_kb    = $size_in_bytes / 1024;
        $size_in_mb    = $size_in_kb / 1024;

        /*if($size_in_mb>15)
        {
            return false;
        }
        */
        return true;
    }

    public function message()
    {
        return __('errors.crudImageSize');
    }
}
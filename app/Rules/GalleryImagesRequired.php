<?php


namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;


class GalleryImagesRequired implements Rule
{
    public function passes($attribute, $value)
    {
        $passed = false;
        if (isset($value)) {
            foreach ($value as $item) {
                if (starts_with($item, 'data:image') || (strpos($item, 'blocks/images/') !== false)) {
                $passed = true;
                } else {
                }
            }
        } else return false;
        // Passed everything
        if($passed) {
            return true;
        } else {
            return false;
        }
    }

    public function message()
    {
        return __('errors.crudGalleryImagesRequired');
    }
}
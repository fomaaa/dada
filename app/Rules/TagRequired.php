<?php


namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;


class TagRequired implements Rule
{
    public function passes($attribute, $value)
    {
        $val=json_decode($value);
        foreach($val as $v)
        {
            if(!isset($v->tag))
            {
                return false;
            }
        }
        return true;

    }

    public function message()
    {
        return __('errors.crudTagRequired');
    }
}
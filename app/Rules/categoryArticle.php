<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class categoryArticle implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category =["Shoes","Food","Desserts","Fruits","Informatics","Appliances","Furniture","Vehicles","Property","Habit","Food","Dessert"];
        
        if(!in_array($value,$category))
        {
            $fail('La categorie nexiste pas.');
        }
    }
}

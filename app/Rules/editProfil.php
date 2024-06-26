<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class editProfil implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Obtenez l'ID de l'utilisateur à partir de la session ou de toute autre source appropriée
        $userId = session('user');
        
        // Récupérer l'utilisateur correspondant à l'ID
        $user = User::find($userId);
        
        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if (!$user || $value !== $user->password) {
            $fail('Le mot de passe saisi est incorrect.');
        }
        
    }
}

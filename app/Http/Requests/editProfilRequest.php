<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\editProfil;

class editProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
            if ((request()->has('Name') || request()->has('Email')) && !(request()->has('Password') || request()->has('ConfirmPassword'))) {
                return [
                    'Name' => ['required'],
                    'Email' => ['required'],
                    'ActualPassword' => ['required', new editProfil],
                ];
            }
            elseif ((request()->has('Password') || request()->has('ConfirmPassword')) && !(request()->has('Name') || request()->has('Email'))) {
                return [
                    'Password' => ['required'],
                    'ConfirmPassword' => ['required','same:Password'],
                    'ActualPassword' => ['required', new editProfil],
                ];
            }
            elseif((request()->has('Password') || request()->has('Email')) && (request()->has('Password') || request()->has('ConfirmPassword'))) {
                return [
                    'Name' => ['required'],
                    'Email' => ['required'],
                    'Password' => ['required'],
                    'ConfirmPassword' => ['required', 'required','same:Password'],
                    'ActualPassword' => ['required', new editProfil],
                ];
            }
            else {
                return [
                    'ActualPassword' => ['required', new editProfil,'min_digits:1000'],
                ];
            }
    }
}

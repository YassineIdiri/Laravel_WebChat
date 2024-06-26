<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\categoryArticle;

class editArticleRequest extends FormRequest
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
        return [
            'titre' => ['required','max:50'],
            'prix' => ['required','regex:/^\d+(\.\d{1,2})?$/'],
            'category' => ['required',new categoryArticle],
            'description' =>['required'],
        ];
    }
}

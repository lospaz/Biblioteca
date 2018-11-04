<?php

namespace Modules\Library\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateBook extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasPermissionTo('library.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'isbn' => 'required|unique:books',
            'category_id' => 'required',
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'publishedDate' => 'required'
        ];
    }
}

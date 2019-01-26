<?php

namespace Modules\Library\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateLoan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasPermissionTo('library.loan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['nullable', 'exists:users,id', function($attribute, $value, $fail){
                if($this->name != null OR $this->surname != null OR $this->telephone)
                    $fail("Non è possibile inserire altri dati se si specifica l'utente.");
            }],
            'name' => 'required_without:user_id',
            'surname' => 'required_without:user_id',
            'telephone' => 'required_without:user_id',
        ];
    }
}

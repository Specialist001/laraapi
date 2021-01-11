<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->route()->getActionMethod()) {
            case 'register':
                return [
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                ];
            case 'login':
                return [
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:6',
                ];
        }

    }
}

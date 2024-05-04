<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'first_name' => $this->getMethod() == 'POST' ? 'required|string|max:255|user_name_validators|no_letters_user_name_validator' : 'string|max:255|user_name_validators|no_letters_user_name_validator',
            'last_name' => $this->getMethod() == 'POST' ? 'required|string|max:255|user_name_validators|no_letters_user_name_validator' : 'string|max:255|user_name_validators|no_letters_user_name_validator',
            'email' => $this->getMethod() == 'POST' ? 'required|string|email:rfc,dns|max:255|unique:users,email' : 'string|email:rfc,dns|max:255|unique:users,email,'.$this->user?->id,
            'password' => $this->getMethod() == 'POST' ? 'required|string|min:8|confirmed|max:255' : ($this->password != null ? 'sometimes|required|min:8|max:255' : ''),
            'password_confirmation' => $this->getMethod() == 'POST' ? 'required|string|min:8|same:password|max:255' : ($this->password != null ? 'required|string|min:8|same:password|max:255' : ''),
            'role' => 'required|exists:roles,id'
        ];
    }

    public function messages(){
        return [];
    }
}

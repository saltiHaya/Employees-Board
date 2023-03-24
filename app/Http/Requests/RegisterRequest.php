<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Roles;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required',
        ];

        if ($this->input('role') === Roles::Employee->value) {
            $rules['phone_number'] = '|required|string';
            $rules['hire_date'] = '|required|string';
            $rules['department'] = '|required|string';
            $rules['job_title'] = '|required|string';
            $rules['address_line_1'] = '|required|string';
            $rules['address_line_2'] = '|required|string';
            $rules['country'] = '|required|string';
            $rules['city'] = '|required|string';
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPostRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'name' => 'required',
            'password' => 'required',
            'role' => 'required|exists:roles,id',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }
    protected function store()
    {
        return [
            'email' => 'required|email|unique:users',
        ];
    }

    protected function update()
    {
        return [
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ];
    }

}

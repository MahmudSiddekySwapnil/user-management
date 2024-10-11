<?php
// app/Http/Requests/UserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user, // update rule for edit
            'password' => 'required|string|min:8|confirmed',
            'picture' => 'nullable|image|max:3048',
        ];
    }

    public function authorize()
    {
        return true;
    }
}

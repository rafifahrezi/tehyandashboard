<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // nanti bisa pakai policy
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'role'       => ['required', 'exists:roles,name'],
            'telp'       => ['nullable', 'string'],
            'jabatan'    => ['nullable', 'string'],
            'department' => ['nullable', 'string'],
        ];
    }
    /**
     * Custom error messages (opsional, lebih ramah user)
     */
    public function messages(): array
    {
        return [
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
            'password.min'           => 'Password minimal 8 karakter.',
            'password.required'      => 'Password wajib diisi.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'email.unique'           => 'Email sudah digunakan oleh user lain.',
            'role.exists'            => 'Role yang dipilih tidak valid.',
        ];
    }
    
}

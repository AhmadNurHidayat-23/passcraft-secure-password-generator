<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePasswordRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'length' => ['required', 'integer', 'min:6', 'max:64'],
            'uppercase' => ['nullable', 'boolean'],
            'lowercase' => ['nullable', 'boolean'],
            'numbers' => ['nullable', 'boolean'],
            'symbols' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Validasi tambahan untuk memastikan minimal satu set karakter dipilih.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $hasUpper = $this->boolean('uppercase');
            $hasLower = $this->boolean('lowercase');
            $hasNumbers = $this->boolean('numbers');
            $hasSymbols = $this->boolean('symbols');

            if (!$hasUpper && !$hasLower && !$hasNumbers && !$hasSymbols) {
                $validator->errors()->add('charset', 'Pilih minimal satu jenis karakter untuk kata sandi.');
            }
        });
    }

    /**
     * Pesan kustom untuk validasi bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'length.required' => 'Panjang kata sandi harus diisi.',
            'length.integer' => 'Panjang kata sandi harus berupa bilangan bulat.',
            'length.min' => 'Panjang kata sandi minimal adalah 6 karakter.',
            'length.max' => 'Panjang kata sandi maksimal adalah 64 karakter.',
        ];
    }
}


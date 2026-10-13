<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:160'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:3000'],
            'kvkk' => ['accepted'],
            // Honeypot: real visitors never fill this hidden field.
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'ad soyad',
            'phone' => 'telefon',
            'email' => 'e-posta',
            'subject' => 'konu',
            'message' => 'mesaj',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute alanı zorunludur.',
            'email' => 'Geçerli bir e-posta adresi giriniz.',
            'max' => ':attribute en fazla :max karakter olabilir.',
            'kvkk.accepted' => 'Devam etmek için KVKK aydınlatma metnini onaylamalısınız.',
            'website.prohibited' => 'Form gönderilemedi.',
        ];
    }
}

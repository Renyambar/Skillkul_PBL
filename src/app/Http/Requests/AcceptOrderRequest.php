<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi data saat client menerima pesanan dan memberikan review.
 */
class AcceptOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi dilakukan di controller
    }

    /**
     * Aturan validasi: rating wajib (1-5), komentar opsional.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'rating'  => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Pesan validasi berbahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer'  => 'Rating harus berupa angka.',
            'rating.between'  => 'Rating harus antara 1 sampai 5.',
            'comment.max'     => 'Komentar maksimal 1000 karakter.',
        ];
    }
}

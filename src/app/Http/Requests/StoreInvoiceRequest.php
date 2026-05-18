<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi data saat freelancer membuat Custom Invoice.
 */
class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi dilakukan di controller
    }

    /**
     * Aturan validasi untuk pembuatan custom invoice.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'client_email' => ['required', 'email', 'exists:users,email'],
            'service_id'   => ['required', 'exists:services,id'],
            'total_price'  => ['required', 'numeric', 'min:10000'],
            'order_notes'  => ['required', 'string', 'max:2000'],
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
            'client_email.required' => 'Email klien wajib diisi.',
            'client_email.email'    => 'Format email tidak valid.',
            'client_email.exists'   => 'Email ini belum terdaftar sebagai pengguna SkillKul.',
            'service_id.required'   => 'Pilih jasa yang akan ditagihkan.',
            'service_id.exists'     => 'Jasa yang dipilih tidak ditemukan.',
            'total_price.required'  => 'Harga kesepakatan wajib diisi.',
            'total_price.numeric'   => 'Harga harus berupa angka.',
            'total_price.min'       => 'Harga minimum adalah Rp 10.000.',
            'order_notes.required'  => 'Catatan/deskripsi pekerjaan wajib diisi.',
            'order_notes.max'       => 'Catatan maksimal 2000 karakter.',
        ];
    }
}

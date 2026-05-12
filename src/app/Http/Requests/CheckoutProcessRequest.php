<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi data saat client memproses checkout (catatan & link gdrive).
 */
class CheckoutProcessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi dilakukan di controller
    }

    /**
     * Aturan validasi untuk proses checkout.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_notes'      => ['nullable', 'string', 'max:1000'],
            'client_gdrive_link' => ['nullable', 'url', 'max:500'],
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
            'order_notes.max'           => 'Catatan pesanan maksimal 1000 karakter.',
            'client_gdrive_link.url'    => 'Link Google Drive harus berupa URL yang valid.',
            'client_gdrive_link.max'    => 'Link Google Drive maksimal 500 karakter.',
        ];
    }
}

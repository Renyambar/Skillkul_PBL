<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi data saat freelancer mengirim link hasil pekerjaan.
 */
class SubmitResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi dilakukan di controller
    }

    /**
     * Aturan validasi: link hasil wajib diisi dan harus URL valid.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'freelancer_result_link' => ['required', 'url', 'max:500'],
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
            'freelancer_result_link.required' => 'Link hasil pekerjaan wajib diisi.',
            'freelancer_result_link.url'      => 'Link hasil pekerjaan harus berupa URL yang valid.',
            'freelancer_result_link.max'      => 'Link hasil pekerjaan maksimal 500 karakter.',
        ];
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * ValidNim Validation Rule
 *
 * Memvalidasi format NIM (Nomor Induk Mahasiswa) SkillKul.
 *
 * Format: 24410700001
 * ├── 2 digit pertama  : Tahun masuk (contoh: 24 = 2024), tidak boleh > tahun sekarang
 * ├── 5 digit berikutnya: Kode institusi tetap = 41070
 * └── 4 digit terakhir : Nomor urut mahasiswa (0001 dst.)
 *
 * Total: 11 digit numerik
 *
 * Usage:
 *   'nim' => ['required', 'string', new ValidNim, 'unique:users,nim']
 */
class ValidNim implements ValidationRule
{
    /**
     * Kode institusi yang valid (5 digit, posisi ke-3 s/d ke-7).
     */
    protected const INSTITUTION_CODE = '41070';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nim = (string) $value;

        // 1. Harus 11 digit
        if (! preg_match('/^\d{11}$/', $nim)) {
            $fail('NIM harus terdiri dari tepat 11 digit angka.');
            return;
        }

        // 2. Digit ke-3 s/d ke-7 (index 2..6) harus = kode institusi
        $institutionCode = substr($nim, 2, 5);
        if ($institutionCode !== self::INSTITUTION_CODE) {
            $fail('NIM tidak valid. Digit ke-3 hingga ke-7 harus bernilai ' . self::INSTITUTION_CODE . ' (kode institusi).');
            return;
        }

        // 3. Tahun masuk (2 digit pertama) tidak boleh melebihi tahun sekarang
        $tahunMasuk    = (int) substr($nim, 0, 2);
        $tahunSekarang = (int) date('y'); // 2-digit representation of current year
        if ($tahunMasuk > $tahunSekarang) {
            $fail('Tahun masuk pada NIM tidak boleh melebihi tahun sekarang (' . date('Y') . ').');
            return;
        }

        // 4. Nomor urut (4 digit terakhir) tidak boleh 0000
        $nomorUrut = substr($nim, 7, 4);
        if ($nomorUrut === '0000') {
            $fail('Nomor urut pada NIM tidak valid.');
            return;
        }
    }
}

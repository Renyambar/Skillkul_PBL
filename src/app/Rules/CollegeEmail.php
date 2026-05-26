<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * CollegeEmail Validation Rule
 *
 * Ensures that a given email address belongs to a recognized college domain.
 * The primary check requires the email to end with '.ac.id' (Indonesian college TLD).
 * Additional whitelisted domains can be added to $allowedDomains.
 *
 * Usage in validation:
 *   'email' => ['required', 'email', new CollegeEmail]
 */
class CollegeEmail implements ValidationRule
{
    /**
     * List of explicitly allowed college domains.
     * Add specific domains here if needed beyond the '.ac.id' rule.
     *
     * @var string[]
     */
    protected array $allowedDomains = [
        'polinema.ac.id',
        'ub.ac.id',
        'um.ac.id',
        'unibraw.ac.id',
        'its.ac.id',
        'ui.ac.id',
        'ugm.ac.id',
        'itb.ac.id',
        'unair.ac.id',
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $email = strtolower(trim((string) $value));

        // Primary check: must end with '.ac.id'
        if (str_ends_with($email, '.ac.id')) {
            return; // Valid — passes the rule
        }

        // Secondary check: explicit domain whitelist (for edge cases)
        $domain = substr($email, strpos($email, '@') + 1);
        if (in_array($domain, $this->allowedDomains, true)) {
            return; // Valid — passes the rule
        }

        $fail('Email harus menggunakan alamat email kampus (contoh: nama@mahasiswa.polinema.ac.id). Platform ini hanya untuk mahasiswa.');
    }
}

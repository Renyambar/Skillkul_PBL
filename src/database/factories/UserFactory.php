<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $role = fake()->randomElement(['freelancer', 'client']);

        // Generate a realistic Indonesian college email
        $firstName   = strtolower(fake()->firstName());
        $nim         = fake()->unique()->numerify('22417#####');
        $domains     = ['mahasiswa.polinema.ac.id', 'student.ub.ac.id', 'student.um.ac.id', 'itb.ac.id'];
        $email       = "{$firstName}.{$nim}@" . fake()->randomElement($domains);

        return [
            'name'                => fake()->name(),
            'nim'                 => $role === 'freelancer' ? $nim : null,
            'email'               => $email,
            'email_verified_at'   => now(),
            'password'            => static::$password ??= Hash::make('password'),
            'role'                => $role,
            'phone_number'        => fake()->numerify('08##########'),
            'profile_description' => fake()->boolean(70) ? fake()->randomElement([
                'Mahasiswa tingkat akhir yang senang berkreasi dan memecahkan masalah. Berpengalaman dalam organisasi dan siap membantu proyek Anda.',
                'Saya seorang desainer lepas dengan pengalaman 2 tahun di bidang UI/UX. Fokus pada desain yang bersih dan ramah pengguna.',
                'Pengembang web antusias yang suka menulis kode bersih. Menguasai PHP, Laravel, dan sedikit Vue.js.',
                'Penulis artikel dengan pengalaman menerbitkan berbagai karya tulis di majalah kampus. Teliti dan tepat waktu.',
                'Menerima jasa terjemahan bahasa Inggris-Indonesia. Memiliki skor TOEFL 600 dan sering menerjemahkan jurnal akademik.',
                'Mahasiswa Sistem Informasi yang siap membantu analisis data dan pembuatan laporan. Terbiasa dengan Excel dan SPSS.'
            ]) : null,
            'is_exam_mode'        => fake()->boolean(10), // 10% chance exam mode on
            'is_auto_portfolio'   => fake()->boolean(80),
            'is_active'           => true, // New accounts are always active
            'wallet_balance'      => fake()->randomFloat(2, 0, 500000),
            'remember_token'      => Str::random(10),
        ];
    }

    /**
     * State: force freelancer role.
     */
    public function freelancer(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'freelancer',
            'nim'  => fake()->unique()->numerify('22417#####'),
        ]);
    }

    /**
     * State: force client role.
     */
    public function client(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'client',
            'nim'  => null,
        ]);
    }

    /**
     * State: suspended account.
     */
    public function suspended(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

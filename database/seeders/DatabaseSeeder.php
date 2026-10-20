<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@kozanhavuz.com.tr');
        $password = env('ADMIN_PASSWORD');

        if (! User::query()->where('email', $email)->exists()) {
            $password ??= app()->isProduction() ? Str::password(16) : 'password';

            User::query()->create([
                'name' => 'Kozan Havuz Yönetici',
                'email' => $email,
                'password' => $password,
            ]);

            $this->command?->info("Admin kullanıcısı: {$email} / {$password}");
        }

        $this->call([SiteContentSeeder::class, ExpandedOfferingsSeeder::class]);
    }
}

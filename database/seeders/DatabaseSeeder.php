<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Seeds;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PasienSeeder::class);
        $this->call(DataDentist::class);
        $this->call(DataService::class);
        $this->call(KunjunganSeeder::class);
        $this->call(DataKota::class);
        $this->call(DataKecamatan::class);
        $this->call(DataKelurahan::class);

    }
}

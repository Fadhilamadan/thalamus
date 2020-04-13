<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(usersSeeder::class);
        $this->call(faskesSeeder::class);
        $this->call(layananSeeder::class);
        $this->call(asuransiSeeder::class);
        $this->call(dokterSeeder::class);
        $this->call(penyakitSeeder::class);
    }
}
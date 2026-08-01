<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Tables\MenusSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CmsSeeder::class);
        $this->call(ContainerFieldSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(WmsSeeder::class);
        $this->call(KalibrasiAlkesSeeder::class);
    }
}

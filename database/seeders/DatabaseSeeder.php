<?php

namespace Eduard\Account\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            TokenSystem::class,
            ConfigBaseFrontend::class
        ]);
    }
}
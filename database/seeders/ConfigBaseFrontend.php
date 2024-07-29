<?php

namespace Eduard\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigBaseFrontend extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("config_base_frontend")->insert([
            "key" => "site_name",
            "value" => env("APP_NAME"),
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => null
        ]);
    }
}
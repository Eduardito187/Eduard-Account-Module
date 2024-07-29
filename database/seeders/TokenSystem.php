<?php

namespace Eduard\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Eduard\Account\Models\SystemToken;
use Illuminate\Support\Facades\DB;

class TokenSystem extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (SystemToken::count() == 0) {
            DB::table("system_token")->insert([
                "id" => 1,
                "name" => "System",
                "token" => env("TOKEN_SERVER"),
                "status" => true,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => null
            ]);
        }
    }
}
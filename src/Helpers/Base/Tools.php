<?php

namespace Eduard\Account\Helpers\Base;

use Eduard\Account\Models\Config;
use Eduard\Account\Models\Ip;
use Eduard\Account\Models\RestrictIp;
use Illuminate\Support\Facades\Hash;
use Eduard\Account\Models\Migrations;
use Illuminate\Support\Str;

class Tools
{
    public function __construct()
    {
        //
    }

    /**
     * @return array
     */
    public function getAllRestrictIp()
    {
        $restrictIp = RestrictIp::all();

        return $restrictIp->toArray();
    }

    /**
     * @return array|null
     */
    public function getMunicipalityArray($municipality)
    {
        if (is_null($municipality)) {
            return null;
        }

        return array(
            "id" => $municipality->id,
            "name" => $municipality->name,
            "city" => $municipality->getCity->toArray()
        );
    }

    /**
     * @return array
     */
    public function getAllMigrations()
    {
        $migrations = Migrations::all();

        return $migrations->toArray();
    }

    /**
     * @return array
     */
    public function getAllIp()
    {
        $ip = Ip::all();

        return $ip->toArray();
    }

    /**
     * @return array
     */
    public function getAllConfig()
    {
        $configSystem = Config::all();

        return $configSystem->toArray();
    }

    /**
     * @param string|int|float value
     * @return string
     */
    public function generate64B(string|int|float $value)
    {
        return base64_encode($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function generateToken(string $value){
        return Hash::make($value, [
            "rounds" => 12,
        ]);
    }

    /**
     * @return string
     */
    static public function generateTokenFrontendRandom()
    {
        $timestamp = now()->timestamp;
        $randomString = Str::random(12);
        $randomValue = $timestamp . '_' . $randomString;

        return Hash::make($randomValue, [
            "rounds" => 12,
        ]);
    }
}
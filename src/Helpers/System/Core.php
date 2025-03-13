<?php

namespace Eduard\Account\Helpers\System;

use Exception;
use Eduard\Account\Models\Ip;
use Eduard\Account\Models\Config;
use Eduard\Account\Models\Migrations;
use Eduard\Account\Models\RestrictIp;
use Eduard\Account\Models\RestrictDomain;

class Core
{
    public function __construct() {
    }

    /**
     * @inheritDoc
     */
    public function getAllIp()
    {
        return Ip::all();
    }

    /**
     * @inheritDoc
     */
    public function getAllConfig()
    {
        return Config::all();
    }

    /**
     * @inheritDoc
     */
    public function getAllMigrations()
    {
        return Migrations::all();
    }

    /**
     * @inheritDoc
     */
    public function getAllRestrictIp()
    {
        return RestrictIp::all();
    }

    /**
     * @inheritDoc
     */
    public function getAllRestrictDomain()
    {
        return RestrictDomain::all();
    }

    /**
     * @inheritDoc
     */
    public function isValidIp($ip)
    {
        return !RestrictIp::where('ip', $ip)->where('status', true)->exists();
    }
}
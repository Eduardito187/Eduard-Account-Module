<?php

namespace Eduard\Account\Helpers\Base;

use Eduard\Account\Models\Config;

class ConfigFrontend
{
    const TOKEN_ACCESS_FRONTEND = 'token_access_frontend';
    const BASE_URL_FRONTEND = 'base_url_frontend';
    const VERSION_FRONTEND = 'version_frontend';
    const APP_NAME_FRONTEND = 'app_name_frontend';
    const COPYRIGHT_FRONTEND = 'copyright_frontend';
    const ENVIRONMENT_FRONTEND = 'environment_frontend';
    const SERVER_YEAR = 'server_year';
    const DATE_SERVER = 'date_server';

    /**
     * Constructor ConfigFrontend
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    static public function getConfigFrontend()
    {
        return [
            self::TOKEN_ACCESS_FRONTEND => self::getValueConfig(self::TOKEN_ACCESS_FRONTEND),
            self::BASE_URL_FRONTEND => self::getValueConfig(self::BASE_URL_FRONTEND),
            self::VERSION_FRONTEND => self::getValueConfig(self::VERSION_FRONTEND),
            self::APP_NAME_FRONTEND => self::getValueConfig(self::APP_NAME_FRONTEND),
            self::COPYRIGHT_FRONTEND => self::getValueConfig(self::COPYRIGHT_FRONTEND),
            self::ENVIRONMENT_FRONTEND => self::getValueConfig(self::ENVIRONMENT_FRONTEND),
            self::SERVER_YEAR => date("Y"),
            self::DATE_SERVER => date("Y-m-d H:i:s")
        ];
    }

    /**
     * @param string $codeConfig
     * @return string
     */
    static public function getValueConfig($codeConfig)
    {
        $valueConfig = Config::where('code', $codeConfig)->where('status', true)->first();

        if ($valueConfig) {
            return $valueConfig->value;
        }

        return '';
    }
}
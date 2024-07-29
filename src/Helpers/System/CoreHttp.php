<?php

namespace Eduard\Account\Helpers\System;

use Eduard\Search\Models\IndexConfiguration;
use Exception;
use Eduard\Account\Models\AutorizationToken;
use Eduard\Account\Helpers\Text\Translate;
use Eduard\Account\Models\Config;
use Eduard\Account\Models\RestrictDomain;
use Eduard\Account\Models\SystemToken;
use Eduard\Account\Models\HistoryCustomersUuid;

class CoreHttp
{
    /**
     * @var Translate
     */
    protected $translate;

    /**
     * @var array
     */
    public $responseApi = [];

    public function __construct(Translate $translate) {
        $this->translate = $translate;
    }

    /**
     * @inheritDoc
     */
    public function constructResponse($response, $responseText = "", $code = 500, $status = false)
    {
        return array(
            "response" => $response,
            "responseText" => $responseText,
            "code" => $code,
            "status" => $status
        );
    }

    /**
     * @inheritDoc
     */
    public function constructResponseProcess($type, $sku)
    {
        $this->responseApi[] = array("type" => $type, "sku" => $sku, "timestamp" => date("Y-m-d H:i:s"));
    }

    /**
     * @inheritDoc
     */
    public function restrictDoamin(string $domain)
    {
        return RestrictDomain::where('domain', $domain)->where('status', true)->exists();
    }

    /**
     * @inheritDoc
     */
    public function existApiKey(string $apiKey)
    {
        return IndexConfiguration::where('api_key', $apiKey)->where('status', true)->exists();
    }

    /**
     * @inheritDoc
     */
    public function existApiKeyAll(string $apiKey)
    {
        return IndexConfiguration::where('api_key', $apiKey)->exists();
    }

    /**
     * @inheritDoc
     */
    public function validateApiKey($headers, $all = false)
    {
        if (!array_key_exists("api-key", $headers)) {
            throw new Exception("No existe api-key.");
        }

        if (count($headers["api-key"]) == 0) {
            throw new Exception("El api-key esta vacio.");
        }

        if ($all) {
            if (!$this->existApiKeyAll($headers["api-key"][0])) {
                throw new Exception("El Api-Key no se encuentra asignado a un indice.");
            }
        } else {
            if (!$this->existApiKey($headers["api-key"][0])) {
                throw new Exception("El indice perteneciente al Api-Key se encuentra desactivado.");
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getToken($token)
    {
        if ($token == null) {
            return null;
        }

        $token = explode($this->translate->getSpace(), $token);

        if (count($token) == 2) {
            return $token[1];
        } else {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function isValidToken($token)
    {
        $token = $this->getToken($token);

        if ($token == null) {
            return false;
        }

        if (AutorizationToken::where('token', $token)->where('status', true)->exists()) {
            return true;
        } else {
            if (Config::where('code', 'token_access_frontend')->where('value', $token)->where('status', true)->exists()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function isValidAdminToken($token)
    {
        $token = $this->getToken($token);

        if ($token == null) {
            return false;
        }

        return SystemToken::where('token', $token)->where('status', true)->exists();
    }

    /**
     * @inheritDoc
     */
    public function getTokenRequest($header)
    {
        $authorization = $header["authorization"];

        if (count($authorization) == 0) {
            throw new Exception("Error en autorización.");
        }

        $token = $this->getToken($authorization[0]);

        if ($token == null) {
            throw new Exception("Error en autorización.");
        }

        return $token;
    }

    /**
     * @inheritDoc
     */
    public function validateTokenRequest($header)
    {
        $authorization = $header["authorization"];

        if (count($authorization) == 0) {
            throw new Exception("Error en autorización.");
        }

        $token = $this->getToken($authorization[0]);

        if ($token == null) {
            throw new Exception("Error en autorización.");
        }

        return AutorizationToken::where('token', $token)->where('status', true)->exists();
    }

    /**
     * @inheritDoc
     */
    public function getClientToken($token)
    {
        return AutorizationToken::where('token', $token)->where('status', true)->first();
    }

    /**
     * @inheritDoc
     */
    public function setCustomerHistoryUuid($ip, $customerUuid)
    {
        $entry = HistoryCustomersUuid::where('ip', $ip)->where('customer_uuid', $customerUuid)->whereDate('created_at', date("Y-m-d"))->first();

        if (!$entry) {
            $this->saveHistoryUuid($ip, $customerUuid);
        }
    }

    /**
     * @inheritDoc
     */
    public function saveHistoryUuid($ip, $customerUuid)
    {
        try {
            $newHistoryCustomersUuid = new HistoryCustomersUuid();
            $newHistoryCustomersUuid->ip = $ip;
            $newHistoryCustomersUuid->customer_uuid = $customerUuid;
            $newHistoryCustomersUuid->created_at = date("Y-m-d H:i:s");
            $newHistoryCustomersUuid->updated_at = null;
            $newHistoryCustomersUuid->save();
        } catch (Exception $e) {
            return null;
        }
    }
}
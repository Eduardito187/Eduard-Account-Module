<?php

namespace Eduard\Account\Helpers\System;

use Exception;
use Eduard\Account\Helpers\Text\Translate;
use Eduard\Account\Helpers\System\CoreHttp;
use Eduard\Account\Models\AutorizationToken;
use Eduard\Account\Models\Client as ModelClient;
use Illuminate\Support\Str;
use Eduard\Search\Helpers\Search\Import;
use Illuminate\Support\Facades\Log;

class Client
{
    /**
     * @var Translate
     */
    protected $translate;

    /**
     * @var CoreHttp
     */
    protected $coreHttp;

    /**
     * @var Import
     */
    public $proccessImport;

    public function __construct(Translate $translate, CoreHttp $coreHttp, Import $import) {
        $this->translate = $translate;
        $this->coreHttp = $coreHttp;
        $this->proccessImport = $import;
    }

    /**
     * @inheritDoc
     */
    public function proccessCreateCliente($params, $headers)
    {
        try {
            if (!is_array($params) || !array_key_exists("name", $params) || !array_key_exists("code", $params)) {
                throw new Exception("Formato incorrecto de consulta.");
            }
    
            if (!is_string($params["name"]) || !is_string($params["code"])) {
                throw new Exception("El parametro que se esta pasando es incorrecto");
            }

            if ($this->isValiClientCode($params["code"])) {
                throw new Exception("El codigo de cliente ya se encuentra registrado.");
            }

            $currentClient = $this->createClient($params["name"], $params["code"]);

            if (array_key_exists("index", $params) ) {
                if (!is_array($params["index"])) {
                    throw new Exception("El parametro index no cumple con el formato requerido.");
                } else {
                    $this->proccessImport->importIndexCatalog($params["index"], $currentClient);
                }
            }

            if (array_key_exists("attributes", $params) ) {
                if (!is_array($params["attributes"])) {
                    throw new Exception("El parametro attributes no cumple con el formato requerido.");
                } else {
                    $this->proccessImport->importAttributes($params["attributes"], $currentClient);
                }
            };

            if (array_key_exists("products", $params) ) {
                if (!is_array($params["products"])) {
                    throw new Exception("El parametro products no cumple con el formato requerido.");
                } else {
                    foreach ($currentClient->indexes as $key => $index) {
                        $this->proccessImport->importProducts($params["products"], $currentClient, $index->id);
                    }
                }
            }
            
            return $this->coreHttp->constructResponse([], "Proceso ejecutado exitosamente.", 200, true);
        } catch (Exception $e) {
            return $this->coreHttp->constructResponse([], $e->getMessage(), 500, false);
        }
    }

    /**
     * @inheritDoc
     */
    public function createClient($name, $code)
    {
        try {
            $newModelClient = new ModelClient();
            $newModelClient->name = $name;
            $newModelClient->code = $code;
            $newModelClient->count_attributes = 0;
            $newModelClient->count_products = 0;
            $newModelClient->count_index = 0;
            $newModelClient->status = 0;
            $newModelClient->created_at = date("Y-m-d H:i:s");
            $newModelClient->updated_at = null;
            $newModelClient->save();
            $this->createAccessToken($name, $newModelClient->id);
            return $newModelClient;
        } catch (Exception $th) {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isValiClientCode($code)
    {
        return ModelClient::where('code', $code)->exists();
    }

    public function createAccessToken($name, $idClient)
    {
        try {
            $AutorizationToken = new AutorizationToken();
            $AutorizationToken->name = $name;
            $AutorizationToken->token = $this->generateToken();
            $AutorizationToken->status = 0;
            $AutorizationToken->id_client = $idClient;
            $AutorizationToken->created_at = date("Y-m-d H:i:s");
            $AutorizationToken->updated_at = null;
            $AutorizationToken->save();
            return $AutorizationToken->id;
        } catch (Exception $th) {
            return null;
        }
    }

    public function generateToken()
    {
        $token = "";

        do {
            $token = Str::random(32);
        } while ($this->isClientValidToken($token));

        return $token;
    }

    /**
     * @return bool
     */
    public function isClientValidToken($code)
    {
        return AutorizationToken::where('token', $code)->exists();
    }
}
<?php

namespace Eduard\Account\Http\Controllers\Api\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Eduard\Account\Helpers\System\CoreHttp;
use Eduard\Account\Helpers\System\Client;

class Core extends Controller
{
    /**
     * @var CoreHttp
     */
    protected $coreHttp;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(CoreHttp $coreHttp, Client $client) {
        $this->coreHttp = $coreHttp;
        $this->client = $client;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createClient(Request $request)
    {
        return response()->json(
            $this->client->proccessCreateCliente(
                $request->all(),
                $request->header()
            )
        );
    }
}
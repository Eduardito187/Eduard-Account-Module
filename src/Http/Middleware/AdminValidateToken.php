<?php

namespace Eduard\Account\Http\Middleware;

use \Closure;
use \Illuminate\Http\Request;
use Eduard\Account\Helpers\Text\Translate;
use \Illuminate\Http\Response;
use \Illuminate\Http\RedirectResponse;
use Eduard\Account\Helpers\System\Core;
use Eduard\Account\Helpers\System\CoreHttp;

class AdminValidateToken
{
    const ERROR_402 = 402;
    const ERROR_404 = 404;

    /**
     * @var Translate
     */
    protected $translate;

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var CoreHttp
     */
    protected $coreHttp;

    public function __construct(Translate $translate, Core $core, CoreHttp $coreHttp)
    {
        $this->translate = $translate;
        $this->core = $core;
        $this->coreHttp = $coreHttp;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getHost() != "" || $request->getHost() != null) {
            if ($this->coreHttp->restrictDoamin($request->getHost())) {
                return abort(self::ERROR_404, $this->translate->getAccessDecline());
            }
        }

        if (
            $this->core->isValidIp($request->ip()) &&
            $request->header($this->translate->getAuthorization()) != null
        ) {
            if ($this->coreHttp->isValidAdminToken($request->header($this->translate->getAuthorization()))) {
                return $next($request);
            } else {
                return abort(self::ERROR_402, $this->translate->getTokenDecline());
            }
        } else {
            return abort(self::ERROR_404, $this->translate->getAccessDecline());
        }
    }
}
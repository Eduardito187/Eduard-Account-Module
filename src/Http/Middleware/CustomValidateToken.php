<?php

namespace Eduard\Account\Http\Middleware;

use Eduard\Account\Events\HistoryCustomerUuid;
use \Closure;
use \Illuminate\Http\Request;
use Eduard\Account\Helpers\Text\Translate;
use \Illuminate\Http\Response;
use \Illuminate\Http\RedirectResponse;
use Eduard\Account\Helpers\System\Core;
use Eduard\Account\Helpers\System\CoreHttp;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

class CustomValidateToken
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
        Session::put('start_time', microtime(true));

        if ($request->getHost() != "" || $request->getHost() != null) {
            if ($this->coreHttp->restrictDoamin($request->getHost())) {
                return abort(self::ERROR_404, $this->translate->getAccessDecline());
            }
        }

        if (
            $this->core->isValidIp($request->ip()) &&
            $request->header($this->translate->getAuthorization()) != null
        ) {
            if ($this->coreHttp->isValidToken($request->header($this->translate->getAuthorization()))) {
                if ($request->header($this->translate->getCustomerUuid()) != null) {
                    Event::dispatch(
                        new HistoryCustomerUuid(
                            $request->ip(),
                            $request->header($this->translate->getCustomerUuid())
                        )
                    );
                }

                return $next($request);
            } else {
                return abort(self::ERROR_402, $this->translate->getTokenDecline());
            }
        } else {
            return abort(self::ERROR_404, $this->translate->getAccessDecline());
        }
    }
}
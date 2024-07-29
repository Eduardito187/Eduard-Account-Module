<?php

namespace Eduard\Account\Helpers;

use Exception;
use Illuminate\Support\Facades\View;
use Eduard\Account\Helpers\Base\ConfigFrontend;

class SendMail
{
    protected $to;
    protected $title;
    protected $message;
    protected $headers = [];

    public function __construct(string $view, string $to, string $title, array $dataMail)
    {
        $this->to = $to;
        $this->title = $title;

        if (is_array($dataMail)) {
            $dataMail["base_url"] = ConfigFrontend::getValueConfig(ConfigFrontend::BASE_URL_FRONTEND);
            $dataMail["app_name"] = ConfigFrontend::getValueConfig(ConfigFrontend::APP_NAME_FRONTEND);
        }

        $this->message = $this->renderView($view, $dataMail);
        $this->setHeaders();
        $this->createMail();
    }

    protected function renderView($view, $data)
    {
        if (View::exists($view)) {
            return View::make($view, $data)->render();
        }

        throw new Exception("View {$view} not found");
    }

    protected function setHeaders()
    {
        $this->headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: EduardSearch <no-reply@eduardsearch.com>',
            'Reply-To: no-reply@eduardsearch.com',
            'X-Mailer: PHP/' . phpversion()
        ];
    }

    public function createMail()
    {
        try {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            $headers = implode("\r\n", $this->headers);

            return mail($this->to, $this->title, $this->message, $headers);
        } catch (Exception $e) {
            return false;
        }
    }
}
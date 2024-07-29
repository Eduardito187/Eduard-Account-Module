<?php

namespace Eduard\Account\Helpers;

use Eduard\Account\Helpers\Text\Translate;

class TokenAccess
{
    /**
     * @var Translate
     */
    protected $translate;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param string $token
     */
    public function __construct(
        string $token
    ) {
        $this->token = $token;
        $this->translate = new Translate();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        if ($this->token == null) {
            return null;
        }

        $token = explode($this->translate->getSpace(), $this->token);

        if (count($token) == 2) {
            return $token[1];
        } else {
            return null;
        }
    }
}

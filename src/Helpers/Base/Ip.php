<?php

namespace Eduard\Account\Helpers\Base;

use Illuminate\Support\Facades\Log;
use Eduard\Account\Helpers\Text\Translate;
use Eduard\Account\Models\Ip as Model_Ip;
use Eduard\Account\Models\RestrictIp;
use Eduard\Account\Helpers\Base\Date;
use \Exception;

class Ip
{
    /**
     * @var Date
     */
    protected $date;
    /**
     * @var string|null
     */
    protected $IP = null;
    /**
     * @var Translate
     */
    protected $translate;

    public function __construct(string $ip)
    {
        $this->IP = $ip;
        $this->translate = new Translate();
        $this->date = new Date();
    }

    /**
     * @return array
     */
    public function getGeo()
    {
        $data = json_decode(file_get_contents($this->translate->getIpHost() . $this->IP . $this->translate->getBarraJson()));

        if ($this->IP == $this->translate->getLocalhost()) {
            $localization = [$this->translate->getCero(), $this->translate->getCero()];
        } else {
            $localization = explode($this->translate->getComa(), $data->loc);
        }

        return [
            $this->translate->getLatitude() => $localization[0],
            $this->translate->getLongitude() => $localization[1]
        ];
    }

    /**
     * @return bool
     */
    public function validRestrict()
    {
        $restrict_ip = $this->getRestrictIp();

        if (!$restrict_ip) {
            return true;
        }

        return false;
    }

    /**
     * @return int|null
     */
    public function validIp()
    {
        $ip = $this->getIp();

        if (!$ip) {
            return $this->addIp();
        }

        return $ip->id;
    }

    /**
     * @return Model_Ip
     */
    public function getIp()
    {
        return Model_Ip::where($this->translate->getIp(), $this->IP)->first();
    }

    /**
     * @return int|null
     */
    public function addIp()
    {
        try {
            $Model_Ip = new Model_Ip();
            $Model_Ip->ip = $this->IP;
            $Model_Ip->created_at = $this->date->getFullDate();
            $Model_Ip->updated_at = null;
            $Model_Ip->save();
            return $Model_Ip->id;
        } catch (Exception $th) {
            return null;
        }
    }

    /**
     * @return RestrictIp
     */
    public function getRestrictIp()
    {
        return RestrictIp::where($this->translate->getIp(), $this->IP)->first();
    }
}

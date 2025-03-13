<?php

namespace Eduard\Account\Helpers\Base;

use Carbon\Carbon;
use Eduard\Account\Helpers\Text\Translate;

class Date
{
    /**
     * @var Translate
     */
    protected $translate;

    public function __construct()
    {
        $this->translate = new Translate();
        date_default_timezone_set($this->translate->getTimeZone());
    }

    /**
     * @param string $date
     * @param string|null $date_
     * @param bool|null $status
     * @return string|null
     */
    public function getDiferenceInDates(string $date, string|null $date_, bool|null $status)
    {
        if (is_null($date_) || strlen($date_) == 0) {
            return null;
        }

        $Year = $this->getDiferenceYear($date, $date_);
        $Month = $this->getDiferenceMonth($date, $date_);
        $Days = $this->getDiferenceDays($date, $date_);
        if ($status === true) {
            return $this->getDiferenceCreated($Year, $Month, $Days);
        } else if ($status === false) {
            return $this->getDiferenceUpdated($Year, $Month, $Days);
        } else {
            $Hours = $this->getDiferenceHours($date, $date_);
            $Minutes = $this->getDiferenceMinutes($date, $date_);
            return $this->getDiferenceUpdatedInit($Year, $Month, $Days, $Hours, $Minutes);
        }
    }

    /**
     * @param string|int $Year
     * @param string|int $Month
     * @param string|int $Days
     * @return string
     */
    public function getDiferenceCreated(string|int $Year, string|int $Month, string|int $Days)
    {
        if ($Year > 0) {
            return $this->translate->getDiferenceYear($this->translate->getCreado(), $Year);
        } else if ($Month > 0) {
            return $this->translate->getDiferenceMonth($this->translate->getCreado(), $Month);
        } else {
            if ($Days > 0) {
                return $this->translate->getDiferenceDays($this->translate->getCreado(), $Days);
            } else {
                return $this->translate->getCreadoNow();
            }
        }
    }

    /**
     * @param string|int $Year
     * @param string|int $Month
     * @param string|int $Days
     * @return string
     */
    public function getDiferenceUpdated(string|int $Year, string|int $Month, string|int $Days)
    {
        if ($Year > 0) {
            return $this->translate->getDiferenceYear($this->translate->getModificado(), $Year);
        } else if ($Month > 0) {
            return $this->translate->getDiferenceMonth($this->translate->getModificado(), $Month);
        } else {
            if ($Days > 0) {
                return $this->translate->getDiferenceDays($this->translate->getModificado(), $Days);
            } else {
                return $this->translate->getModificadoNow();
            }
        }
    }

    /**
     * @param int $Year
     * @param int $Month
     * @param int $Days
     * @param int $Hours
     * @param int $Minutes
     * @return string|int
     */
    public function getDiferenceUpdatedInit(int $Year, int $Month, int $Days, int $Hours, int $Minutes)
    {
        if ($Year > 0) {
            return $this->translate->concatTwoString($Year, $this->translate->getYearPhp());
        } else if ($Month > 0) {
            return $this->translate->concatTwoString($Month, $this->translate->getMonthPhp());
        } else {
            if ($Days > 0) {
                return $this->translate->concatTwoString($Days, $this->translate->getDayPhp());
            } else {
                if ($Hours > 0) {
                    return $this->translate->concatTwoString($Hours, $this->translate->getHoursPhp());
                } else {
                    return $this->translate->concatTwoString($Minutes, $this->translate->getMinutesPhp());
                }
            }
        }
    }

    /**
     * @param string $date
     * @param string $date_
     * @return string
     */
    public function getDiferenceYear(string $date, string $date_)
    {
        $toDate = Carbon::parse($date);
        $fromDate = Carbon::parse($date_);
        return $toDate->diffInYears($fromDate);
    }

    /**
     * @param string $date
     * @param string $date_
     * @return string
     */
    public function getDiferenceMonth(string $date, string $date_)
    {
        $toDate = Carbon::parse($date);
        $fromDate = Carbon::parse($date_);
        return $toDate->diffInMonths($fromDate);
    }

    /**
     * @param string $date
     * @param string $date_
     * @return string
     */
    public function getDiferenceDays(string $date, string $date_)
    {
        $toDate = Carbon::parse($date);
        $fromDate = Carbon::parse($date_);
        return $toDate->diffInDays($fromDate);
    }

    /**
     * @param string $date
     * @param string $date_
     * @return string
     */
    public function getDiferenceHours(string $date, string $date_)
    {
        $toDate = Carbon::parse($date);
        $fromDate = Carbon::parse($date_);
        return $toDate->diffInHours($fromDate);
    }

    /**
     * @param string $date
     * @param string $date_
     * @return string
     */
    public function getDiferenceMinutes(string $date, string $date_)
    {
        $toDate = Carbon::parse($date);
        $fromDate = Carbon::parse($date_);
        return $toDate->diffInMinutes($fromDate);
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return date($this->translate->getDayPhp());
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return date($this->translate->getMonthPhp());
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return date($this->translate->getYearPhp());
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return date($this->translate->getDatePhp());
    }

    /**
     * @return string
     */
    public function getFullDate()
    {
        return date($this->translate->getZoneFull());
    }

    /**
     * @param string $date_time
     * @param string $date
     * @return string
     */
    public function addDateToDate(string $date_time, string $date)
    {
        return date($this->translate->getZoneFull(), strtotime($date_time . $date));
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return date($this->translate->getTimePhp());
    }

    /**
     * @return string
     */
    public function getFullTime()
    {
        return date($this->translate->getDateTimePhp());
    }
}

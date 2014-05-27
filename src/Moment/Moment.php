<?php

/**
 * Wrapper for PHP's DateTime class inspired by moment.js
 *
 * @author  Tino Ehrich <ehrich@efides.com>
 * @version See composer.json
 *
 * @dependencies  >= PHP 5.3.0
 */

namespace Moment;

class Moment extends \DateTime
{
    /** @var string */
    protected $_rawDateTimeString;

    /** @var string */
    protected $_timezoneString;

    // ##########################################

    /**
     * @param string $dateTime
     * @param string $timezone
     */
    public function __construct($dateTime = 'now', $timezone = 'UTC')
    {
        return $this->resetDateTime($dateTime, $timezone);
    }

    // ##########################################

    /**
     * @param string $dateTime
     * @param string $timezone
     *
     * @return $this
     * @throws MomentException
     */
    public function resetDateTime($dateTime = 'now', $timezone = 'UTC')
    {
        // cache dateTime
        $this->_setRawDateTimeString($dateTime);

        // cache timezone string
        $this->_setTimezoneString($timezone);

        // create instance
        parent::__construct($dateTime, $this->_getDateTimeZone($timezone));

        // date validation
        if ($this->_isValidDate() === false)
        {
            throw new MomentException('Given date of "' . $dateTime . '" is invalid');
        }

        return $this;
    }

    // ##########################################

    /**
     * @param string $rawDateTimeString
     *
     * @return Moment
     */
    protected function _setRawDateTimeString($rawDateTimeString)
    {
        $this->_rawDateTimeString = $rawDateTimeString;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getRawDateTimeString()
    {
        return $this->_rawDateTimeString;
    }

    // ##########################################

    /**
     * @param string $timezoneString
     *
     * @return Moment
     */
    protected function _setTimezoneString($timezoneString)
    {
        $this->_timezoneString = $timezoneString;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getTimezoneString()
    {
        return $this->_timezoneString;
    }

    // ##########################################

    /**
     * @param string $timezone
     *
     * @return \DateTimeZone
     */
    protected function _getDateTimeZone($timezone)
    {
        return new \DateTimeZone($timezone);
    }

    // ##########################################

    /**
     * @param string $timezone
     *
     * @return \DateTime|Moment
     */
    public function setTimezone($timezone)
    {
        $this->_setTimezoneString($timezone);

        parent::setTimezone($this->_getDateTimeZone($timezone));

        return $this;
    }

    // ##########################################

    /**
     * @param null $format
     * @param null|FormatsInterface $formatsInterface
     *
     * @return string
     */
    public function format($format = null, $formatsInterface = null)
    {
        // set default format
        if ($format === null)
        {
            $format = \DateTime::ISO8601;
        }

        // handle diverse format types
        if ($formatsInterface instanceof FormatsInterface)
        {
            $format = $formatsInterface->format($format);
        }

        return parent::format($format);
    }

    // ############################################

    /**
     * @deprecated
     *
     * @param string $type
     * @param int $value
     *
     * @return Moment
     */
    public function add($type = 'day', $value = 1)
    {
        parent::modify('+' . $value . ' ' . $type);

        return $this;
    }

    // ############################################

    /**
     * @param int $seconds
     *
     * @return Moment
     */
    public function addSeconds($seconds = 1)
    {
        return $this->add('second', $seconds);
    }

    // ############################################

    /**
     * @param int $minutes
     *
     * @return Moment
     */
    public function addMinutes($minutes = 1)
    {
        return $this->add('minute', $minutes);
    }

    // ############################################

    /**
     * @param int $hours
     *
     * @return Moment
     */
    public function addHours($hours = 1)
    {
        return $this->add('hour', $hours);
    }

    // ############################################

    /**
     * @param int $days
     *
     * @return Moment
     */
    public function addDays($days = 1)
    {
        return $this->add('day', $days);
    }

    // ############################################

    /**
     * @param int $weeks
     *
     * @return Moment
     */
    public function addWeeks($weeks = 1)
    {
        return $this->add('week', $weeks);
    }

    // ############################################

    /**
     * @param int $months
     *
     * @return Moment
     */
    public function addMonths($months = 1)
    {
        return $this->add('month', $months);
    }

    // ############################################

    /**
     * @param int $years
     *
     * @return Moment
     */
    public function addYears($years = 1)
    {
        return $this->add('year', $years);
    }

    // ############################################

    /**
     * @deprecated
     *
     * @param string $type
     * @param int $value
     *
     * @return Moment
     */
    public function subtract($type = 'day', $value = 1)
    {
        parent::modify('-' . $value . ' ' . $type);

        return $this;
    }

    // ############################################

    /**
     * @param int $seconds
     *
     * @return Moment
     */
    public function subtractSeconds($seconds = 1)
    {
        return $this->subtract('second', $seconds);
    }

    // ############################################

    /**
     * @param int $minutes
     *
     * @return Moment
     */
    public function subtractMinutes($minutes = 1)
    {
        return $this->subtract('minute', $minutes);
    }

    // ############################################

    /**
     * @param int $hours
     *
     * @return Moment
     */
    public function subtractHours($hours = 1)
    {
        return $this->subtract('hour', $hours);
    }

    // ############################################

    /**
     * @param int $days
     *
     * @return Moment
     */
    public function subtractDays($days = 1)
    {
        return $this->subtract('day', $days);
    }

    // ############################################

    /**
     * @param int $weeks
     *
     * @return Moment
     */
    public function subtractWeeks($weeks = 1)
    {
        return $this->subtract('week', $weeks);
    }

    // ############################################

    /**
     * @param int $months
     *
     * @return Moment
     */
    public function subtractMonths($months = 1)
    {
        return $this->subtract('month', $months);
    }

    // ############################################

    /**
     * @param int $years
     *
     * @return Moment
     */
    public function subtractYears($years = 1)
    {
        return $this->subtract('year', $years);
    }

    // ######################################

    /**
     * @param string $dateTime
     * @param string $timezone
     *
     * @return MomentFromVo
     */
    public function from($dateTime = 'now', $timezone = 'UTC')
    {
        $fromMoment = new Moment($dateTime, $timezone);
        $dateDiff = parent::diff($fromMoment);

        $momentFromVo = new MomentFromVo();

        return $momentFromVo
            ->setMoment($fromMoment)
            ->setDirection($dateDiff->format('%R'))
            ->setSeconds($this->_fromToSeconds($dateDiff))
            ->setMinutes($this->_fromToMinutes($dateDiff))
            ->setHours($this->_fromToHours($dateDiff))
            ->setDays($this->_fromToDays($dateDiff))
            ->setWeeks($this->_fromToWeeks($dateDiff));
    }

    // ######################################

    /**
     * @param string $timezone
     *
     * @return MomentFromVo
     */
    public function fromNow($timezone = 'UTC')
    {
        return $this->from('now', $timezone);
    }

    // ######################################

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function _fromToSeconds(\DateInterval $dateInterval)
    {
        return ($dateInterval->y * 365 * 24 * 60 * 60) + ($dateInterval->m * 30 * 24 * 60 * 60) + ($dateInterval->d * 24 * 60 * 60) + ($dateInterval->h * 60 * 60) + $dateInterval->s;
    }

    // ######################################

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function _fromToMinutes(\DateInterval $dateInterval)
    {
        return $this->_fromToSeconds($dateInterval) / 60;
    }

    // ######################################

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function _fromToHours(\DateInterval $dateInterval)
    {
        return $this->_fromToMinutes($dateInterval) / 60;
    }

    // ######################################

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function _fromToDays(\DateInterval $dateInterval)
    {
        return $this->_fromToHours($dateInterval) / 24;
    }

    // ######################################

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function _fromToWeeks(\DateInterval $dateInterval)
    {
        return $this->_fromToDays($dateInterval) / 7;
    }

    // ######################################

    /**
     * @param int $hour
     * @param int $minute
     * @param null $second
     *
     * @return $this|\DateTime
     */
    public function setTime($hour, $minute, $second = null)
    {
        parent::setTime($hour, $minute, $second);

        return $this;
    }

    // ######################################

    /**
     * @param $period
     *
     * @return MomentPeriodVo
     * @throws MomentException
     */
    public function getPeriod($period)
    {
        switch ($period)
        {
            case 'week':
                $currentWeekDay = $this->format('N');

                $start = new Moment('@' . $this->format('U'));
                $start->setTimezone($this->_getTimezoneString())
                    ->subtractDays($currentWeekDay - 1)
                    ->setTime(0, 0, 0);

                $end = new Moment('@' . $this->format('U'));
                $end->setTimezone($this->_getTimezoneString())
                    ->addDays(7 - $currentWeekDay)
                    ->setTime(23, 59, 59);

                break;

            // ------------------------------

            case 'month':
                $maxMonthDays = $this->format('t');
                $currentMonthDay = $this->format('j');

                $start = new Moment('@' . $this->format('U'));
                $start->setTimezone($this->_getTimezoneString())
                    ->subtractDays($currentMonthDay - 1)
                    ->setTime(0, 0, 0);

                $end = new Moment('@' . $this->format('U'));
                $end->setTimezone($this->_getTimezoneString())
                    ->addDays($maxMonthDays - $currentMonthDay)
                    ->setTime(23, 59, 59);

                break;

            // ------------------------------

            default:
                throw new MomentException("Period \"{$period}\" is not supported yet (supported are \"week\" and \"month\").", 500);
        }

        $momentPeriodVo = new MomentPeriodVo();

        return $momentPeriodVo
            ->setRefDate($this)
            ->setStartDate($start)
            ->setEndDate($end);
    }

    // ######################################

    /**
     * @return string
     */
    public function calendar()
    {
        $momentFromVo = $this->fromNow($this->_getTimezoneString());
        $diff = floor($momentFromVo->getDays());

        if ($diff > 6)
        {
            $format = 'm/d/Y';
        }
        elseif ($diff > 1)
        {
            $format = '\L\a\s\t l \a\t H:i';
        }
        elseif ($diff > 0)
        {
            $format = '\Y\e\s\t\e\r\d\a\y \a\t H:i';
        }
        elseif ($diff == 0)
        {
            $format = '\T\o\d\a\y \a\t H:i';
        }
        elseif ($diff >= -1)
        {
            $format = '\T\o\m\o\r\r\o\w \a\t H:i';
        }
        elseif ($diff > -7)
        {
            $format = 'l \a\t H:i';
        }
        else
        {
            $format = 'm/d/Y';
        }

        return $this->format($format);
    }

    // ######################################

    /**
     * @return bool
     */
    protected function _isValidDate()
    {
        $rawDateTime = $this->_getRawDateTimeString();

        if (strpos($rawDateTime, '-') === false)
        {
            return true;
        }

        // ----------------------------------

        // time with indicator "T"
        if (strpos($rawDateTime, 'T') !== false)
        {
            $momentDateTime = $this->format('Y-m-d\TH:i:s');
        }

        // time without indicator "T"
        elseif (strpos($rawDateTime, ':') !== false)
        {
            if (substr_count($rawDateTime, ':') === 2) // with seconds
            {
                $momentDateTime = $this->format('Y-m-d H:i:s');
            }

            else
            {
                $momentDateTime = $this->format('Y-m-d H:i');
            }
        }

        // without time
        else
        {
            $momentDateTime = $this->format('Y-m-d');
        }

        return $rawDateTime === $momentDateTime;
    }

    // ######################################

    /**
     * @param $period
     *
     * @return $this
     */
    public function startOf($period)
    {
        switch ($period)
        {
            // same as moment().milliseconds(0);
            case 'second':
                return $this->setTime($this->format('H'), $this->format('i'), 0);
                break;

            // set to now, but with 0 seconds and 0 milliseconds
            case 'minute':
                return $this->setTime($this->format('H'), $this->format('i'), 0);
                break;

            // set to now, but with 0 mins, 0 secs, and 0 ms
            case 'hour':
                return $this->setTime($this->format('H'), 0, 0);
                break;

            // set to 12:00 am today
            case 'day':
                return $this->setTime(0, 0, 0);
                break;

            // set to the first day of this week according to ISO 8601, 12:00 am
            case 'isoWeek':
                return $this->getPeriod('week')->getStartDate();
                break;

            // set to the first day of this week, 12:00 am
            case 'week':
                return $this->getPeriod('week')->getStartDate();
                break;

            // set to the beginning of the current quarter, 1st day of months, 12:00 am
            case 'quarter':
                return $this;
                break;

            // set to the first of this month, 12:00 am
            case 'month':
                return $this->getPeriod('month')->getStartDate();
                break;

            // set to January 1st, 12:00 am this year
            case 'year':
                return $this->setDate($this->format('Y'), 1, 1)->setTime(0, 0, 0);
                break;

            default:
                return $this;
        }
    }

    // ######################################

    /**
     * @param $period
     *
     * @return $this
     */
    public function endOf($period)
    {
        switch ($period)
        {
            // same as moment().milliseconds(0);
            case 'second':
                return $this->setTime($this->format('H'), $this->format('i'), 59);
                break;

            // set to now, but with 59 seconds and 59 milliseconds
            case 'minute':
                return $this->setTime($this->format('H'), $this->format('i'), 59);
                break;

            // set to now, but with 59 mins, 59 secs, and 59 ms
            case 'hour':
                return $this->setTime($this->format('H'), 59, 59);
                break;

            // set to 23:59 am today
            case 'day':
                return $this->setTime(23, 59, 59);
                break;

            // set to the last day of this week according to ISO 8601, 12:00 am
            case 'isoWeek':
                return $this->getPeriod('week')->getEndDate();
                break;

            // set to the last day of this week, 12:00 am
            case 'week':
                return $this->getPeriod('week')->getEndDate();
                break;

            // set to the end of the current quarter, last day of months, 12:00 am
            case 'quarter':
                return $this;
                break;

            // set to the last of this month, 12:00 am
            case 'month':
                return $this->getPeriod('month')->getEndDate();
                break;

            // set to January 1st, 12:00 am this year
            case 'year':
                return $this->setDate($this->format('Y'), 12, 31)->setTime(23, 59, 59);
                break;

            default:
                return $this;
        }
    }
}

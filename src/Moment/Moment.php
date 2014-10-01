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
    protected $rawDateTimeString;

    /** @var string */
    protected $timezoneString;

    /**
     * @param string $dateTime
     * @param string $timezone
     *
     * @throws MomentException
     */
    public function __construct($dateTime = 'now', $timezone = 'UTC')
    {
        return $this->resetDateTime($dateTime, $timezone);
    }

    /**
     * @param string $dateTime
     * @param string $timezoneString
     *
     * @return $this
     * @throws MomentException
     */
    public function resetDateTime($dateTime = 'now', $timezoneString = 'UTC')
    {
        // cache dateTime
        $this->setRawDateTimeString($dateTime);

        // create instance
        parent::__construct($dateTime, $this->getDateTimeZone($timezoneString));

        // set timezone if unix time
        if (strpos($dateTime, '@') !== false)
        {
            $this->setTimezone($timezoneString);
        }

        // date validation
        if ($this->isValidDate() === false)
        {
            throw new MomentException('Given date of "' . $dateTime . '" is invalid');
        }

        return $this;
    }

    /**
     * @param string $rawDateTimeString
     *
     * @return Moment
     */
    protected function setRawDateTimeString($rawDateTimeString)
    {
        $this->rawDateTimeString = $rawDateTimeString;

        return $this;
    }

    /**
     * @return string
     */
    protected function getRawDateTimeString()
    {
        return $this->rawDateTimeString;
    }

    /**
     * @param string $timezoneString
     *
     * @return Moment
     */
    protected function setTimezoneString($timezoneString)
    {
        $this->timezoneString = $timezoneString;

        return $this;
    }

    /**
     * @return string
     */
    protected function getTimezoneString()
    {
        return $this->timezoneString;
    }

    /**
     * @param string $timezoneString
     *
     * @return \DateTimeZone
     */
    protected function getDateTimeZone($timezoneString)
    {
        // cache timezone
        $this->setTimezoneString($timezoneString);

        return new \DateTimeZone($timezoneString);
    }

    /**
     * @param string $timezone
     *
     * @return \DateTime|Moment
     */
    public function setTimezone($timezone)
    {
        $this->setTimezoneString($timezone);

        parent::setTimezone($this->getDateTimeZone($timezone));

        return $this;
    }

    /**
     * @param $number
     *
     * @return string
     */
    protected function formatOrdinal($number)
    {
        $ends = array('[th]', '[st]', '[nd]', '[rd]', '[th]', '[th]', '[th]', '[th]', '[th]', '[th]');
        $mod100 = $number % 100;

        return $number . ($mod100 >= 11 && $mod100 <= 13 ? '[th]' : $ends[$number % 10]);
    }

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

        // handle ordinals
        if (strpos($format, 'S') !== false)
        {
            preg_match_all('/(\wS)/', $format, $matches);

            if (count($matches) >= 1)
            {
                foreach ($matches[1] as $part)
                {
                    $number = $this->format(substr($part, 0, 1));
                    $format = str_replace($part, $this->formatOrdinal($number), $format);
                }
            }
        }

        // handle text
        if (strpos($format, '[') !== false)
        {
            preg_match_all('/(\[[^\[]*\])/', $format, $matches);

            foreach ($matches[1] as $part)
            {
                // split string to add \ in front of each character (required for PHP escaping)
                $result = str_split(trim($part, "[]"));

                // join string will \ in front of each character + add back to format
                $format = str_replace($part, "\\" . implode("\\", $result), $format);
            }
        }

        return parent::format($format);
    }

    /**
     * @param string $type
     * @param int $value
     *
     * @return Moment
     */
    protected function addTime($type = 'day', $value = 1)
    {
        parent::modify('+' . $value . ' ' . $type);

        return $this;
    }

    /**
     * @param int $seconds
     *
     * @return Moment
     */
    public function addSeconds($seconds = 1)
    {
        return $this->addTime('second', $seconds);
    }

    /**
     * @param int $minutes
     *
     * @return Moment
     */
    public function addMinutes($minutes = 1)
    {
        return $this->addTime('minute', $minutes);
    }

    /**
     * @param int $hours
     *
     * @return Moment
     */
    public function addHours($hours = 1)
    {
        return $this->addTime('hour', $hours);
    }

    /**
     * @param int $days
     *
     * @return Moment
     */
    public function addDays($days = 1)
    {
        return $this->addTime('day', $days);
    }

    /**
     * @param int $weeks
     *
     * @return Moment
     */
    public function addWeeks($weeks = 1)
    {
        return $this->addTime('week', $weeks);
    }

    /**
     * @param int $months
     *
     * @return Moment
     */
    public function addMonths($months = 1)
    {
        return $this->addTime('month', $months);
    }

    /**
     * @param int $years
     *
     * @return Moment
     */
    public function addYears($years = 1)
    {
        return $this->addTime('year', $years);
    }

    /**
     * @param string $type
     * @param int $value
     *
     * @return Moment
     */
    protected function subtractTime($type = 'day', $value = 1)
    {
        parent::modify('-' . $value . ' ' . $type);

        return $this;
    }

    /**
     * @param int $seconds
     *
     * @return Moment
     */
    public function subtractSeconds($seconds = 1)
    {
        return $this->subtractTime('second', $seconds);
    }

    /**
     * @param int $minutes
     *
     * @return Moment
     */
    public function subtractMinutes($minutes = 1)
    {
        return $this->subtractTime('minute', $minutes);
    }

    /**
     * @param int $hours
     *
     * @return Moment
     */
    public function subtractHours($hours = 1)
    {
        return $this->subtractTime('hour', $hours);
    }

    /**
     * @param int $days
     *
     * @return Moment
     */
    public function subtractDays($days = 1)
    {
        return $this->subtractTime('day', $days);
    }

    /**
     * @param int $weeks
     *
     * @return Moment
     */
    public function subtractWeeks($weeks = 1)
    {
        return $this->subtractTime('week', $weeks);
    }

    /**
     * @param int $months
     *
     * @return Moment
     */
    public function subtractMonths($months = 1)
    {
        return $this->subtractTime('month', $months);
    }

    /**
     * @param int $years
     *
     * @return Moment
     */
    public function subtractYears($years = 1)
    {
        return $this->subtractTime('year', $years);
    }

    /**
     * @param $day
     *
     * @return Moment
     */
    public function setDay($day)
    {
        $this->setDate(
            $this->format('Y'),
            $this->format('m'),
            $day
        );

        return $this;
    }

    /**
     * @param $month
     *
     * @return Moment
     */
    public function setMonth($month)
    {
        $this->setDate(
            $this->format('Y'),
            $month,
            $this->format('d')
        );

        return $this;
    }

    /**
     * @param $year
     *
     * @return Moment
     */
    public function setYear($year)
    {
        $this->setDate(
            $year,
            $this->format('m'),
            $this->format('d')
        );

        return $this;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return (int)$this->format('d');
    }

    /**
     * @return int
     */
    public function getWeekday()
    {
        return (int)$this->format('N');
    }

    /**
     * @return int
     */
    public function getWeekOfYear()
    {
        return (int)$this->format('W');
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return (int)$this->format('m');
    }

    /**
     * @return int
     */
    public function getQuarter()
    {
        $currentMonth = $this->format('n');

        return (int)ceil($currentMonth / 3);
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return (int)$this->format('Y');
    }

    /**
     * @param $second
     *
     * @return Moment
     */
    public function setSecond($second)
    {
        $this->setTime(
            $this->format('H'),
            $this->format('i'),
            $second
        );

        return $this;
    }

    /**
     * @param $minute
     *
     * @return Moment
     */
    public function setMinute($minute)
    {
        $this->setTime(
            $this->format('H'),
            $minute,
            $this->format('s')
        );

        return $this;
    }

    /**
     * @param $hour
     *
     * @return Moment
     */
    public function setHour($hour)
    {
        $this->setTime(
            $hour,
            $this->format('i'),
            $this->format('s')
        );

        return $this;
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return (int)$this->format('s');
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return (int)$this->format('i');
    }

    /**
     * @return int
     */
    public function getHour()
    {
        return (int)$this->format('H');
    }

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

    /**
     * @param string $dateTime
     * @param null $timezoneString
     *
     * @return MomentFromVo
     */
    public function from($dateTime = 'now', $timezoneString = null)
    {
        // use custom timezone or fallback the current moment
        $useTimezoneString = $timezoneString !== null ? $timezoneString : $this->getTimezoneString();

        $fromMoment = new Moment($dateTime, $useTimezoneString);
        $dateDiff = parent::diff($fromMoment);

        $momentFromVo = new MomentFromVo();

        return $momentFromVo
            ->setMoment($fromMoment)
            ->setDirection($dateDiff->format('%R'))
            ->setSeconds($this->fromToSeconds($dateDiff))
            ->setMinutes($this->fromToMinutes($dateDiff))
            ->setHours($this->fromToHours($dateDiff))
            ->setDays($this->fromToDays($dateDiff))
            ->setWeeks($this->fromToWeeks($dateDiff));
    }

    /**
     * @param null $timezoneString
     *
     * @return MomentFromVo
     */
    public function fromNow($timezoneString = null)
    {
        // use custom timezone or fallback the current moment
        $useTimezoneString = $timezoneString !== null ? $timezoneString : $this->getTimezoneString();

        return $this->from('now', $useTimezoneString);
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function fromToSeconds(\DateInterval $dateInterval)
    {
        return ($dateInterval->y * 365 * 24 * 60 * 60) + ($dateInterval->m * 30 * 24 * 60 * 60) + ($dateInterval->d * 24 * 60 * 60) + ($dateInterval->h * 60 * 60) + $dateInterval->s;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function fromToMinutes(\DateInterval $dateInterval)
    {
        return $this->fromToSeconds($dateInterval) / 60;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function fromToHours(\DateInterval $dateInterval)
    {
        return $this->fromToMinutes($dateInterval) / 60;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function fromToDays(\DateInterval $dateInterval)
    {
        return $this->fromToHours($dateInterval) / 24;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    protected function fromToWeeks(\DateInterval $dateInterval)
    {
        return $this->fromToDays($dateInterval) / 7;
    }

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
                $interval = $this->format('W');

                $start = new Moment('@' . $this->format('U'));
                $start->setTimezone($this->getTimezoneString())
                    ->subtractDays($currentWeekDay - 1)
                    ->setTime(0, 0, 0);

                $end = new Moment('@' . $this->format('U'));
                $end->setTimezone($this->getTimezoneString())
                    ->addDays(7 - $currentWeekDay)
                    ->setTime(23, 59, 59);

                break;

            // ------------------------------

            case 'month':
                $maxMonthDays = $this->format('t');
                $currentMonthDay = $this->format('j');
                $interval = $this->getMonth();

                $start = new Moment('@' . $this->format('U'));
                $start->setTimezone($this->getTimezoneString())
                    ->subtractDays($currentMonthDay - 1)
                    ->setTime(0, 0, 0);

                $end = new Moment('@' . $this->format('U'));
                $end->setTimezone($this->getTimezoneString())
                    ->addDays($maxMonthDays - $currentMonthDay)
                    ->setTime(23, 59, 59);

                break;

            // ------------------------------

            case 'quarter':
                $quarter = $this->getQuarter();
                $momentPeriodVo = MomentHelper::getQuarterPeriod($quarter, $this->getYear(), $this->getTimezoneString());
                $start = $momentPeriodVo->getStartDate();
                $end = $momentPeriodVo->getEndDate();
                $interval = $quarter;
                break;

            // ------------------------------

            default:
                throw new MomentException("Period \"{$period}\" is not supported yet (supported are \"week\" and \"month\").", 500);
        }

        $momentPeriodVo = new MomentPeriodVo();

        return $momentPeriodVo
            ->setRefDate($this)
            ->setInterval($interval)
            ->setStartDate($start)
            ->setEndDate($end);
    }

    /**
     * @param bool $withTime
     *
     * @return string
     */
    public function calendar($withTime = true)
    {
        $momentFromVo = $this->fromNow($this->getTimezoneString());
        $diff = floor($momentFromVo->getDays());

        if ($diff > 6)
        {
            $format = 'm/d/Y';
        }
        elseif ($diff > 1)
        {
            $format = '[Last] l' . ($withTime === true ? ' [at] H:i' : null);
        }
        elseif ($diff > 0)
        {
            $format = '[Yesterday]' . ($withTime === true ? ' [at] H:i' : null);
        }
        elseif ($diff == 0)
        {
            $format = '[Today]' . ($withTime === true ? ' [at] H:i' : null);
        }
        elseif ($diff >= -1)
        {
            $format = '[Tomorrow]' . ($withTime === true ? ' [at] H:i' : null);
        }
        elseif ($diff > -7)
        {
            $format = 'l' . ($withTime === true ? ' [at] H:i' : null);
        }
        else
        {
            $format = 'm/d/Y';
        }

        return $this->format($format);
    }

    /**
     * @return bool
     */
    protected function isValidDate()
    {
        $rawDateTime = $this->getRawDateTimeString();

        if (strpos($rawDateTime, '-') === false)
        {
            return true;
        }

        // ----------------------------------

        // time with indicator "T"
        if (strpos($rawDateTime, 'T') !== false)
        {
            $momentDateTime = $this->format('Y-m-d\TH:i:s');
        } // time without indicator "T"
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
        } // without time
        else
        {
            $momentDateTime = $this->format('Y-m-d');
        }

        return $rawDateTime === $momentDateTime;
    }

    /**
     * @param $period
     *
     * @return $this
     */
    public function startOf($period)
    {
        switch ($period)
        {
            // set to now, but with 0 seconds
            case 'minute':
                return $this->setTime($this->getHour(), $this->getMinute(), 0);
                break;

            // set to now, but with 0 mins, 0 secs
            case 'hour':
                return $this->setTime($this->getHour(), 0, 0);
                break;

            // set to 00:00:00 today
            case 'day':
                return $this->setTime(0, 0, 0);
                break;

            // set to the first day of this week, 00:00:00
            case 'week':
                return $this->getPeriod('week')->getStartDate();
                break;

            // set to the beginning of the current quarter, 1st day of months, 00:00:00
            case 'quarter':
                return $this->getPeriod('quarter')->getStartDate();
                break;

            // set to the first of this month, 00:00:00
            case 'month':
                return $this->getPeriod('month')->getStartDate();
                break;

            // set to January 1st, 00:00:00 this year
            case 'year':
                return $this->setDate($this->getYear(), 1, 1)->setTime(0, 0, 0);
                break;

            default:
                return $this;
        }
    }

    /**
     * @param $period
     *
     * @return $this
     */
    public function endOf($period)
    {
        switch ($period)
        {
            // set to now, but with 59 seconds
            case 'minute':
                return $this->setTime($this->getHour(), $this->getMinute(), 59);
                break;

            // set to now, but with 59 mins, 59 secs
            case 'hour':
                return $this->setTime($this->getHour(), 59, 59);
                break;

            // set to 23:59:59 today
            case 'day':
                return $this->setTime(23, 59, 59);
                break;

            // set to the last day of this week, 23:59
            case 'week':
                return $this->getPeriod('week')->getEndDate();
                break;

            // set to the end of the current quarter, last day of months, 23:59:59
            case 'quarter':
                return $this->getPeriod('quarter')->getEndDate();
                break;

            // set to the last of this month, 23:59:59
            case 'month':
                return $this->getPeriod('month')->getEndDate();
                break;

            // set to January 1st, 23:59:59 this year
            case 'year':
                return $this->setDate($this->getYear(), 12, 31)->setTime(23, 59, 59);
                break;

            default:
                return $this;
        }
    }

    /**
     * @return Moment
     */
    public function cloning()
    {
        return clone($this);
    }

    /**
     * @param array $weekdayNumbers
     * @param int $forUpcomingWeeks
     *
     * @return Moment[]
     */
    public function getMomentsByWeekdays(array $weekdayNumbers, $forUpcomingWeeks = 1)
    {
        /** @var Moment[] $moments */
        $dates = array();

        // get today's week day number
        $todayWeekday = $this->getWeekday();

        // generate for upcoming weeks
        for ($w = 1; $w <= $forUpcomingWeeks; $w++)
        {
            for ($d = 1; $d <= 7; $d++)
            {
                if (in_array($d, $weekdayNumbers) && ($w > 1 || $d > $todayWeekday))
                {
                    // calculate add days from today's perspective
                    $addDays = $w === 1 ? $d - $todayWeekday : ($d - $todayWeekday) + ($w * 7 - 7);

                    // set date
                    $dates[] = $this->cloning()->addDays($addDays);
                }
            }
        }

        return $dates;
    }
}
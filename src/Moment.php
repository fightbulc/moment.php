<?php

namespace Moment;

/**
 * Moment
 * Wrapper for PHP's DateTime class inspired by moment.js
 *
 * @package Moment
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class Moment extends \DateTime
{
    const NO_TZ_MYSQL = 'Y-m-d H:i:s';
    const NO_TZ_NO_SECS = 'Y-m-d H:i';
    const NO_TIME = 'Y-m-d';

    /**
     * @var string
     */
    private static $defaultTimezone = 'UTC';

    /**
     * @var string
     */
    private $rawDateTimeString;

    /**
     * @var string
     */
    private $timezoneString;

    /**
     * @var boolean
     */
    private $immutableMode;

    /**
     * @param string $locale
     * @param bool   $findSimilar
     *
     * @throws MomentException
     */
    public static function setLocale($locale, $findSimilar = false)
    {
        // set current language
        MomentLocale::setLocale($locale, $findSimilar);
    }

    /**
     * @param string $timezone
     *
     * @return void
     */
    public static function setDefaultTimezone($timezone)
    {
        // set current language
        self::$defaultTimezone = $timezone;
    }

    /**
     * Creates a new Moment from a DateTime
     *
     * @param \DateTimeInterface $date
     *
     * @return Moment
     * @throws MomentException
     */
    public static function fromDateTime(\DateTimeInterface $date)
    {
        $moment = new static('@' . $date->format('U'));
        $moment->setTimezone($date->getTimezone());

        if ($date instanceof \DateTimeImmutable)
        {
            $moment->setImmutableMode(true);
        }

        return $moment;
    }

    /**
     * Workaround for {@see https://bugs.php.net/bug.php?id=60302} and
     * {@see https://github.com/fightbulc/moment.php/issues/89}
     *
     * @param string                $format format of the date
     * @param string                $time date string to parse
     * @param null|\DateTimeZone    $timezone optional timezone to parse the string with
     * @param null|FormatsInterface $formatsInterface optional interface to use for {@see $format}.
     *
     * @return static
     * @throws MomentException
     */
    public static function createFromFormat($format, $time, $timezone = null, FormatsInterface $formatsInterface = null)
    {
        // handle diverse format types
        if ($formatsInterface instanceof FormatsInterface)
        {
            // merge localized custom formats
            $localeContent = MomentLocale::getLocaleContent();
            if (isset($localeContent['customFormats']) && is_array($localeContent['customFormats']))
            {
                $formatsInterface->setTokens($localeContent['customFormats']);
            }

            $format = $formatsInterface->format($format);
        }

        $date = $timezone ?
            parent::createFromFormat($format, $time, $timezone) :
            parent::createFromFormat($format, $time);

        return static::fromDateTime($date);
    }

    /**
     * @param string      $dateTime
     * @param string|null $timezone
     * @param bool        $immutableMode
     *
     * @throws MomentException
     */
    public function __construct($dateTime = 'now', $timezone = null, $immutableMode = false)
    {
        if ($timezone === null)
        {
            $timezone = self::$defaultTimezone;
        }

        // set moment
        MomentLocale::setMoment($this);

        // load locale content
        MomentLocale::loadLocaleContent();

        // initialize DateTime
        $this->resetDateTime($dateTime, $timezone);

        // set immutable mode
        $this->setImmutableMode($immutableMode);
    }

    /**
     * @param boolean $mode
     *
     * @return self
     */
    public function setImmutableMode($mode)
    {
        // set immutable mode to true or false
        $this->immutableMode = $mode;

        return $this;
    }

    /**
     * @param string $dateTime
     * @param string $timezone
     *
     * @return $this
     * @throws MomentException
     * @throws \Exception
     */
    public function resetDateTime($dateTime = 'now', $timezone = null)
    {
        $lengthDateTime = strlen((int)$dateTime);

        // unix timestamp helper
        if ($lengthDateTime >= 9 && $lengthDateTime <= 10)
        {
            $dateTime = '@' . $dateTime;
        }

        if ($timezone === null)
        {
            $timezone = self::$defaultTimezone;
        }

        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        // cache dateTime
        $this->setRawDateTimeString($dateTime);

        // create instance
        parent::__construct($dateTime, $this->getDateTimeZone($timezone));

        // set timezone if unix time
        if (strpos($dateTime, '@') !== false && $timezone)
        {
            $this->setTimezone($timezone);
        }

        // date validation
        if ($this->isValidDate() === false)
        {
            throw new MomentException('Given date of "' . $dateTime . '" is invalid');
        }

        return $this;
    }

    /**
     * @param string|\DateTimeZone $timezone
     *
     * @return \DateTime|Moment
     */
    public function setTimezone($timezone)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        if ($timezone instanceof \DateTimeZone)
        {
            $timezone = $timezone->getName();
        }

        $this->setTimezoneString($timezone);

        parent::setTimezone($this->getDateTimeZone($timezone));

        return $this;
    }

    /**
     * @param null|string           $format
     * @param null|FormatsInterface $formatsInterface
     *
     * @return string
     * @throws MomentException
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
            // merge localized custom formats
            $localeContent = MomentLocale::getLocaleContent();
            if (isset($localeContent['customFormats']) && is_array($localeContent['customFormats']))
            {
                $formatsInterface->setTokens($localeContent['customFormats']);
            }

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
                    $token = substr($part, 0, 1);
                    $number = $this->format($token);
                    $format = str_replace($part, $this->formatOrdinal($number, $token), $format);
                }
            }
        }

        // handle text
        if (strpos($format, '[') !== false)
        {
            preg_match_all('/\[([^\[]*)\]/', $format, $matches);

            foreach ($matches[1] as $part)
            {
                $format = preg_replace('/\[' . $part . '\]/u', preg_replace('/(\w)/u', '\\\\\1', $part), $format);
            }
        }

        // prepare locale formats
        $format = MomentLocale::prepareSpecialLocaleTags($format);

        // render moment
        $format = parent::format($format);

        // render locale format
        $format = MomentLocale::renderSpecialLocaleTags($format);

        return $format;
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
     * @param int $day
     *
     * @return Moment
     * @throws MomentException
     */
    public function setDay($day)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->setDate($this->format('Y'), $this->format('m'), $day);

        return $this;
    }

    /**
     * @param int $month
     *
     * @return Moment
     * @throws MomentException
     */
    public function setMonth($month)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->setDate($this->format('Y'), $month, $this->format('d'));

        return $this;
    }

    /**
     * @param int $year
     *
     * @return Moment
     * @throws MomentException
     */
    public function setYear($year)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->setDate($year, $this->format('m'), $this->format('d'));

        return $this;
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getDay()
    {
        return (string)$this->format('d');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getWeekday()
    {
        return (string)$this->format('N');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getWeekdayNameLong()
    {
        return (string)$this->format('l');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getWeekdayNameShort()
    {
        return (string)$this->format('D');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getWeekOfYear()
    {
        return (string)$this->format('W');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getMonth()
    {
        return (string)$this->format('m');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getMonthNameLong()
    {
        return (string)$this->format('F');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getMonthNameShort()
    {
        return (string)$this->format('M');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getQuarter()
    {
        $currentMonth = $this->format('n');

        return (string)ceil($currentMonth / 3);
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getYear()
    {
        return (string)$this->format('Y');
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return self|\DateTime
     */
    public function setDate($year, $month, $day)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        parent::setDate($year, $month, $day);

        return $this;
    }

    /**
     * @param int $second
     *
     * @throws MomentException
     * @return Moment
     */
    public function setSecond($second)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->setTime($this->format('H'), $this->format('i'), $second);

        return $this;
    }

    /**
     * @param int $minute
     *
     * @return Moment
     * @throws MomentException
     */
    public function setMinute($minute)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->setTime($this->format('H'), $minute, $this->format('s'));

        return $this;
    }

    /**
     * @param int $hour
     *
     * @return Moment
     * @throws MomentException
     */
    public function setHour($hour)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->setTime($hour, $this->format('i'), $this->format('s'));

        return $this;
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getSecond()
    {
        return (string)$this->format('s');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getMinute()
    {
        return (string)$this->format('i');
    }

    /**
     * @return string
     * @throws MomentException
     */
    public function getHour()
    {
        return (string)$this->format('H');
    }

    /**
     * @param int      $hour
     * @param int      $minute
     * @param int|null $second
     * @param int|null $microseconds
     *
     * @return $this|\DateTime
     */
    public function setTime($hour, $minute, $second = null, $microseconds = null)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        parent::setTime($hour, $minute, $second);

        return $this;
    }

    /**
     * @param string|Moment $fromMoment
     * @param null          $timezoneString
     *
     * @return MomentFromVo
     * @throws MomentException
     */
    public function from($fromMoment = 'now', $timezoneString = null)
    {
        // create moment first
        if ($this->isMoment($fromMoment) === false)
        {
            // use custom timezone or fallback the current moment
            $useTimezoneString = $timezoneString !== null ? $timezoneString : $this->getTimezoneString();
            $fromMoment = new Moment($fromMoment, $useTimezoneString);
        }

        // calc difference between dates
        $dateDiff = parent::diff($fromMoment);
        $momentFromVo = new MomentFromVo($fromMoment);

        return $momentFromVo
            ->setDirection($dateDiff->format('%R'))
            ->setSeconds($this->fromToSeconds($dateDiff))
            ->setMinutes($this->fromToMinutes($dateDiff))
            ->setHours($this->fromToHours($dateDiff))
            ->setDays($this->fromToDays($dateDiff))
            ->setWeeks($this->fromToWeeks($dateDiff))
            ;
    }

    /**
     * @param null $timezoneString
     *
     * @return MomentFromVo
     * @throws MomentException
     */
    public function fromNow($timezoneString = null)
    {
        // use custom timezone or fallback the current moment
        $useTimezoneString = $timezoneString !== null ? $timezoneString : $this->getTimezoneString();

        return $this->from('now', $useTimezoneString);
    }

    /**
     * @param $input
     *
     * @return bool
     */
    public function isMoment($input)
    {
        return $input instanceof Moment;
    }

    /**
     * @param string $type
     * @param int    $value
     *
     * @return Moment
     */
    private function addTime($type = 'day', $value = 1)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        parent::modify('+' . $value . ' ' . $type);

        return $this;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    private function fromToSeconds(\DateInterval $dateInterval)
    {
        return
            ($dateInterval->days * 24 * 60 * 60)
            + ($dateInterval->h * 60 * 60)
            + ($dateInterval->i * 60)
            + $dateInterval->s;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    private function fromToMinutes(\DateInterval $dateInterval)
    {
        return $this->fromToSeconds($dateInterval) / 60;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    private function fromToHours(\DateInterval $dateInterval)
    {
        return $this->fromToMinutes($dateInterval) / 60;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    private function fromToDays(\DateInterval $dateInterval)
    {
        return $this->fromToHours($dateInterval) / 24;
    }

    /**
     * @param \DateInterval $dateInterval
     *
     * @return string
     */
    private function fromToWeeks(\DateInterval $dateInterval)
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
                $interval = $this->format('W');

                $start = new Moment('@' . $this->format('U'));
                $start->setTimezone($this->getTimezoneString())
                      ->subtractDays($this->getDaysAfterStartOfWeek())
                      ->setTime(0, 0, 0)
                ;

                $end = new Moment('@' . $this->format('U'));
                $end->setTimezone($this->getTimezoneString())
                    ->addDays(6 - $this->getDaysAfterStartOfWeek())
                    ->setTime(23, 59, 59)
                ;

                break;

            // ------------------------------

            case 'month':
                $maxMonthDays = $this->format('t');
                $currentMonthDay = $this->format('j');
                $interval = $this->getMonth();

                $start = new Moment('@' . $this->format('U'));
                $start->setTimezone($this->getTimezoneString())
                      ->subtractDays($currentMonthDay - 1)
                      ->setTime(0, 0, 0)
                ;

                $end = new Moment('@' . $this->format('U'));
                $end->setTimezone($this->getTimezoneString())
                    ->addDays($maxMonthDays - $currentMonthDay)
                    ->setTime(23, 59, 59)
                ;

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
                throw new MomentException("Period \"{$period}\" is not supported. Supported: \"week\", \"month\", \"quarter\".");
        }

        $momentPeriodVo = new MomentPeriodVo();

        return $momentPeriodVo
            ->setRefDate($this)
            ->setInterval($interval)
            ->setStartDate($start)
            ->setEndDate($end)
            ;
    }

    /**
     * @param bool        $withTime
     * @param Moment|null $refMoment
     *
     * @return string
     * @throws MomentException
     */
    public function calendar($withTime = true, Moment $refMoment = null)
    {
        $refMoment = $refMoment ? $refMoment : new Moment('now', $this->getTimezoneString());
        $momentFromVo = $this->cloning()->startOf('day')->from($refMoment->startOf('day'));
        $diff = $momentFromVo->getDays();

        // handle time string
        $renderedTimeString = MomentLocale::renderLocaleString(array('calendar', 'withTime'), array($this));
        $addTime = false;

        // apply cases
        if ($diff > 7)
        {
            $localeKeys = array('calendar', 'default');
        }
        elseif ($diff > 1)
        {
            $localeKeys = array('calendar', 'lastWeek');
            $addTime = true;
        }
        elseif ($diff > 0)
        {
            $localeKeys = array('calendar', 'lastDay');
            $addTime = true;
        }
        elseif ($diff == 0)
        {
            $localeKeys = array('calendar', 'sameDay');
            $addTime = true;
        }
        elseif ($diff == -1)
        {
            $localeKeys = array('calendar', 'nextDay');
            $addTime = true;
        }
        elseif ($diff > -7)
        {
            $localeKeys = array('calendar', 'sameElse');
            $addTime = true;
        }
        else
        {
            $localeKeys = array('calendar', 'default');
        }

        // render format
        $format = MomentLocale::renderLocaleString($localeKeys, array($this));

        // add time if valid
        if ($addTime && $withTime === true)
        {
            $format .= ' ' . $renderedTimeString;
        }

        return $this->format($format);
    }

    /**
     * @param string $period
     *
     * @return Moment
     * @throws MomentException
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
                return $this->resetDateTime(
                    $this->getPeriod('week')->getStartDate()->format('c')
                );
                break;

            // set to the beginning of the current quarter, 1st day of months, 00:00:00
            case 'quarter':
                return $this->resetDateTime(
                    $this->getPeriod('quarter')->getStartDate()->format('c')
                );
                break;

            // set to the first of this month, 00:00:00
            case 'month':
                return $this->resetDateTime(
                    $this->getPeriod('month')->getStartDate()->format('c')
                );
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
     * @param string $period
     *
     * @return Moment
     * @throws MomentException
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
                return $this->resetDateTime(
                    $this->getPeriod('week')->getEndDate()->format('c')
                );
                break;

            // set to the end of the current quarter, last day of months, 23:59:59
            case 'quarter':
                return $this->resetDateTime(
                    $this->getPeriod('quarter')->getEndDate()->format('c')
                );
                break;

            // set to the last of this month, 23:59:59
            case 'month':
                return $this->resetDateTime(
                    $this->getPeriod('month')->getEndDate()->format('c')
                );
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
     * @param string $method
     * @param array  $params
     *
     * @return self
     */
    protected function implicitCloning($method, $params = array())
    {
        $clone = $this->cloning();

        $clone->setImmutableMode(false);
        $retval = call_user_func_array(array($clone, $method), $params);
        $clone->setImmutableMode(true);

        return is_null($retval) ? $clone : $retval;
    }

    /**
     * @param array $weekdayNumbers
     * @param int   $forUpcomingWeeks
     *
     * @return Moment[]
     * @throws MomentException
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

    /**
     * Returns copy of Moment normalized to UTC timezone
     *
     * @return Moment
     */
    public function toUTC()
    {
        return $this->cloning()->setTimezone('UTC');
    }

    /**
     * Check if a moment is the same as another moment
     *
     * @param string|Moment $dateTime
     * @param string        $period 'seconds|minute|hour|day|month|year'
     *
     * @return bool
     * @throws MomentException
     */
    public function isSame($dateTime, $period = 'seconds')
    {
        $dateTime = $this->isMoment($dateTime) ? $dateTime : new Moment($dateTime);

        return (bool)($this->toUTC()->startOf($period)->getTimestamp() === $dateTime->toUTC()->startOf($period)->getTimestamp());
    }

    /**
     * Checks if Moment is before given time
     *
     * @param string|Moment $dateTime
     * @param string        $period 'seconds|minute|hour|day|month|year'
     *
     * @return bool
     * @throws MomentException
     */
    public function isBefore($dateTime, $period = 'seconds')
    {
        $dateTime = $this->isMoment($dateTime) ? $dateTime : new Moment($dateTime);

        return (bool)($this->toUTC()->startOf($period)->getTimestamp() < $dateTime->toUTC()->startOf($period)->getTimestamp());
    }

    /**
     * Checks if Moment is after given time
     *
     * @param string|Moment $dateTime
     * @param string        $period 'seconds|minute|hour|day|month|year'
     *
     * @return bool
     * @throws MomentException
     */
    public function isAfter($dateTime, $period = 'seconds')
    {
        $dateTime = $this->isMoment($dateTime) ? $dateTime : new Moment($dateTime);

        return $dateTime->isBefore($this, $period);
    }

    /**
     * Checks if Moment is between given time range
     *
     * @param string|Moment $minDateTime
     * @param string|Moment $maxDateTime
     * @param boolean       $closed
     * @param string        $period 'seconds|minute|hour|day|month|year'
     *
     * @return bool
     * @throws MomentException
     */
    public function isBetween($minDateTime, $maxDateTime, $closed = true, $period = 'seconds')
    {
        $isBefore = $this->isBefore($minDateTime, $period);
        $isAfter = $this->isAfter($maxDateTime, $period);

        // include endpoints
        if ($closed === true)
        {
            return $isBefore === false && $isAfter === false;
        }

        return $isBefore === true && $isAfter === true;
    }

    /**
     * @param string $rawDateTimeString
     *
     * @return Moment
     */
    private function setRawDateTimeString($rawDateTimeString)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->rawDateTimeString = $rawDateTimeString;

        return $this;
    }

    /**
     * @return string
     */
    private function getRawDateTimeString()
    {
        return $this->rawDateTimeString;
    }

    /**
     * @param string $timezoneString
     *
     * @return Moment
     */
    private function setTimezoneString($timezoneString)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        $this->timezoneString = $timezoneString;

        return $this;
    }

    /**
     * @return string
     */
    private function getTimezoneString()
    {
        return $this->timezoneString;
    }

    /**
     * @param string $timezoneString
     *
     * @return \DateTimeZone
     */
    private function getDateTimeZone($timezoneString)
    {
        // cache timezone
        $this->setTimezoneString($timezoneString);

        return new \DateTimeZone($timezoneString);
    }

    /**
     * @return int
     * @throws MomentException
     */
    private function getDaysAfterStartOfWeek()
    {
        $dow = MomentLocale::getLocaleString(array('week', 'dow')) % 7;
        $currentWeekDay = (int)$this->getWeekday();
        $distance = (7 - $dow + $currentWeekDay) % 7;

        return $distance;
    }

    /**
     * @return bool
     * @throws MomentException
     */
    private function isValidDate()
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
            // remove fraction if any
            $rawDateTime = preg_replace('/\.[0-9][0-9][0-9]/', '', $rawDateTime);

            // get timezone if any
            $rawTimeZone = substr($rawDateTime, 19);

            // timezone w/ difference in hours: e.g. +0200
            if (empty($rawTimeZone) === false)
            {
                if (strpos($rawTimeZone, '+') !== false || strpos($rawTimeZone, '-') !== false)
                {
                    // with colon: +-HH:MM
                    if (substr_count($rawTimeZone, ':') > 0)
                    {
                        $momentDateTime = $this->format('Y-m-d\TH:i:sP');
                    }

                    // without colon: +-HHMM
                    else
                    {
                        $momentDateTime = $this->format('Y-m-d\TH:i:sO');
                    }
                }

                // timezone with name: e.g. UTC
                else
                {
                    $momentDateTime = $this->format('Y-m-d\TH:i:se');
                }
            }

            // no timezone specified
            else
            {
                $momentDateTime = $this->format('Y-m-d\TH:i:s');
            }
        }

        // time without indicator "T"
        elseif (strpos($rawDateTime, ':') !== false)
        {
            // with seconds
            if (substr_count($rawDateTime, ':') === 2)
            {
                $momentDateTime = $this->format(self::NO_TZ_MYSQL);
            }
            else
            {
                $momentDateTime = $this->format(self::NO_TZ_NO_SECS);
            }
        }

        // without time
        else
        {
            $momentDateTime = $this->format(self::NO_TIME);
        }

        $isValid = $rawDateTime === $momentDateTime;

        // TODO: hack until we include a proper validation

        if (!$isValid)
        {
            $rfcs = array(
                self::RFC2822,
                self::RFC822,
                self::RFC1036,
            );

            foreach ($rfcs as $rfc)
            {
                if ($this->format($rfc) === $rawDateTime)
                {
                    return true;
                }
            }
        }

        return $isValid;
    }

    /**
     * @param string $type
     * @param int    $value
     *
     * @return Moment
     */
    private function subtractTime($type = 'day', $value = 1)
    {
        if ($this->immutableMode)
        {
            return $this->implicitCloning(__FUNCTION__, func_get_args());
        }

        parent::modify('-' . $value . ' ' . $type);

        return $this;
    }

    /**
     * @param int    $number
     * @param string $token
     *
     * @return string
     * @throws MomentException
     */
    private function formatOrdinal($number, $token)
    {
        return (string)call_user_func(MomentLocale::getLocaleString(array('ordinal')), $number, $token);
    }

}

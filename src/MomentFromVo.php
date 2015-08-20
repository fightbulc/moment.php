<?php

namespace Moment;

/**
 * MomentFromVo
 * @package Moment
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class MomentFromVo
{
    /**
     * @var Moment
     */
    protected $moment;

    /**
     * @var string
     */
    protected $direction;

    /**
     * @var int
     */
    protected $seconds;

    /**
     * @var float
     */
    protected $minutes;

    /**
     * @var float
     */
    protected $hours;

    /**
     * @var float
     */
    protected $days;

    /**
     * @var float
     */
    protected $weeks;

    /**
     * @var string
     */
    protected $relative;

    /**
     * @param Moment $moment
     */
    public function __construct(Moment $moment)
    {
        $this->moment = $moment;
    }

    /**
     * @return Moment
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * @param $value
     *
     * @return float
     */
    protected function getRoundedValue($value)
    {
        $value = round($value, 2);

        if ($this->getDirection() === 'future')
        {
            $value = '-' . $value;
        }

        return (float)$value;
    }

    /**
     * @param string $direction
     *
     * @return MomentFromVo
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction === '-' ? 'future' : 'past';
    }

    /**
     * @param float $days
     *
     * @return MomentFromVo
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * @return float
     */
    public function getDays()
    {
        return $this->getRoundedValue($this->days);
    }

    /**
     * @param float $hours
     *
     * @return MomentFromVo
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * @return float
     */
    public function getHours()
    {
        return $this->getRoundedValue($this->hours);
    }

    /**
     * @param float $minutes
     *
     * @return MomentFromVo
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinutes()
    {
        return $this->getRoundedValue($this->minutes);
    }

    /**
     * @param int $seconds
     *
     * @return MomentFromVo
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return (int)$this->getRoundedValue($this->seconds);
    }

    /**
     * @param mixed $weeks
     *
     * @return MomentFromVo
     */
    public function setWeeks($weeks)
    {
        $this->weeks = $weeks;

        return $this;
    }

    /**
     * @return float
     */
    public function getWeeks()
    {
        return $this->getRoundedValue($this->weeks);
    }

    /**
     * @return float
     */
    public function getMonths()
    {
        return $this->getRoundedValue($this->weeks / 4);
    }

    /**
     * @return float
     */
    public function getYears()
    {
        return $this->getRoundedValue($this->days / 365);
    }

    /**
     * @return string
     */
    public function getRelative()
    {
        $formatArgs = array();

        if ($this->valueInRange($this->getSeconds(), 0, 45))
        {
            $localeKeys = array('relativeTime', 's');
            $formatArgs[] = 1;
        }
        elseif ($this->valueInRange($this->getSeconds(), 45, 90))
        {
            $localeKeys = array('relativeTime', 'm');
            $formatArgs[] = 1;
        }
        elseif ($this->valueInRange($this->getSeconds(), 90, 45 * 60))
        {
            $localeKeys = array('relativeTime', 'mm');
            $formatArgs[] = $this->roundAbs($this->getMinutes());
        }
        elseif ($this->valueInRange($this->getMinutes(), 45, 90))
        {
            $localeKeys = array('relativeTime', 'h');
            $formatArgs[] = 1;
        }
        elseif ($this->valueInRange($this->getMinutes(), 90, 22 * 60))
        {
            $localeKeys = array('relativeTime', 'hh');
            $formatArgs[] = $this->roundAbs($this->getHours());
        }
        elseif ($this->valueInRange($this->getHours(), 22, 36))
        {
            $localeKeys = array('relativeTime', 'd');
            $formatArgs[] = 1;
        }
        elseif ($this->valueInRange($this->getHours(), 36, 25 * 24))
        {
            $localeKeys = array('relativeTime', 'dd');
            $formatArgs[] = $this->roundAbs($this->getDays());
        }
        elseif ($this->valueInRange($this->getDays(), 25, 45))
        {
            $localeKeys = array('relativeTime', 'M');
            $formatArgs[] = 1;
        }
        elseif ($this->valueInRange($this->getDays(), 25, 345))
        {
            $localeKeys = array('relativeTime', 'MM');
            $formatArgs[] = $this->roundAbs($this->getMonths());
        }
        elseif ($this->valueInRange($this->getDays(), 345, 547))
        {
            $localeKeys = array('relativeTime', 'y');
            $formatArgs[] = 1;
        }
        else
        {
            $localeKeys = array('relativeTime', 'yy');
            $formatArgs[] = $this->roundAbs($this->getYears());
        }

        // add to context
        $formatArgs[] = $this->getDirection();
        $formatArgs[] = $this->getMoment();

        // render value
        $time = MomentLocale::renderLocaleString($localeKeys, $formatArgs);

        // render value result by direction string
        return MomentLocale::renderLocaleString(array('relativeTime', $this->getDirection()), array($time));
    }

    /**
     * @param $value
     * @param $from
     * @param $to
     *
     * @return bool
     */
    private function valueInRange($value, $from, $to)
    {
        return abs($value) >= $from && abs($value) <= $to ? true : false;
    }

    /**
     * @param $number
     *
     * @return float
     */
    private function roundAbs($number)
    {
        return round(abs($number));
    }
}
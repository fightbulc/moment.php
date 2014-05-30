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

class MomentFromVo
{
    protected $direction;
    protected $seconds;
    protected $minutes;
    protected $hours;
    protected $days;
    protected $weeks;
    protected $moment;

    /**
     * @return Moment
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * @param Moment $moment
     *
     * @return MomentFromVo
     */
    public function setMoment(Moment $moment)
    {
        $this->moment = $moment;

        return $this;
    }

    /**
     * @param $value
     *
     * @return float
     */
    protected function getRoundedValue($value)
    {
        return round($value, 2);
    }

    /**
     * @param mixed $direction
     *
     * @return MomentFromVo
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param mixed $days
     *
     * @return MomentFromVo
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * @return string
     */
    public function getDays()
    {
        return $this->getDirection() . $this->getRoundedValue($this->days);
    }

    /**
     * @param mixed $hours
     *
     * @return MomentFromVo
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * @return string
     */
    public function getHours()
    {
        return $this->getDirection() . $this->getRoundedValue($this->hours);
    }

    /**
     * @param mixed $minutes
     *
     * @return MomentFromVo
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * @return string
     */
    public function getMinutes()
    {
        return $this->getDirection() . $this->getRoundedValue($this->minutes);
    }

    /**
     * @param mixed $seconds
     *
     * @return MomentFromVo
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeconds()
    {
        return $this->getDirection() . $this->seconds;
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
     * @return string
     */
    public function getWeeks()
    {
        return $this->getDirection() . $this->getRoundedValue($this->weeks);
    }
}
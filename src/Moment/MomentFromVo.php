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
        return (int)$this->seconds;
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
}
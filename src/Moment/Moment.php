<?php

  /**
   * Wrapper for PHP's DateTime class inspired by moment.js
   *
   * @author  Tino Ehrich <ehrich@efides.com>
   * @version 0.1
   *
   * @dependencies  >= PHP 5.3.0
   *
   */
  namespace Moment;

  class Moment extends \DateTime
  {
    /**
     * @param string $dateTime
     * @param string $timezone
     */
    public function __construct($dateTime = 'now', $timezone = 'UTC')
    {
      parent::__construct($dateTime, $this->_getDateTimeZone($timezone));

      return $this;
    }

    // ##########################################

    /**
     * @param $timezone
     * @return \DateTimeZone
     */
    protected function _getDateTimeZone($timezone)
    {
      return new \DateTimeZone($timezone);
    }

    // ##########################################

    /**
     * @param \DateTimeZone $timezone
     * @return \DateTime|Moment
     */
    public function setTimezone($timezone)
    {
      parent::setTimezone($this->_getDateTimeZone($timezone));

      return $this;
    }

    // ##########################################

    /**
     * @param string $dateTime
     * @param string $timezone
     * @return Moment
     */
    public function resetDateTime($dateTime = 'now', $timezone = 'UTC')
    {
      parent::__construct($dateTime, $this->_getDateTimeZone($timezone));

      return $this;
    }

    // ##########################################

    /**
     * @param null $format
     * @return string
     */
    public function format($format = NULL)
    {
      if($format === NULL)
      {
        $format = \DateTime::ISO8601;
      }

      return parent::format($format);
    }

    // ############################################

    /**
     * @param string $type
     * @param int $value
     * @return Moment
     */
    public function add($type = 'day', $value = 1)
    {
      parent::modify('+' . $value . ' ' . $type);

      return $this;
    }

    // ############################################

    /**
     * @param string $type
     * @param int $value
     * @return Moment
     */
    public function subtract($type = 'day', $value = 1)
    {
      parent::modify('-' . $value . ' ' . $type);

      return $this;
    }

    // ############################################

    /**
     * @param string $dateTime
     * @param string $timezone
     * @return array
     */
    public function from($dateTime = 'now', $timezone = 'UTC')
    {
      $fromInstance = parent::diff(new Moment($dateTime, $timezone));

      $direction = $fromInstance->format('%R');

      return array(
        'seconds' => $direction . $this->_fromToSeconds($fromInstance),
        'minutes' => $direction . round($this->_fromToMinutes($fromInstance), 2),
        'hours'   => $direction . round($this->_fromToHours($fromInstance), 2),
        'days'    => $direction . round($this->_fromToDays($fromInstance), 2),
        'weeks'   => $direction . round($this->_fromToWeeks($fromInstance), 2),
      );
    }

    // ############################################

    /**
     * @param string $timezone
     * @return array
     */
    public function fromNow($timezone = 'UTC')
    {
      return $this->from('now', $timezone);
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToSeconds(\DateInterval $dateInterval)
    {
      return ($dateInterval->y * 365 * 24 * 60 * 60) + ($dateInterval->m * 30 * 24 * 60 * 60) + ($dateInterval->d * 24 * 60 * 60) + ($dateInterval->h * 60 * 60) + $dateInterval->s;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToMinutes(\DateInterval $dateInterval)
    {
      return $this->_fromToSeconds($dateInterval) / 60;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToHours(\DateInterval $dateInterval)
    {
      return $this->_fromToMinutes($dateInterval) / 60;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToDays(\DateInterval $dateInterval)
    {
      return $this->_fromToHours($dateInterval) / 24;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToWeeks(\DateInterval $dateInterval)
    {
      return $this->_fromToDays($dateInterval) / 7;
    }
  }
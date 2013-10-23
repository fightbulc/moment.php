<?php

    /**
     * Wrapper for PHP's DateTime class inspired by moment.js
     *
     * @author  Tino Ehrich <ehrich@efides.com>
     * @version 1.1
     *
     * @dependencies  >= PHP 5.3.0
     */

    namespace Moment;

    class Moment extends \DateTime
    {
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
         * @param string $dateTime
         * @param string $timezone
         *
         * @return Moment
         */
        public function resetDateTime($dateTime = 'now', $timezone = 'UTC')
        {
            // cache timezone string
            $this->_setTimezoneString($timezone);

            // create instance
            parent::__construct($dateTime, $this->_getDateTimeZone($timezone));

            return $this;
        }

        // ##########################################

        /**
         * @param null $format
         * @param null|FormatsInterface $formatsInterface
         *
         * @return string
         */
        public function format($format = NULL, $formatsInterface = NULL)
        {
            // set default format
            if ($format === NULL)
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

        // ######################################

        /**
         * @param string $dateTime
         * @param string $timezone
         *
         * @return MomentFromVo
         */
        public function from($dateTime = 'now', $timezone = 'UTC')
        {
            $fromInstance = parent::diff(new Moment($dateTime, $timezone));

            return (new MomentFromVo())
                ->setDirection($fromInstance->format('%R'))
                ->setSeconds($this->_fromToSeconds($fromInstance))
                ->setMinutes($this->_fromToMinutes($fromInstance))
                ->setHours($this->_fromToHours($fromInstance))
                ->setDays($this->_fromToDays($fromInstance))
                ->setWeeks($this->_fromToWeeks($fromInstance));
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
         * @param $period
         *
         * @return MomentPeriodVo
         * @throws \Exception
         */
        public function getPeriod($period)
        {
            switch ($period)
            {
                case 'week':
                    $currentWeekDay = $this->format('N');

                    $start = (new Moment('@' . $this->format('U')))
                        ->setTimezone($this->_getTimezoneString())
                        ->subtract('day', $currentWeekDay - 1)
                        ->setTime(0, 0, 0);

                    $end = (new Moment('@' . $this->format('U')))
                        ->setTimezone($this->_getTimezoneString())
                        ->add('day', 7 - $currentWeekDay)
                        ->setTime(23, 59, 59);

                    break;

                // ------------------------------

                case 'month':
                    $maxMonthDays = $this->format('t');
                    $currentMonthDay = $this->format('j');

                    $start = (new Moment('@' . $this->format('U')))
                        ->setTimezone($this->_getTimezoneString())
                        ->subtract('day', $currentMonthDay - 1)
                        ->setTime(0, 0, 0);

                    $end = (new Moment('@' . $this->format('U')))
                        ->setTimezone($this->_getTimezoneString())
                        ->add('day', $maxMonthDays - $currentMonthDay)
                        ->setTime(23, 59, 59);

                    break;

                // ------------------------------

                default:
                    throw new \Exception("Period \"{$period}\" is not supported yet (supported are \"week\" and \"month\").", 500);
            }

            return (new MomentPeriodVo())
                ->setRefDate($this)
                ->setStartDate($start)
                ->setEndDate($end);
        }
    }

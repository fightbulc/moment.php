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
        protected $_direction;
        protected $_seconds;
        protected $_minutes;
        protected $_hours;
        protected $_days;
        protected $_weeks;
        protected $_moment;

        /**
         * @return Moment
         */
        public function getMoment()
        {
            return $this->_moment;
        }

        // ######################################

        /**
         * @param Moment $moment
         *
         * @return MomentFromVo
         */
        public function setMoment(Moment $moment)
        {
            $this->_moment = $moment;

            return $this;
        }

        // ######################################

        /**
         * @param $value
         *
         * @return float
         */
        protected function _getRoundedValue($value)
        {
            return round($value, 2);
        }

        // ######################################

        /**
         * @param mixed $direction
         *
         * @return MomentFromVo
         */
        public function setDirection($direction)
        {
            $this->_direction = $direction;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getDirection()
        {
            return $this->_direction;
        }

        // ######################################

        /**
         * @param mixed $days
         *
         * @return MomentFromVo
         */
        public function setDays($days)
        {
            $this->_days = $days;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getDays()
        {
            return $this->getDirection() . $this->_getRoundedValue($this->_days);
        }

        // ######################################

        /**
         * @param mixed $hours
         *
         * @return MomentFromVo
         */
        public function setHours($hours)
        {
            $this->_hours = $hours;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getHours()
        {
            return $this->getDirection() . $this->_getRoundedValue($this->_hours);
        }

        // ######################################

        /**
         * @param mixed $minutes
         *
         * @return MomentFromVo
         */
        public function setMinutes($minutes)
        {
            $this->_minutes = $minutes;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getMinutes()
        {
            return $this->getDirection() . $this->_getRoundedValue($this->_minutes);
        }

        // ######################################

        /**
         * @param mixed $seconds
         *
         * @return MomentFromVo
         */
        public function setSeconds($seconds)
        {
            $this->_seconds = $seconds;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getSeconds()
        {
            return $this->getDirection() . $this->_seconds;
        }

        // ######################################

        /**
         * @param mixed $weeks
         *
         * @return MomentFromVo
         */
        public function setWeeks($weeks)
        {
            $this->_weeks = $weeks;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getWeeks()
        {
            return $this->getDirection() . $this->_getRoundedValue($this->_weeks);
        }
    }
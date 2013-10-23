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

    class MomentPeriodVo
    {
        /** @var  Moment */
        protected $_startDate;

        /** @var  Moment */
        protected $_endDate;

        /** @var  Moment */
        protected $_refDate;

        // ######################################

        /**
         * @param Moment $reference
         *
         * @return MomentPeriodVo
         */
        public function setRefDate(Moment $reference)
        {
            $this->_refDate = $reference;

            return $this;
        }

        // ######################################

        /**
         * @return \Moment\Moment
         */
        public function getRefDate()
        {
            return $this->_refDate;
        }

        // ######################################

        /**
         * @param Moment $end
         *
         * @return MomentPeriodVo
         */
        public function setEndDate(Moment $end)
        {
            $this->_endDate = $end;

            return $this;
        }

        // ######################################

        /**
         * @return Moment
         */
        public function getEndDate()
        {
            return $this->_endDate;
        }

        // ######################################

        /**
         * @param Moment $start
         *
         * @return MomentPeriodVo
         */
        public function setStartDate(Moment $start)
        {
            $this->_startDate = $start;

            return $this;
        }

        // ######################################

        /**
         * @return Moment
         */
        public function getStartDate()
        {
            return $this->_startDate;
        }
    }
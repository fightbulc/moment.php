<?php

    namespace Moment;

    class MomentPeriodVo
    {
        /** @var  Moment */
        protected $_start;

        /** @var  Moment */
        protected $_end;

        /** @var  Moment */
        protected $_reference;

        // ######################################

        /**
         * @param Moment $reference
         *
         * @return MomentPeriodVo
         */
        public function setReference(Moment $reference)
        {
            $this->_reference = $reference;

            return $this;
        }

        // ######################################

        /**
         * @return \Moment\Moment
         */
        public function getReference()
        {
            return $this->_reference;
        }

        // ######################################

        /**
         * @param Moment $end
         *
         * @return MomentPeriodVo
         */
        public function setEnd(Moment $end)
        {
            $this->_end = $end;

            return $this;
        }

        // ######################################

        /**
         * @return Moment
         */
        public function getEnd()
        {
            return $this->_end;
        }

        // ######################################

        /**
         * @param Moment $start
         *
         * @return MomentPeriodVo
         */
        public function setStart(Moment $start)
        {
            $this->_start = $start;

            return $this;
        }

        // ######################################

        /**
         * @return Moment
         */
        public function getStart()
        {
            return $this->_start;
        }
    }
<?php

namespace Moment;

/**
 * MomentPeriodVo
 * @package Moment
 * @author Tino Ehrich (tino@bigpun.me)
 */
class MomentPeriodVo
{
    /** @var  Moment */
    protected $startDate;

    /** @var  Moment */
    protected $endDate;

    /** @var  Moment */
    protected $refDate;

    /** @var  int */
    protected $interval;

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     *
     * @return MomentPeriodVo
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @param Moment $reference
     *
     * @return MomentPeriodVo
     */
    public function setRefDate(Moment $reference)
    {
        $this->refDate = $reference;

        return $this;
    }

    /**
     * @return \Moment\Moment
     */
    public function getRefDate()
    {
        return $this->refDate;
    }

    /**
     * @param Moment $end
     *
     * @return MomentPeriodVo
     */
    public function setEndDate(Moment $end)
    {
        $this->endDate = $end;

        return $this;
    }

    /**
     * @return Moment
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param Moment $start
     *
     * @return MomentPeriodVo
     */
    public function setStartDate(Moment $start)
    {
        $this->startDate = $start;

        return $this;
    }

    /**
     * @return Moment
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
}
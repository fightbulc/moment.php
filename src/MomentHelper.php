<?php

namespace Moment;

/**
 * MomentHelper
 * @package Moment
 * @author Tino Ehrich (tino@bigpun.me)
 */
class MomentHelper
{
    /**
     * @param $quarter
     * @param $year
     * @param string $timeZoneString
     *
     * @return MomentPeriodVo
     * @throws MomentException
     */
    public static function getQuarterPeriod($quarter, $year, $timeZoneString = 'UTC')
    {
        switch ($quarter)
        {
            case 1:
                $startMonth = 1;
                $endMonth = 3;
                break;
            case 2:
                $startMonth = 4;
                $endMonth = 6;
                break;
            case 3:
                $startMonth = 7;
                $endMonth = 9;
                break;
            case 4:
                $startMonth = 10;
                $endMonth = 12;
                break;
            default:
                throw new MomentException('Invalid quarter. The range of quarters is 1 - 4. You asked for: ' . $quarter);
        }

        // set start
        $start = new Moment();
        $start
            ->setTimezone($timeZoneString)
            ->setYear($year)
            ->setMonth($startMonth)
            ->setDay(1)
            ->setTime(0, 0, 0);

        // set end
        $end = new Moment();
        $end
            ->setTimezone($timeZoneString)
            ->setYear($year)
            ->setMonth($endMonth)
            ->setDay($end->format('t'))
            ->setTime(23, 59, 59);

        // set period vo
        $momentPeriodVo = new MomentPeriodVo();

        return $momentPeriodVo
            ->setInterval($quarter)
            ->setStartDate($start)
            ->setEndDate($end);
    }
}
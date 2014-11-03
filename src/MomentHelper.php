<?php

namespace Moment;

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

    /**
     * @param string $date
     *
     * @return string
     */
    public static function getTimeZoneFromDate($date)
    {
        $timezone = '+00:00';
        // Split the datetime into individual items
        preg_match( '#([0-9]{4})-?([0-9]{2})-?([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(Z|[\+|\-][0-9]{2}:?[0-9]{2}?){0,1}#', $date, $date_bits);

        if (!empty($date_bits[7]))
        {
            $timezone = $date_bits[7];
        }

        return $timezone;
    }
    
    /**
     * @param string $date
     *
     * @return bool
     */
    public static function isValidISO8601Date($date)
    {
        if (preg_match('/^([\+-]?\d{4}(?!\d{2}\b))((-?)((0[1-9]|1[0-2])(\3([12]\d|0[1-9]|3[01]))?|W([0-4]\d|5[0-2])(-?[1-7])?|(00[1-9]|0[1-9]\d|[12]\d{2}|3([0-5]\d|6[1-6])))([T\s]((([01]\d|2[0-3])((:?)[0-5]\d)?|24\:?00)([\.,]\d+(?!:))?)?(\17[0-5]\d([\.,]\d+)?)?([zZ]|([\+-])([01]\d|2[0-3]):?([0-5]\d)?)?)?)?$/', $date) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $timeZone
     *
     * @return int
     */
    public static function getTimeZoneOffset($timeZone)
    {
        // $timeZone format +05:30 or -01:00 or +2000 or -0830
        $offset = 0;

        if($timeZone == 'Z')
        {
            $offset = 0;
        }
        else
        {
            $sign    = (substr($timeZone, 0, 1) == '+') ? 1 : -1;
            $hours   = intval(substr($timeZone, 1, 2));
            $minutes = intval(substr($timeZone, 3, 4)) / 60;
            $offset  = $sign * 3600 * ($hours + $minutes);
        }

        return (int)$offset;
    }
    
    /**
     * Converts a timezone hourly offset to its timezone's name.
     * @example $offset = -19800, $isDst = 0 <=> return value = 'America/New_York'
     * 
     * @param float $offset The timezone's offset in hours.
     *                      Lowest value: -12 (Pacific/Kwajalein)
     *                      Highest value: 14 (Pacific/Kiritimati)
     * @param bool  $isDst  Is the offset for the timezone when it's in daylight
     *                      savings time?
     * 
     * @return string The name of the timezone: 'Asia/Tokyo', 'Europe/Paris', ...
     */
    public static function getTimeZoneName($offset, $isDst = null)
    {
        if ($isDst === null)
        {
            $isDst = date('I');
        }

        //$offset *= 3600;
        $zone    = timezone_name_from_abbr('', $offset, $isDst);

        if ($zone === false)
        {
            foreach (timezone_abbreviations_list() as $abbr)
            {
                foreach ($abbr as $city)
                {
                    if ((bool)$city['dst'] === (bool)$isDst &&
                        strlen($city['timezone_id']) > 0    &&
                        $city['offset'] == $offset)
                    {
                        $zone = $city['timezone_id'];
                        break;
                    }
                }

                if ($zone !== false)
                {
                    break;
                }
            }
        }
    
        return $zone;
    }
} 
<?php

// locale: Czech (Czech Republic) (cs_CZ)
// author: Jan Ptacek https://github.com/ptica

use Moment\Moment;

/**
 * @param string $direction
 * @param string $trueString
 * @param string $falseString
 *
 * @return string
 */
$ifPast = function ($direction, $trueString, $falseString)
{
    return $direction === 'past' ? $trueString : $falseString;
};

/**
 * @param int    $count
 * @param int    $countSmallerThan
 * @param string $trueString
 * @param string $falseString
 *
 * @return string
 */
$ifCountSmaller = function ($count, $countSmallerThan, $trueString, $falseString)
{
    return $count < $countSmallerThan ? $trueString : $falseString;
};

return array(
    "months"        => explode('_', 'ledna_února_března_dubna_května_června_července_srpna_září_října_listopadu_prosince'),
    "monthsShort"   => explode('_', 'Led_Úno_Bře_Dub_Kvě_Čer_Čvc_Srp_Zář_Říj_Lis_Pro'),
    "weekdays"      => explode('_', 'pondělí_úterý_středa_čtvrtek_pátek_sobota_neděle'),
    "weekdaysShort" => explode('_', 'po_út_st_čt_pá_so_ne'),
    "calendar"      => array(
        "sameDay"  => '[dnes]',
        "nextDay"  => '[zítra]',
        "lastDay"  => '[včera]',
        "lastWeek" => '[minulý] l',
        "sameElse" => 'l',
        "withTime" => '[v] H:i',
        "default"  => 'd.m.Y',
    ),
    "relativeTime"  => array(
        "future" => 'za %s',
        "past"   => 'před %s',
        "s"      => function ($count, $direction, Moment $m) use ($ifPast)
        {
            return $ifPast($direction, 'okamžikem', 'okamžik');
        },
        "ss"      => function ($count, $direction, Moment $m) use ($ifPast)
        {
            return $ifPast($direction, 'okamžikem', 'okamžik');
        },
        "m"      => function ($count, $direction, Moment $m) use ($ifPast)
        {
            return $ifPast($direction, 'minutou', 'minutu');
        },
        "mm"     => function ($count, $direction, Moment $m) use ($ifPast, $ifCountSmaller)
        {
            return $ifPast($direction, '%d minutami', $ifCountSmaller($count, 5, '%d minuty', '%d minut'));
        },
        "h"      => function ($count, $direction, Moment $m) use ($ifPast, $ifCountSmaller)
        {
            return $ifPast($direction, 'hodinou', 'hodinu');
        },
        "hh"     => function ($count, $direction, Moment $m) use ($ifPast, $ifCountSmaller)
        {
            return $ifPast($direction, '%d hodinami', $ifCountSmaller($count, 5, '%d hodiny', '%d hodin'));
        },
        "d"      => function ($count, $direction, Moment $m) use ($ifPast)
        {
            return $ifPast($direction, 'dnem', 'den');
        },
        "dd"     => function ($count, $direction, Moment $m) use ($ifPast, $ifCountSmaller)
        {
            return $ifPast($direction, '%d dny', $ifCountSmaller($count, 5, '%d dny', '%d dnů'));
        },
        "M"      => function ($count, $direction, Moment $m) use ($ifPast)
        {
            return $ifPast($direction, 'měsícem', 'měsíc');
        },
        "MM"     => function ($count, $direction, Moment $m) use ($ifPast, $ifCountSmaller)
        {
            return $ifPast($direction, '%d měsíci', $ifCountSmaller($count, 5, '%d měsíce', '%d měsíců'));
        },
        "y"      => function ($count, $direction, Moment $m) use ($ifPast)
        {
            return $ifPast($direction, 'rokem', 'rok');
        },
        "yy"     => function ($count, $direction, Moment $m) use ($ifPast, $ifCountSmaller)
        {
            return $ifPast($direction, $ifCountSmaller($count, 5, '%d roky', '%d lety'), $ifCountSmaller($count, 5, '%d roky', '%d let'));
        },
    ),
    "ordinal"       => function ($number)
    {
        return $number . '.';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

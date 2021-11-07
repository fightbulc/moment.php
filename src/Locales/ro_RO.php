<?php

// locale: romanian (ro-ro)
// author: Calin Rada https://github.com/calinrada

use Moment\Moment;

$rtwp = function ($count, $direction, Moment $m, $key)
{
    $format = array(
        'mm' => 'minute',
        'hh' => 'ore',
        'dd' => 'zile',
        'MM' => 'luni',
        'yy' => 'ani'
    );

    $separator = ' ';

    if ($count % 100 >= 20 || ($count >= 100 && $count % 100 === 0))
    {
        $separator = ' de ';
    }

    return $count . $separator . $format[$key];
};

return array(
    "months"        => explode('_', 'ianuarie_februarie_martie_aprilie_mai_iunie_iulie_august_septembrie_octombrie_noiembrie_decembrie'),
    "monthsShort"   => explode('_', 'ian._febr._mart._apr._mai_iun._iul._aug._sept._oct._nov._dec.'),
    "weekdays"      => explode('_', 'luni_marți_miercuri_joi_vineri_sâmbătă_duminică'),
    "weekdaysShort" => explode('_', 'Lun_Mar_Mie_Joi_Vin_Sâm_Dum'),
    "calendar"      => array(
        "sameDay"  => '[azi]',
        "nextDay"  => '[mâine la]',
        "lastDay"  => '[ieri la]',
        "lastWeek" => '[fosta] dddd [la]',
        "sameElse" => 'l',
        "withTime" => '[at] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'peste %s',
        "past"   => 'În urmă cu %s',
        "s"      => 'câteva secunde',
        "ss"      => '%d secunde',
        "m"      => 'un minut',
        "mm"     => function ($count, $direction, Moment $m) use ($rtwp)
        {
            return $rtwp($count, $direction, $m, 'mm');
        },
        "h"      => 'o oră',
        "hh"     => function ($count, $direction, Moment $m) use ($rtwp)
        {
            return $rtwp($count, $direction, $m, 'hh');
        },
        "d"      => 'o zi',
        "dd"     => function ($count, $direction, Moment $m) use ($rtwp)
        {
            return $rtwp($count, $direction, $m, 'dd');
        },
        "M"      => 'o lună',
        "MM"     => function ($count, $direction, Moment $m) use ($rtwp)
        {
            return $rtwp($count, $direction, $m, 'MM');
        },
        "y"      => 'un an',
        "yy"     => function ($count, $direction, Moment $m) use ($rtwp)
        {
            return $rtwp($count, $direction, $m, 'yy');
        },
    ),
    "ordinal"       => function ($number)
    {
        return $number;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 7  // The week that contains Jan 7th is the first week of the year.
    ),
    "customFormats" => array(
        "LTS"   => "G:i:s", // 20:30:35
        "LT"   => "G:i", // 20:30
        "L"    => "d/m/Y", // 04/09/1986
        "l"    => "j/n/Y", // 4/9/1986
        "LL"   => "jS F Y", // 4 septembrie 1986
        "ll"   => "j M Y", // 4 Sep 1986
        "LLL"  => "jS F Y G:i", // 4 septembrie 1986 20:30
        "lll"  => "j M Y G:i", // 4 sept. 1986 20:30
        "LLLL" => "l, jS F Y G:i", // Jeudi, 4 Septembre 1986 20:30
        "llll" => "D, j M Y G:i", // Jeu, 4 Sep 1986 20:30
    ),
);

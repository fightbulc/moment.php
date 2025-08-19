<?php

// locale: bulgarian (bg)
// author: JamesAxl https://github.com/jamesaxl

return array(
    "months"        => explode('_', 'януари_февруари_март_април_май_юни_юли_август_септември_октомври_ноември_декември'),
    "monthsShort"   => explode('_', 'яну_фев_мар_апр_май_юни_юли_авг_сеп_окт_ное_дек'),
    "weekdays"      => explode('_', 'понеделник_вторник_сряда_четвъртък_петък_събота_неделя'),
    "weekdaysShort" => explode('_', 'пон_вто_сря_чет_пет_съб_нед'),
    "calendar"      => array(
        "sameDay"  => '[Днес]',
        "nextDay"  => '[Утре]',
        "lastDay"  => '[Вчера]',
        "lastWeek" => 'l',
        "sameElse" => 'l',
        "withTime" => '[в] H:i',
        "default"  => 'd/m/Y',
    ),

    "relativeTime"  => array(
        "future" => 'след %s',
        "past"   => 'преди %s',
        "s"      => 'няколко секунди',
        "ss"     => '%d секунди',
        "m"      => 'минута',
        "mm"     => '%d минути',
        "h"      => 'час',
        "hh"     => '%d часа',
        "d"      => 'ден',
        "dd"     => '%d дена',
        "M"      => 'месец',
        "MM"     => '%d месеца',
        "y"      => 'година',
        "yy"     => '%d години',
    ),

    "ordinal"    => function ($number)
    {
        $lastDigit =  $number % 10;
        $lastTwoDigits = $number % 100;

        if ($number === 0) {
            return $number . '-ев';
        } else if ($lastTwoDigits === 0) {
            return $number . '-ен';
        } else if ($lastTwoDigits > 10 && $lastTwoDigits < 20) {
            return $number . '-ти';
        } else if ($lastDigit === 1) {
            return $number . '-ви';
        } else if ($lastDigit === 2) {
            return $number . '-ри';
        } else if ($lastDigit === 7 || $lastDigit === 8) {
            return $number . '-ми';
        } else {
            return $number . '-ти';
        }
    },
    "week"          => array(
    "dow" => 1, // Monday is the first day of the week.
    "doy" => 7  // The week that contains Jan 7th is the first week of the year
    ),
    "customFormats" => array(
        "LTS"  => "G:i:s",
        "LT"   => "G:i", // 20:30
        "L"    => "d/m/Y", // 04/09/1986
        "l"    => "j/n/Y", // 4/9/1986
        "LL"   => "jS F Y", // 4 Septembre 1986
        "ll"   => "j M Y", // 4 Sep 1986
        "LLL"  => "jS F Y G:i", // 4 Septembre 1986 20:30
        "lll"  => "j M Y G:i", // 4 Sep 1986 20:30
        "LLLL" => "l, jS F Y G:i", // Jeudi, 4 Septembre 1986 20:30
        "llll" => "D, j M Y G:i", // Jeu, 4 Sep 1986 20:30
    ),
);

<?php

// locale: Dutch (Netherlands, The) (nl_NL)
// author: Peter Notenboom https://github.com/peternotenboom

return array(
    "months"        => explode('_', 'januari_februari_maart_april_mei_juni_juli_augustus_september_oktober_november_december'),
    "monthsShort"   => explode('_', 'jan_feb_mrt_apr_mei_jun_jul_aug_sep_okt_nov_dec'),
    "weekdays"      => explode('_', 'maandag_dinsdag_woensdag_donderdag_vrijdag_zaterdag_zondag'),
    "weekdaysShort" => explode('_', 'ma_di_wo_do_vr_za_zo'),
    "calendar"      => array(
        "sameDay"  => '[Vandaag]',
        "nextDay"  => '[Morgen]',
        "lastDay"  => '[Gisteren]',
        "lastWeek" => '[Vorige] l',
        "sameElse" => 'l',
        "withTime" => '[om] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'in %s',
        "past"   => '%s geleden',
        "s"      => 'een paar seconden',
        "ss"      => '%d seconden',
        "m"      => 'een minuut',
        "mm"     => '%d minuten',
        "h"      => 'een uur',
        "hh"     => '%d uren',
        "d"      => 'een dag',
        "dd"     => '%d dagen',
        "M"      => 'een maand',
        "MM"     => '%d maanden',
        "y"      => 'een jaar',
        "yy"     => '%d jaren',
    ),
    "ordinal"       => function ($number)
    {
        return $number; //Possible to add 'e': $m->format('WS'); // 11e. But that also breaks "11e Januari 2015"
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
    "customFormats" => array(
        "LTS"  => "G:i:s", // 20:30:15
        "LT"   => "G:i", // 20:30
        "L"    => "d/m/Y", // 04/09/1986
        "l"    => "j/n/Y", // 4/9/1986
        "LL"   => "jS F Y", // 4 September 1986
        "ll"   => "j M Y", // 4 Sep 1986
        "LLL"  => "jS F Y G:i", // 4 September 1986 20:30
        "lll"  => "j M Y G:i", // 4 Sep 1986 20:30
        "LLLL" => "l jS F Y G:i", // Donderdag 4 September 1986 20:30
        "llll" => "D j M Y G:i", // Do 4 Sep 1986 20:30
    ),

);

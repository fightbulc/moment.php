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
);

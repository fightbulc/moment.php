<?php

// locale: danish (da-dk)
// author: Morten Wulff https://github.com/wulff

return array(
    "months" => explode('_', 'januar_februar_marts_april_maj_juni_juli_august_september_oktober_november_december'),
    "monthsShort" => explode('_', 'jan_feb_mar_apr_maj_jun_jul_aug_sep_okt_nov_dec'),
    "weekdays" => explode('_', 'mandag_tirsdag_onsdag_torsdag_fredag_lørdag_søndag'),
    "weekdaysShort" => explode('_', 'man_tir_ons_tor_fre_lør_søn'),
    "calendar" => array(
        "sameDay" => '[I dag]',
        "nextDay" => '[I morgen]',
        "lastDay" => '[I går]',
        "lastWeek" => '[Sidste] l',
        "sameElse" => 'l',
        "withTime" => '[kl] H:i',
        "default" => 'd/m/Y',
    ),
    "relativeTime" => array(
        "future" => 'om %s',
        "past" => '%s siden',
        "s" => 'få sekunder',
        "ss" => '%d sekunder',
        "m" => 'et minut',
        "mm" => '%d minutter',
        "h" => 'en time',
        "hh" => '%d timer',
        "d" => 'en dag',
        "dd" => '%d dage',
        "M" => 'en måned',
        "MM" => '%d måneder',
        "y" => 'et år',
        "yy" => '%d år',
    ),
    "ordinal" => function ($number) {
        return $number . '.';
    },
    "week" => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

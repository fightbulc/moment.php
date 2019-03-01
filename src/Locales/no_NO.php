<?php

// locale: norweigan (no-NO)

return array(
    "months" => explode('_', 'januar_februar_mars_april_mai_juni_juli_august_september_oktober_november_desember'),
    "monthsShort" => explode('_', 'jan_feb_mars_apr_mai_jun_jul_aug_sep_okt_nov_des'),
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
        "m" => 'ett minutt',
        "mm" => '%d minutter',
        "h" => 'en time',
        "hh" => '%d timer',
        "d" => 'en dag',
        "dd" => '%d dager',
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

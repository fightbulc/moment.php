<?php

// locale: Albanian (sq-AL)
// author: Flakerim Ismani https://github.com/flakerimi

return array(
    "months"        => explode('_', 'Janar_Shkurt_Mars_Prill_Maj_Qershor_Korrik_Gusht_Shtator_Tetor_Nëntor_Dhjetor'),
    "monthsNominative"        => explode('_', 'Janar_Shkurt_Mars_Prill_Maj_Qershor_Korrik_Gusht_Shtator_Tetor_Nëntor_Dhjetor'),
    "monthsShort"   => explode('_', 'Jan_Shk_Mar_Pri_Maj_Qer_Kor_Gush_Sht_Tet_Nën_Dhj'),
    "weekdays"      => explode('_', 'E Hënë_E Marte_E Mërkurë_E Enjte_E Premte_E shtunë_E Diel'),
    "weekdaysShort" => explode('_', 'Hën_Mar_Mër_Enj_Pre_Sht_Die'),
    "calendar"      => array(
        "sameDay"  => '[Sot]',
        "nextDay"  => '[Nesër]',
        "lastDay"  => '[Dje]',
        "lastWeek" => '[e fundit] l',
        "sameElse" => 'l',
        "withTime" => '[në] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'në %s',
        "past"   => '%s më parë',
        "s"      => 'disa sekonda',
        "m"      => 'një minute',
        "mm"     => '%d minuta',
        "h"      => 'një orë',
        "hh"     => '%d orë',
        "d"      => 'një ditë',
        "dd"     => '%d ditë',
        "M"      => 'një muaj',
        "MM"     => '%d muaj',
        "y"      => 'një vit',
        "yy"     => '%d vite',
    ),
    "ordinal"       => function ($number)
    {
        return $number;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

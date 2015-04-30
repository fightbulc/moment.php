<?php

// locale: Czech (Czech Republic) (cs_CZ)
// author: Jan Ptacek https://github.com/ptica

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
    // TODO
    // relative times are different in Czech for past and future ones
    // there is a different grammatical case being used
    // so a Callable would be better here
    "relativeTime"  => array(
        "future" => 'za %s',
        "past"   => 'před %s',
        "s"      => 'okamžikem',
        "m"      => 'minutou',
        "mm"     => '%d minutami',
        "h"      => 'hodinou',
        "hh"     => '%d hodinami',
        "d"      => 'dnem',
        "dd"     => '%d dny',
        "M"      => 'měsícem',
        "MM"     => '%d měsíci',
        "y"      => 'rokem',
        "yy"     => '%d roky',
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

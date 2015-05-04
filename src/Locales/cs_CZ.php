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
        "s" => function ($count, $direction, $m) {
                    if ($direction == 'past')   return 'okamžikem';
                    if ($direction == 'future') return 'okamžik';
                },
        "m" => function ($count, $direction, $m) {
                    if ($direction == 'past')   return 'minutou';
                    if ($direction == 'future') return 'minutu';
                },
        "mm" => function ($count, $direction, $m) {
                    if ($direction == 'past') return '%d minutami';
                    if ($direction == 'future') {
                        if ($count < 5)  return '%d minuty';
                        if ($count >= 5) return '%d minut';
                    }
                },
        "h" => function ($count, $direction, $m) {
                    if ($direction == 'past')   return 'hodinou';
                    if ($direction == 'future') return 'hodinu';
                },
        "hh" => function ($count, $direction, $m) {
                    if ($direction == 'past') return '%d hodinami';
                    if ($direction == 'future') {
                        if ($count < 5)  return '%d hodiny';
                        if ($count >= 5) return '%d hodin';
                    }
                },
        "d" => function ($count, $direction, $m) {
                    if ($direction == 'past')   return 'dnem';
                    if ($direction == 'future') return 'den';
                },
        "dd" => function ($count, $direction, $m) {
                    if ($direction == 'past') return '%d dny';
                    if ($direction == 'future') {
                        if ($count < 5)  return '%d dny';
                        if ($count >= 5) return '%d dnů';
                    }
                },
        "M" => function ($count, $direction, $m) {
                    if ($direction == 'past')   return 'měsícem';
                    if ($direction == 'future') return 'měsíc';
                },
        "MM" => function ($count, $direction, $m) {
                    if ($direction == 'past') return '%d měsíci';
                    if ($direction == 'future') {
                        if ($count < 5)  return '%d měsíce';
                        if ($count >= 5) return '%d měsíců';
                    }
                },
        "y" => function ($count, $direction, $m) {
                    if ($direction == 'past')   return 'rokem';
                    if ($direction == 'future') return 'rok';
                },
        "yy" => function ($count, $direction, $m) {
                    if ($direction == 'past') {
                        if ($count < 5)  return '%d roky';
                        if ($count >= 5) return '%d lety';
                    };
                    if ($direction == 'future') {
                        if ($count < 5)  return '%d roky';
                        if ($count >= 5) return '%d let';
                    }
                },
    ),
    "ordinal" => function ($number) {
        return $number . '.';
    },
    "week"  => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

<?php

// locale: esperanto (eo)
// author: Maxime Valy https://github.com/maximevaly
// Adapted from MomentJS
// https://github.com/moment/moment/blob/develop/src/locale/eo.js

return array(
    "months"        => explode('_', 'januaro_februaro_marto_aprilo_majo_junio_julio_aŭgusto_septembro_oktobro_novembro_decembro'),
    "monthsShort"   => explode('_', 'jan_feb_mart_apr_maj_jun_jul_aŭg_sept_okt_nov_dec'),
    "weekdays"      => explode('_', 'lundo_mardo_merkredo_ĵaŭdo_vendredo_sabato_dimanĉo'),
    "weekdaysShort" => explode('_', 'lun_mard_merk_ĵaŭ_ven_sab_dim'),
    "calendar"      => array(
        "sameDay"  => '[Hodiaŭ]',
        "nextDay"  => '[Morgaŭ]',
        "lastDay"  => '[Hieraŭ]',
        "lastWeek" => '[pasintan] l[n]',
        "sameElse" => 'l',
        "withTime" => '[je] G:i',
        "default"  => 'Y-m-d',
    ),
    "relativeTime"  => array(
        "future" => 'post %s',
        "past"   => 'antaŭ %s',
        "s"      => 'kelkaj sekundoj',
        "ss"      => '%d sekundoj',
        "m"      => 'unu minuto',
        "mm"     => '%d minutoj',
        "h"      => 'unu horo',
        "hh"     => '%d horoj',
        "d"      => 'unu tago',
        "dd"     => '%d tagoj',
        "M"      => 'unu monato',
        "MM"     => '%d monatoj',
        "y"      => 'unu jaro',
        "yy"     => '%d jaroj',
    ),
    "ordinal" => function ($number) {
        return $number . '-a';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4, // The week that contains Jan 4th is the first week of the year.
    ),
    "customFormats" => array(
        "LT" => "G:i",                              // 22:00
        "LTS" => "G:i:s",                           // 22:00:00
        "L" => "Y-m-d",                             // 2010-06-09
        "l"    => "Y-n-j",                          // 2010-6-9
        "LL" => "[la] j[-an de] F, Y",              // la 9-an de junio, 2010
        "ll"   => "j M Y",                          // 9 jun 2010
        "LLL" => "[la] j[-an de] F, Y G:i",         // la 9-an de junio, 2010 22:00
        "lll"  => "j M Y G:i",                      // 9 jun 2010 22:00
        "LLLL" => "l[n], [la] j[-an de] F, Y G:i",  // Merkredon, la 9-an de junio, 2010 22:00
        "llll" => "d, [la] j[-an de] M, Y G:i",     // Merk, 9-an de jun, 2010 22:00
    ),
);

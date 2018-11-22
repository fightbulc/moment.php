<?php

// locale: italia italiano (it_IT)
// author: Marco Micheli https://github.com/macfighterpilot

return array(
    "months"        => explode('_', 'Gennaio_Febbraio_Marzo_Aprile_Maggio_Giugno_Luglio_Agosto_Settembre_Ottobre_Novembre_Dicembre'),
    "monthsShort"   => explode('_', 'Gen_Feb_Mar_Apr_Mag_Giu_Lug_Ago_Set_Ott_Nov_Dic'),
    "weekdays"      => explode('_', 'Lunedì_Martedì_Mercoledì_Giovedì_Venerdì_Sabato_Domenica'),
    "weekdaysShort" => explode('_', 'Lun_Mar_Mer_Gio_Ven_Sab_Dom'),
    "calendar"      => array(
        "sameDay"  => '[Oggi]',
        "nextDay"  => '[Domani]',
        "lastDay"  => '[Ieri]',
        "lastWeek" => '[Scorsa] l',
        "sameElse" => 'l',
        "withTime" => '[alle] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'tra %s',
        "past"   => '%s fa',
        "s"      => 'pochi secondi',
        "m"      => 'un minuto',
        "mm"     => '%d minuti',
        "h"      => 'una ora',
        "hh"     => '%d ore',
        "d"      => 'un giorno',
        "dd"     => '%d giorni',
        "M"      => 'un mese',
        "MM"     => '%d mesi',
        "y"      => 'un anno',
        "yy"     => '%d anni',
    ),
    "ordinal"       => function ($number)
    {
        return $number . '';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4 // The week that contains Jan 4th is the first week of the year.
    ),
);

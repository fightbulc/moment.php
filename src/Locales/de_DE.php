<?php

// locale: German (Germany) (de_DE)
// author: Tino Ehrich (tino@bigpun.me)

return array(
    "months"        => explode('_', 'Januar_Februar_März_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'),
    "monthsShort"   => explode('_', 'Jan_Feb_Mär_Apr_Mai_Jun_Jul_Aug_Sep_Okt_Nov_Dez'),
    "weekdays"      => explode('_', 'Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag_Sonntag'),
    "weekdaysShort" => explode('_', 'Mo_Di_Mi_Do_Fr_Sa_So'),
    "calendar"      => array(
        "sameDay"  => '[Heute]',
        "nextDay"  => '[Morgen]',
        "lastDay"  => '[Gestern]',
        "lastWeek" => '[Letzten] l',
        "sameElse" => 'l',
        "withTime" => '[um] H:i',
        "default"  => 'd.m.Y',
    ),
    "relativeTime"  => array(
        "future" => 'in %s',
        "past"   => 'vor %s',
        "s"      => 'ein paar Sekunden',
        "m"      => 'einer Minute',
        "mm"     => '%d Minuten',
        "h"      => 'einer Stunde',
        "hh"     => '%d Stunden',
        "d"      => 'einem Tag',
        "dd"     => '%d Tagen',
        "M"      => 'einem Monat',
        "MM"     => '%d Monaten',
        "y"      => 'einem Jahr',
        "yy"     => '%d Jahren',
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
<?php

// locale: Swedish (se-SV)
// author: Martin Trobäck https://github.com/lekoaf

return array(
    "months"        => explode('_', 'Januari_Februari_Mars_April_Maj_Juni_Juli_Augusti_September_Oktober_November_December'),
    "monthsShort"   => explode('_', 'Jan_Feb_Mar_Apr_Maj_Jun_Jul_Aug_Sep_Okt_Nov_Dec'),
    "weekdays"      => explode('_', 'Måndag_Tisdag_Onsdag_Torsdag_Fredag_Lördag_Söndag'),
    "weekdaysShort" => explode('_', 'Mån_Tis_Ons_Tor_Fre_Lör_Sön'),
    "calendar"      => array(
        "sameDay"  => '[Idag]',
        "nextDay"  => '[Imorgon]',
        "lastDay"  => '[Igår]',
        "lastWeek" => '[Förra] l',
        "sameElse" => 'l',
        "withTime" => '[kl] H:i',
        "default"  => 'Y/m/d',
    ),
    "relativeTime"  => array(
        "future" => 'om %s',
        "past"   => '%s sen',
        "s"      => 'några sekunder',
        "ss"      => '%d sekunder',
        "m"      => 'en minut',
        "mm"     => '%d minuter',
        "h"      => 'en timme',
        "hh"     => '%d timmar',
        "d"      => 'en dag',
        "dd"     => '%d dagar',
        "M"      => 'en månad',
        "MM"     => '%d månader',
        "y"      => 'ett år',
        "yy"     => '%d år',
    ),
    "ordinal"       => function ($number) {
        return $number;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
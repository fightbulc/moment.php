<?php

// locale: danish (da-dk)
// author: Morten Wulff https://github.com/wulff

return array(
  "months"        => explode('_', 'Januar_Februar_Marts_April_Maj_Juni_Juli_August_September_Oktober_November_December'),
  "monthsShort"   => explode('_', 'Jan_Feb_Mar_Apr_Maj_Jun_Jul_Aug_Sep_Okt_Nov_Dec'),
  "weekdays"      => explode('_', 'Mandag_Tirsdag_Onsdag_Torsdag_Fredag_Lørdag_Søndag'),
  "weekdaysShort" => explode('_', 'Man_Tir_Ons_Tor_Fre_Lør_Søn'),
  "calendar"      => array(
    "sameDay"  => '[I dag]',
    "nextDay"  => '[I morgen]',
    "lastDay"  => '[I går]',
    "lastWeek" => '[Sidste] l',
    "sameElse" => 'l',
    "withTime" => '[kl] H:i',
    "default"  => 'd/m/Y',
  ),
  "relativeTime"  => array(
    "future" => 'om %s',
    "past"   => '%s siden',
    "s"      => 'få sekunder',
    "m"      => 'et minut',
    "mm"     => '%d minutter',
    "h"      => 'en time',
    "hh"     => '%d timer',
    "d"      => 'en dag',
    "dd"     => '%d dage',
    "M"      => 'en måned',
    "MM"     => '%d måneder',
    "y"      => 'et år',
    "yy"     => '%d år',
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

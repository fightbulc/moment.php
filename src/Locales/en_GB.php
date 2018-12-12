<?php

// locale: great britain english (en-gb)
// author: Chris Gedrim https://github.com/chrisgedrim

return array(
    "months"        => explode('_', 'January_February_March_April_May_June_July_August_September_October_November_December'),
    "monthsNominative"        => explode('_', 'January_February_March_April_May_June_July_August_September_October_November_December'),
    "monthsShort"   => explode('_', 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'),
    "weekdays"      => explode('_', 'Monday_Tuesday_Wednesday_Thursday_Friday_Saturday_Sunday'),
    "weekdaysShort" => explode('_', 'Mon_Tue_Wed_Thu_Fri_Sat_Sun'),
    "calendar"      => array(
        "sameDay"  => '[Today]',
        "nextDay"  => '[Tomorrow]',
        "lastDay"  => '[Yesterday]',
        "lastWeek" => '[Last] l',
        "sameElse" => 'l',
        "withTime" => '[at] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'in %s',
        "past"   => '%s ago',
        "s"      => 'a few seconds',
        "ss"      => '%d seconds',
        "m"      => 'a minute',
        "mm"     => '%d minutes',
        "h"      => 'an hour',
        "hh"     => '%d hours',
        "d"      => 'a day',
        "dd"     => '%d days',
        "M"      => 'a month',
        "MM"     => '%d months',
        "y"      => 'a year',
        "yy"     => '%d years',
    ),
    "ordinal"       => function ($number)
    {
        $n = $number % 100;
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');

        if ($n >= 11 && $n <= 13)
        {
            return $number . '[th]';
        }

        return $number . '[' . $ends[$number % 10] . ']';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
    "customFormats" => array(
        "LT" => "G:i",               // 22:00
        "LTS" => "G:i:s",            // 22:00:00
        "L" => "d/m/Y",              // 12/06/2010
        "l" => "j/n/Y",              // 12/6/2010
        "LL" => "j F Y",             // 12 June 2010
        "ll" => "j M Y",             // 12 Jun 2010
        "LLL" => "j F Y G:i",        // 12 June 2010 22:00
        "lll" => "j M Y G:i",        // 12 Jun 2010 22:00
        "LLLL" => "l, j F F Y G:i",  // Saturday, 12 June June 2010 22:00
        "llll" => "D, j M Y G:i",    // Sat, 12 Jun 2010 22:00
    ),
);
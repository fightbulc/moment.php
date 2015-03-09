<?php

// moment.js locale configuration
// locale => great britain english (en-gb)
// author => Chris Gedrim => https=>//github.com/chrisgedrim

return array(
    "months"        => explode('_', 'January_February_March_April_May_June_July_August_September_October_November_December'),
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
        $b = $number % 10;
        $output = (~~($number % 100 / 10) === 1) ? 'th' :
            ($b === 1) ? 'st' :
                ($b === 2) ? 'nd' :
                    ($b === 3) ? 'rd' : 'th';

        return $number . "[$output]";
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
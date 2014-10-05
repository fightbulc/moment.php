<?php

// moment.js locale configuration
// locale => great britain english (en-gb)
// author => Chris Gedrim => https=>//github.com/chrisgedrim

return [
    "months"        => explode('_', 'Januar_Februar_März_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'),
    "monthsShort"   => explode('_', 'Jan_Feb_Mär_Apr_Mai_Jun_Jul_Aug_Sep_Okt_Nov_Dez'),
    "weekdays"      => explode('_', 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'),
    "weekdaysShort" => explode('_', 'So_Mo_Di_Mi_Do_Fr_Sa'),
    "calendar"      => [
        "sameDay"  => '[Today at] LT',
        "nextDay"  => '[Tomorrow at] LT',
        "nextWeek" => 'dddd [at] LT',
        "lastDay"  => '[Yesterday at] LT',
        "lastWeek" => '[Last] dddd [at] LT',
        "sameElse" => 'L',
    ],
    "relativeTime"  => [
        "future" => 'in %s',
        "past"   => 'vor %s',
        "s"      => 'ein paar Sekunden',
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
    ],
    "ordinal"       => function ($number)
    {
        $b = $number % 10;
        $output = (~~($number % 100 / 10) === 1) ? 'th' :
            ($b === 1) ? 'st' :
                ($b === 2) ? 'nd' :
                    ($b === 3) ? 'rd' : 'th';

        return $number . $output;
    },
    "week"          => [
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ],
];
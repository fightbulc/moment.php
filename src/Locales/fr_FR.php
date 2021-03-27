<?php

// locale: french (fr)
// author: John Fischer https://github.com/jfroffice

return array(
    "months"        => explode('_', 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'),
    "monthsShort"   => explode('_', 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'),
    "weekdays"      => explode('_', 'lundi_mardi_mercredi_jeudi_vendredi_samedi_dimanche'),
    "weekdaysShort" => explode('_', 'lun._mar._mer._jeu._ven._sam._dim.'),
    "calendar"      => array(
        "sameDay"  => '[Aujourd\'hui]',
        "nextDay"  => '[Demain]',
        "lastDay"  => '[Hier]',
        "lastWeek" => 'l [dernier]',
        "sameElse" => 'l',
        "withTime" => '[à] G [h] i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'dans %s',
        "past"   => 'il y a %s',
        "s"      => 'quelques secondes',
        "ss"     => '%d secondes',
        "m"      => 'une minute',
        "mm"     => '%d minutes',
        "h"      => 'une heure',
        "hh"     => '%d heures',
        "d"      => 'un jour',
        "dd"     => '%d jours',
        "M"      => 'un mois',
        "MM"     => '%d mois',
        "y"      => 'un an',
        "yy"     => '%d ans',
    ),
    "ordinal"       => function ($number)
    {
        return $number . ($number === 1 || $number === '1' ? '[er]' : '');
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
    "customFormats" => array(
        "LT"   => "G:i", // 20:30
        "L"    => "d/m/Y", // 04/09/1986
        "l"    => "j/n/Y", // 4/9/1986
        "LL"   => "jS F Y", // 4 Septembre 1986
        "ll"   => "j M Y", // 4 Sep 1986
        "LLL"  => "jS F Y G:i", // 4 Septembre 1986 20:30
        "lll"  => "j M Y G:i", // 4 Sep 1986 20:30
        "LLLL" => "l, jS F Y G:i", // Jeudi, 4 Septembre 1986 20:30
        "llll" => "D, j M Y G:i", // Jeu, 4 Sep 1986 20:30
    ),
);

<?php

// moment.js locale configuration
// locale : french (fr)
// author : John Fischer : https://github.com/jfroffice

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
        "withTime" => '[á] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'dans %s',
        "past"   => 'il y a %s',
        "s"      => 'quelques secondes',
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
        return $number . ($number === 1 ? '[er]' : '');
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
<?php

// locale: Occitan languedocian dialect (oc_lnc)
// author: CROWD Studio https://github.com/crowd-studio

return array(
    "months"        => explode('_', 'genièr_febrièr_març_abril_mai_junh_julhet_agost_setembre_octobre_novembre_decembre'),
    "monthsShort"   => explode('_', 'gen._feb._mar._abr._mai._jun._jul._ag._set._oct._nov._dec.'),
    "weekdays"      => explode('_', 'dimenge_diluns_dimars_dimècres_dijòus_divendres_dissabte'),
    "weekdaysShort" => explode('_', 'dg._dl._dm._dc._dj._dv._ds.'),
    "calendar"      => array(
        "sameDay"  => '[uèi]',
        "nextDay"  => '[deman]',
        "lastDay"  => '[ièr]',
        "lastWeek" => 'l [passat]',
        "sameElse" => 'l',
        "withTime" => '[a] H[o]i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'dins %s',
        "past"   => 'fa %s',
        "s"      => 'unas segondas',
        "ss"      => '%d segondas',
        "m"      => 'una minuta',
        "mm"     => '%d minutas',
        "h"      => 'una ora',
        "hh"     => '%d oras',
        "d"      => 'un jorn',
        "dd"     => '%d jorns',
        "M"      => 'un mes',
        "MM"     => '%d meses',
        "y"      => 'un an',
        "yy"     => '%d ans',
    ),
    "ordinal"       => function ($number)
    {
        switch ($number)
        {
            case 1:
                $output = 'r';
                break;
            case 2:
                $output = 'n';
                break;
            case 3:
                $output = 'r';
                break;
            case 4:
                $output = 't';
                break;
            default:
                $output = 'è';
                break;
        }

        return $number . '[' . $output . ']';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

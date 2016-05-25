<?php

// locale: Catalan (ca_ES)
// author: CROWD Studio https://github.com/crowd-studio

return array(
    "months"        => explode('_', 'gener_febrer_març_abril_maig_juny_juliol_agost_setembre_octubre_novembre_desembre'),
    "monthsShort"   => explode('_', 'gen._febr._mar._abr._mai._jun._jul._ag._set._oct._nov._des.'),
    "weekdays"      => explode('_', 'diumenge_dilluns_dimarts_dimecres_dijous_divendres_dissabte'),
    "weekdaysShort" => explode('_', 'dg._dl._dt._dc._dj._dv._ds.'),
    "calendar"      => array(
        "sameDay"  => '[avui]',
        "nextDay"  => '[demà]',
        "lastDay"  => '[ahir]',
        "lastWeek" => '[el] l',
        "sameElse" => 'l',
        "withTime" => function (Moment $moment) { return '[a' . ($moment->getHour() !== 1 ? ' les' : null) . '] H:i'; },
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'en %s',
        "past"   => 'fa %s',
        "s"      => 'uns segons',
        "m"      => 'un minut',
        "mm"     => '%d minuts',
        "h"      => 'una hora',
        "hh"     => '%d hores',
        "d"      => 'un dia',
        "dd"     => '%d dies',
        "M"      => 'un mes',
        "MM"     => '%d mesos',
        "y"      => 'un any',
        "yy"     => '%d anys',
    ),
    "ordinal"       => function ($number)
    {

        switch ($number) {
            case 1:
                $ouput = 'r';
                break;
            case 2:
                $ouput = 'n';
                break;
            case 3:
                $ouput = 'r';
                break;
            case 4:
                $ouput = 't';
                break;
            default:
                $ouput = 'è';
                break;
        }

        return $number . '[' . $output . ']';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
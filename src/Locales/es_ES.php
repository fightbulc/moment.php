<?php

// locale: spanish (es)
// author: Julio Napurí https://github.com/julionc

use Moment\Moment;

return array(
    "months"        => explode('_', 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'),
    "monthsShort"   => explode('_', 'ene._feb._mar._abr._may._jun._jul._ago._sep._oct._nov._dic.'),
    "weekdays"      => explode('_', 'lunes_martes_miércoles_jueves_viernes_sábado_domingo'),
    "weekdaysShort" => explode('_', 'lun._mar._mié._jue._vie._sáb._dom.'),
    "calendar"      => array(
        "sameDay"  => '[hoy]',
        "nextDay"  => '[mañana]',
        "lastDay"  => '[ayer]',
        "lastWeek" => '[el] l',
        "sameElse" => 'l',
        "withTime" => function (Moment $moment) { return '[a la' . ($moment->getHour() != 1 ? 's' : null) . '] G:i [h]'; },
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'en %s',
        "past"   => 'hace %s',
        "s"      => 'unos segundos',
        "ss"      => '%d segundos',
        "m"      => 'un minuto',
        "mm"     => '%d minutos',
        "h"      => 'una hora',
        "hh"     => '%d horas',
        "d"      => 'un día',
        "dd"     => '%d días',
        "M"      => 'un mes',
        "MM"     => '%d meses',
        "y"      => 'un año',
        "yy"     => '%d años',
    ),
    "ordinal"       => function ($number)
    {
        return $number . 'º';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

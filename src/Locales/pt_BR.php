<?php

// locale: portuguese (pt-br)
// author: Jefferson Santos https://github.com/jefflssantos

use Moment\Moment;

return array(
    "months"        => explode('_', 'janeiro_fevereiro_março_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro'),
    "monthsShort"   => explode('_', 'jan._fev._mar._abr._mai._jun._jul._ago._set._out._nov._dez.'),
    "weekdays"      => explode('_', 'segunda_terça_quarta_quinta_sexta_sábado_domingo'),
    "weekdaysShort" => explode('_', 'seg._ter._qua._qui._sex._sáb._dom.'),
    "calendar"      => array(
        "sameDay"  => '[hoje]',
        "nextDay"  => '[amanhã]',
        "lastDay"  => '[ontem]',
        "lastWeek" => '[último] l',
        "sameElse" => 'eu',
        "withTime" => function (Moment $moment) { return '[à' . ($moment->getHour() !== 1 ? 's' : null) . '] H:i'; },
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'em %s',
        "past"   => 'há %s',
        "s"      => 'alguns segundos',
        "ss"      => '%d segundos',
        "m"      => 'um minuto',
        "mm"     => '%d minutos',
        "h"      => 'uma hora',
        "hh"     => '%d horas',
        "d"      => 'um dia',
        "dd"     => '%d dias',
        "M"      => 'um mês',
        "MM"     => '%d meses',
        "y"      => 'um ano',
        "yy"     => '%d anos',
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

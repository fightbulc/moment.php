<?php

use Moment\Moment;

$plural = function(array $forms, $num)
{

    if ($num % 10 == 1 && $num % 100 != 11) {
        return $forms[0];
    } else {
        if ($num % 10 >= 2 && $num % 10 <= 4 && ($num % 100 < 10 || $num % 100 >= 20)) {
            return ($forms[1]);
        } else {
            return ($forms[2]);
        }
    }

};

return array(
    "months"        => explode('_', 'Січень_Лютий_Березень_Квітень_Травень_Червень_Липень_Серпень_Вересень_Жовтень_Листопад_Грудень'),
    "monthsShort"   => explode('_', 'Січ_Лют_Бер_Кві_Тра_Чер_Лип_Сер_Вер_Жов_Лис_Гру'),
    "weekdays"      => explode('_', 'Понеділок_Вівторок_Середа_Четвер_П\'ятниця_Субота_Неділя'),
    "weekdaysShort" => explode('_', 'Пн_Вт_Ср_Чт_Пт_Сб_Нд'),
    "calendar"      => array(
        "sameDay"  => '[Сьогодні]',
        "nextDay"  => '[Завтра]',
        "lastDay"  => '[Вчора]',
        "lastWeek" => '[Минолого тижня] l',
        "sameElse" => 'l',
        "withTime" => '[at] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'через %s',
        "past"   => '%s тому',
        "s"      => 'декілька секунд',
        "m"      => 'хвилина',
        "mm"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'хвилина_хвилини_хвилин'), $count));
        },
        "h"      => 'годину',
        "hh"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'година_години_годин'), $count));
        },
        "d"      => 'день',
        "dd"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'день_дні_днів'), $count));
        },
        "M"      => 'місяць',
        "MM"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'місяців_місяці_місяців'), $count));
        },
        "y"      => 'рік',
        "yy"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'рік_роки_років'), $count));
        },
    ),
    "ordinal"       => function ($number)
    {
        return $number;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
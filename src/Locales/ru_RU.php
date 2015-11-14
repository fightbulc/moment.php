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
    "months"        => explode('_', 'Январь_Февраль_Март_Апрель_Май_Июнь_Июль_Август_Сентябрь_Октябрь_Ноябрь_Декабрь'),
    "monthsShort"   => explode('_', 'Янв_Фев_Мар_Апр_Май_Июн_Июл_Авг_Сен_Окт_Ноя_Дек'),
    "weekdays"      => explode('_', 'Понедельник_Вторник_Среда_Четверг_Пятница_Суббота_Воскресенье'),
    "weekdaysShort" => explode('_', 'Пн_Вт_Ср_Чт_Пт_Сб_Вс'),
    "calendar"      => array(
        "sameDay"  => '[Сегодня]',
        "nextDay"  => '[Завтра]',
        "lastDay"  => '[Вчера]',
        "lastWeek" => '[Прошлая неделя] l',
        "sameElse" => 'l',
        "withTime" => '[at] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'через %s',
        "past"   => '%s назад',
        "s"      => 'несколько секунд',
        "m"      => 'минуту',
        "mm"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'минуту_минуты_минут'), $count));
        },
        "h"      => 'час',
        "hh"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'час_часа_часов'), $count));
        },
        "d"      => 'день',
        "dd"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'день_дня_дней'), $count));
        },
        "M"      => 'месяц',
        "MM"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'месяц_месяца_месяцев'), $count));
        },
        "y"      => 'год',
        "yy"     => function($count, $direction, Moment $m) use ($plural) {
            return sprintf("%d %s", $count, $plural(explode('_', 'год_года_лет'), $count));
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
<?php
// locale: Korean
// author: amouro https://github.com/amouro
return array(
    "months"        => explode('_', '1월_2월_3월_4월_5월_6월_7월_8월_9월_10월_11월_12월'),
    "monthsShort"   => explode('_', '1월_2월_3월_4월_5월_6월_7월_8월_9월_10월_11월_12월'),
    "weekdays"      => explode('_', '일요일_월요일_화요일_수요일_목요일_금요일_토요일'),
    "weekdaysShort" => explode('_', '일_월_화_수_목_금_토'),
    "weekdaysMin"   => explode('_', '일_월_화_수_목_금_토'),
    "calendar"      => array(
        "sameDay"   => '[오늘] LT',
        "nextDay"   => '[내일] LT',
        "lastDay"   => '[어제] LT',
        "lastWeek" => '[지난주] dddd LT',
        "sameElse" => 'L',
        "withTime" => 'H:i',
        "default"  => 'Y년 m월 d일',
    ),
    "relativeTime"  => array(
        "future" => '%s 후',
        "past"   => '%s 전',
        "s"      => '몇 초',
        "ss"      => '%d 초',
        "m"      => '1 분',
        "mm"     => '%d 분',
        "h"      => '한 시간',
        "hh"     => '%d 시간',
        "d"      => '하루',
        "dd"     => '%d 일',
        "M"      => '한 달',
        "MM"     => '%d 달',
        "y"      => '일 년',
        "yy"     => '%d 년',
    ),
    "ordinal"       => function ($number, $token)
    {
        $symbol = null;

        switch ($token)
        {
            case 'd':
            case 'D':
            case 'DDD':
                $symbol = '일';
            case 'M':
                $symbol = '월';
            case 'w':
            case 'W':
                $symbol = '주';
            default:
        }

        return $number . $symbol;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

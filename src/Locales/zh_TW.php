<?php

// locale: traditional chinese (zh-tw)
// author: Ben https://github.com/ben-lin
// author: Senorsen https://github.com/Senorsen
// author: Tino Ehrich https://github.com/fightbulc

return array(
    "months"        => explode('_', '一月_二月_三月_四月_五月_六月_七月_八月_九月_十月_十一月_十二月'),
    "monthsShort"   => explode('_', '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'),
    "weekdays"      => explode('_', '星期一_星期二_星期三_星期四_星期五_星期六_星期日'),
    "weekdaysShort" => explode('_', '週一_週二_週三_週四_週五_週六_週日'),
    "weekdaysMin"   => explode('_', '一_二_三_四_五_六_日'),
    "calendar"      => array(
        "sameDay"   => '[今天]',
        "nextDay"   => '[明天]',
        "lastDay"   => '[昨天]',
        "lastWeek" => '[上]D',
        "sameElse" => '[本]D',
        "withTime" => 'H:i',
        "default"  => 'Y-m-d',
    ),
    "relativeTime"  => array(
        "future" => '%s內',
        "past"   => '%s前',
        "s"      => '幾秒',
        "m"      => '一分鐘',
        "mm"     => '%d分鐘',
        "h"      => '一小時',
        "hh"     => '%d小時',
        "d"      => '一天',
        "dd"     => '%d天',
        "M"      => '一個月',
        "MM"     => '%d個月',
        "y"      => '一年',
        "yy"     => '%d年',
    ),
    "ordinal"       => function ($number, $token)
    {
        $symbol = null;

        switch ($token)
        {
            case 'd':
            case 'w':
                $symbol = '[日]';
                break;

            case 'n':
                $symbol = '[月]';
                break;

            case 'W':
                $symbol = '[週]';
                break;

            default:
        }

        return $number . $symbol;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

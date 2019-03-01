<?php

// locale: traditional chinese (zh-tw)
// author: Ben https://github.com/ben-lin
// author: Senorsen https://github.com/Senorsen
// author: Tino Ehrich https://github.com/fightbulc

return array(
    "months"        => explode('_', '一月_二月_三月_四月_五月_六月_七月_八月_九月_十月_十一月_十二月'),
    "monthsShort"   => explode('_', '1 月_2 月_3 月_4 月_5 月_6 月_7 月_8 月_9 月_10 月_11 月_12 月'),
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
        "ss"      => '%d秒',
        "m"      => '1 分鐘',
        "mm"     => '%d 分鐘',
        "h"      => '1 小時',
        "hh"     => '%d 小時',
        "d"      => '1 天',
        "dd"     => '%d 天',
        "M"      => '1 個月',
        "MM"     => '%d 個月',
        "y"      => '1 年',
        "yy"     => '%d 年',
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

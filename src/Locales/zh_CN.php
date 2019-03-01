<?php

// locale: chinese (zh-cn)
// author: suupic https://github.com/suupic
// author: Zeno Zeng https://github.com/zenozeng
// author: Senorsen https://github.com/Senorsen
// author: Tino Ehrich https://github.com/fightbulc

return array(
    "months"        => explode('_', '一月_二月_三月_四月_五月_六月_七月_八月_九月_十月_十一月_十二月'),
    "monthsShort"   => explode('_', '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'),
    "weekdays"      => explode('_', '星期一_星期二_星期三_星期四_星期五_星期六_星期日'),
    "weekdaysShort" => explode('_', '周一_周二_周三_周四_周五_周六_周日'),
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
        "future" => '%s内',
        "past"   => '%s前',
        "s"      => '几秒',
        "ss"      => '%d秒',
        "m"      => '1分钟',
        "mm"     => '%d分钟',
        "h"      => '1小时',
        "hh"     => '%d小时',
        "d"      => '1天',
        "dd"     => '%d天',
        "M"      => '1个月',
        "MM"     => '%d个月',
        "y"      => '1年',
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
                $symbol = '[周]';
                break;

            default:
        }

        return $number . $symbol;
    },
    "week"          => array(
        // GB/T 7408-1994《数据元和交换格式·信息交换·日期和时间表示法》与ISO 8601:1988等效
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

<?php

// locale: chinese (zh-cn)
// author: suupic : https://github.com/suupic
// author: Zeno Zeng : https://github.com/zenozeng
// author: Senorsen : https://github.com/Senorsen

return array(
    "months"        => explode('_', '一月_二月_三月_四月_五月_六月_七月_八月_九月_十月_十一月_十二月'),
    "monthsShort"   => explode('_', '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'),
    "weekdays"      => explode('_', '星期日_星期一_星期二_星期三_星期四_星期五_星期六'),
    "weekdaysShort" => explode('_', '周日_周一_周二_周三_周四_周五_周六'),
    "weekdaysMin"   => explode('_', '日_一_二_三_四_五_六'),
    "calendar"      => array(
        "sameDay"  => function() {
            return $this->minutes() === 0 ? '[今天]Ah[点整]' : '[今天]LT';
        },
        "nextDay"  => function() {
            return $this->minutes() === 0 ? '[明天]Ah[点整]' : '[明天]LT';
        },
        "lastDay"  => function() {
            return $this->minutes() === 0 ? '[昨天]Ah[点整]' : '[昨天]LT';
        },
        "lastWeek" => '[上周] l',
        "sameElse" => 'l',
        "withTime" => '[于] H:i',
        "default"  => 'Y-m-d',
    ),
    "relativeTime"  => array(
        "future" => '%s内',
        "past"   => '%s前',
        "s"      => '几秒',
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
    "ordinal"       => function ($number, $period)
    {
        switch ($period) {
        case 'd':
        case 'D':
        case 'DDD':
            return $number . '日';
        case 'M':
            return $number . '月';
        case 'w':
        case 'W':
            return $number . '周';
        default:
            return $number;
        }
    },
    "week"          => array(
        // GB/T 7408-1994《数据元和交换格式·信息交换·日期和时间表示法》与ISO 8601:1988等效
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

<?php
// locale: Japanese ( ja-jp )
// author: Takumi https://github.com/takumi-dev
return array(
    "months"        => explode('_', '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'),
    "monthsShort"   => explode('_', '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'),
    "weekdays"      => explode('_', '月曜日_火曜日_水曜日_木曜日_金曜日_土曜日_日曜日'),
    "weekdaysShort" => explode('_', '月_火_水_木_金_土_日'),
    "calendar"      => array(
        "sameDay"  => '[今日]',
        "nextDay"  => '[明日]',
        "lastDay"  => '[昨日]',
        "lastWeek" => '[先週]l',
        "sameElse" => 'l',
        "withTime" => 'H時i分',
        "default"  => 'Y年m月d日',
    ),
    "relativeTime"  => array(
        "future" => '%s後',
        "past"   => '%s前',
        "s"      => '数秒',
        "ss"      => '%d秒',
        "m"      => '1分',
        "mm"     => '%d分',
        "h"      => '1時間',
        "hh"     => '%d時間',
        "d"      => '1日',
        "dd"     => '%d日',
        "M"      => '1ヶ月',
        "MM"     => '%dヶ月',
        "y"      => '1年',
        "yy"     => '%d年',
    ),
    "ordinal"       => function ($number)
    {
        $prefix = '第';
        return $prefix.$number;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
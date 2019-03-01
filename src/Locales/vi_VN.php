<?php

// locale: vietnamese - Viet Nam (vi_VN)
// author: Oanh Nguyen https://github.com/oanhnn

return array(
    "months"        => explode('_', 'Tháng một_Tháng hai_Tháng ba_Tháng tư_Tháng năm_Tháng sáu_Tháng bảy_Tháng tám_Tháng chín_Tháng mười_Tháng mười một_Tháng mười hai'),
    "monthsNominative" => explode('_', 'Tháng 1_Tháng 2_Tháng 3_Tháng 4_Tháng 5_Tháng 6_Tháng 7_Tháng 8_Tháng 9_Tháng 10_Tháng 11_Tháng 12'),
    "monthsShort"   => explode('_', 'Th1_Th2_Th3_Th4_Th5_Th6_Th7_Th8_Th9_Th10_Th11_Th12'),
    "weekdays"      => explode('_', 'Thứ 2_Thứ 3_Thứ 4_Thứ 5_Thứ 6_Thứ 7_Chủ nhật'),
    "weekdaysShort" => explode('_', 'T2_T3_T4_T5_T6_T7_CN'),
    "calendar"      => array(
        "sameDay"  => '[Hôm nay]',
        "nextDay"  => '[Ngày mai]',
        "lastDay"  => '[Hôm qua]',
        "lastWeek" => '[tuần trước] l',
        "sameElse" => 'l',
        "withTime" => '[lúc] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'vào %s',
        "past"   => '%s trước đây',
        "s"      => 'một vài giây',
        "ss"      => '%d giây',
        "m"      => 'một phút',
        "mm"     => '%d phút',
        "h"      => 'một giờ',
        "hh"     => '%d giờ',
        "d"      => 'một ngày',
        "dd"     => '%d ngày',
        "M"      => 'một tháng',
        "MM"     => '%d tháng',
        "y"      => 'một năm',
        "yy"     => '%d năm',
    ),
    "ordinal" => function ($number) {
        $prefix = "thứ ";

        return $prefix . $number;
    },
    "week" => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);


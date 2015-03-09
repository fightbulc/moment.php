<?php

// moment.js locale configuration
// locale => Thailand (th_TH)
// author => Tistee Boonsuwan => https://github.com/partynetwork

return array(
    "months"        => explode('_', 'มกราคม_กุมภาพันธ์_มีนาคม_เมษายน_พฤษภาคม_มิถุนายน_กรกฎาคม_สิงหาคม_กันยายน_ตุลาคม_พฤศจิกายน_ธันวาคม'),
    "monthsShort"   => explode('_', 'มกรา_กุมภา_มีนา_เมษา_พฤษภา_มิถุนา_กรกฎา_สิงหา_กันยา_ตุลา_พฤศจิกา_ธันวา'),
    "weekdays"      => explode('_', 'จันทร์_อังคาร_พุธ_พฤหัสบดี_ศุกร์_เสาร์_อาทิตย์'),
    "weekdaysShort" => explode('_', 'จันทร์_อังคาร_พุธ_พฤหัส_ศุกร์_เสาร์_อาทิตย์'),
    "calendar"      => array(
        "sameDay"  => '[วันนี้ เวลา]',
        "nextDay"  => '[พรุ่งนี้ เวลา]',
        "lastDay"  => '[Yesterday]',
        "lastWeek" => '[Last] l',
        "sameElse" => 'l',
        "withTime" => '[at] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'อีก %s',
        "past"   => '%s ที่แล้ว',
        "s"      => 'ไม่กี่วินาที',
        "m"      => '1 นาที',
        "mm"     => '%d นาที',
        "h"      => '1 ชั่วโมง',
        "hh"     => '%d ชั่วโมง',
        "d"      => '1 วัน',
        "dd"     => '%d วัน',
        "M"      => '1 เดือน',
        "MM"     => '%d เดือน',
        "y"      => '1 ปี',
        "yy"     => '%d ปี',
    ),
    "ordinal"       => function ($number)
    {
        return $number ;
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
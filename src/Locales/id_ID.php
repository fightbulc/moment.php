<?php

// locale: Indonesian (Indonesia) (id-id)
// author: Yuda Sukmana https://github.com/ydatech

return array(
    "months"        => explode('_', 'Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember'),
    "monthsShort"   => explode('_', 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Agu_Sep_Okt_Nov_Des'),
    "weekdays"      => explode('_', 'Senin_Selasa_Rabu_Kamis_Jum\'at_Sabtu_Minggu'),
    "weekdaysShort" => explode('_', 'Sen_Sel_Rab_Kam_Jum_Sab_Ming'),
    "calendar"      => array(
        "sameDay"  => '[Hari ini]',
        "nextDay"  => '[Besok]',
        "lastDay"  => '[Kemarin]',
        "lastWeek" => 'l [Kemarin]',
        "sameElse" => 'l',
        "withTime" => '[pukul] H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'dalam %s',
        "past"   => '%s yang lalu',
        "s"      => 'beberapa detik',
        "ss"      => '%d detik',
        "m"      => 'semenit',
        "mm"     => '%d menit',
        "h"      => 'satu jam',
        "hh"     => '%d jam',
        "d"      => 'satu hari',
        "dd"     => '%d hari',
        "M"      => 'satu bulan',
        "MM"     => '%d bulan',
        "y"      => 'satu tahun',
        "yy"     => '%d tahun',
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
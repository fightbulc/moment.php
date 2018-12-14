<?php

// locale: hungarian (hu)
// author: David Joseph Guzsik https://github.com/seinopsys

return array(
    "months"        => explode('_', 'január_február_március_április_május_június_július_augusztus_szeptember_október_november_december'),

    "monthsShort"   => explode('_', 'jan_feb_márc_ápr_máj_jún_júl_aug_szept_okt_nov_dec'),
    "weekdays"      => explode('_', 'hétfő_kedd_szerda_csütörtök_péntek_szombat_vasárnap'),
    "weekdaysShort" => explode('_', 'hét_kedd_sze_csüt_pén_szo_vas'),
    "calendar"      => array(
        "sameDay"  => '[ma] l[-kor]',
        "nextDay"  => '[holnap] l[-kor]',
        "lastDay"  => '[tegnap] l[-kor]',
        "lastWeek" => function($n, $dir, \Moment\Moment $Moment){
            $weekEndings = explode('_','vasárnap hétfőn kedden szerdán csütörtökön pénteken szombaton');
			return '[múlt] [' . $weekEndings[$Moment->getDay()] . '] l[-kor]';
        },
        "sameElse" => 'l',
        "withTime" => 'H:i[-kor]',
        "default"  => 'Y.m.d.',
    ),
    "relativeTime"  => array(
        "future" => '%s múlva',
        "past"   => '%s',
        "s"      => function($n, $dir){
            return ($dir === 'future') ? 'néhány másodperc' : 'néhány másodperce';
        },
        "ss"     => function($n, $dir){
            return "$n " . ($dir === 'future' ? 'másodperc' : 'másodperce');
        },
        "m"      => function($n, $dir){
            return 'egy ' . ($dir === 'future' ? 'perc' : 'perce');
        },
        "mm"     => function($n, $dir){
            return "$n " . ($dir === 'future' ? 'perc' : 'perce');
        },
        "h"      => function($n, $dir){
            return 'egy ' . ($dir === 'future' ? 'óra' : 'órája');
        },
        "hh"     => function($n, $dir){
            return "$n " . ($dir === 'future' ? 'óra' : 'órája');
        },
        "d"      => function($n, $dir){
            return 'egy ' . ($dir === 'future' ? 'nap' : 'napja');
        },
        "dd"     => function($n, $dir){
            return "$n " . ($dir === 'future' ? 'nap' : 'napja');
        },
        "M"      => function($n, $dir){
            return 'egy' . ($dir === 'future' ? 'hónap' : 'hónapja');
        },
        "MM"     => function($n, $dir){
            return "$n " . ($dir === 'future' ? 'hónap' : 'hónapja');
        },
        "y"      => function($n, $dir){
            return 'egy' . ($dir === 'future' ? 'év' : 'éve');
        },
        "yy"     => function($n, $dir){
            return "$n " . ($dir === 'future' ? 'év' : 'éve');
        },
    ),
    "ordinal"       => function ($number)
    {
        return "$number.";
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 7  // The week that contains Jan 1st is the first week of the year.
    ),
);

<?php

// locale: italia italiano (it_IT)
// author: Marco Manfredini https://github.com/Manfre98

use Moment\Moment;

return array(
    "months"        => explode('_', 'gennaio_febbraio_marzo_aprile_maggio_giugno_luglio_agosto_settembre_ottobre_novembre_dicembre'),
    "monthsShort"   => explode('_', 'gen_feb_mar_apr_mag_giu_lug_ago_set_ott_nov_dic'),
    "weekdays"      => explode('_', 'lunedì_martedì_mercoledì_giovedì_venerdì_sabato_domenica'),
    "weekdaysShort" => explode('_', 'lun_mar_mer_gio_ven_sab_dom'),
    "calendar"      => array(
        "sameDay"  => '[Oggi]',
        "nextDay"  => '[Domani]',
        "lastDay"  => '[Ieri]',
        "lastWeek" => function (Moment $moment) {
			switch ($moment->getWeekday()) {
				case 7:
					return 'l [scorsa]';
				default:
					return 'l [scorso]';
			}
		},
        "sameElse" => 'l',
        "withTime" => function (Moment $moment) {
			switch ($moment->getHour()) {
				case 0:
					return '[a] G:i';
				case 1:
					return '[all\']G:i';
				default:
					return '[alle] G:i';
			}
		},
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => 'tra %s',
        "past"   => '%s fa',
        "s"      => 'alcuni secondi',
        "ss"      => '%d secondi',
        "m"      => 'un minuto',
        "mm"     => '%d minuti',
        "h"      => 'un\'ora',
        "hh"     => '%d ore',
        "d"      => 'un giorno',
        "dd"     => '%d giorni',
        "M"      => 'un mese',
        "MM"     => '%d mesi',
        "y"      => 'un anno',
        "yy"     => '%d anni',
    ),
    "ordinal"       => function ($number)
    {
        return $number . 'º';
    },
    "week"          => array(
        "dow" => 1, // Monday is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
	),
	"customFormats" => array(
        "LT" => "G:i",               // 22:00
        "LTS" => "G:i:s",            // 22:00:00
        "L" => "d/m/Y",              // 12/06/2010
        "l" => "j/n/Y",              // 12/6/2010
        "LL" => "j F Y",             // 12 giugno 2010
        "ll" => "j M Y",             // 12 giu 2010
        "LLL" => "j F Y, G:i",       // 12 giugno 2010, 22:00
        "lll" => "j M Y, G:i",       // 12 giu 2010, 22:00
        "LLLL" => "l j F Y, G:i",    // sabato 12 giugno 2010, 22:00
        "llll" => "D j M Y, G:i",    // sab 12 giu 2010, 22:00
    ),
);

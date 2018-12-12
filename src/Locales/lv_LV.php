<?php

// locale: Latviešu (Latvian) (lv_LV)
// author: Artjoms Nemiro https://github.com/LinMAD

return array(
    'months'  => explode(
        '_',
        'Janvārī_Februārī_Martā_Aprīlī_Maijā_Jūnijā_Jūlijā_Augustā_Septembrī_Oktobrī_Novembrī_Decembrī'
    ),
    'monthsNominative' => explode(
        '_',
        'Janvāris_Februāris_Marts_Aprīlis_Maijs_Jūnijs_Jūlijs_Augusts_Septembris_Oktobris_Novembris_Decembris'
    ),
    'monthsShort'  => explode(
        '_',
        'Janv_Febr_Mar_Apr_Maijs_Jūn_Jūl_Aug_Sept_Okt_Nov_Dec'
    ),
    'weekdays'  => explode(
        '_',
        'Pirmdiena_Otrdiena_Trešdiena_Ceturtdiena_Piektdiena_Sestdiena_Svētdiena'
    ),
    'weekdaysShort'    => explode('_', 'Pr_Ot_Tr_Ce_Pk_Se_Sv'),
    'calendar'         => array(
        'sameDay'  => '[Šodien]',
        'nextDay'  => '[Rītdien]',
        'lastDay'  => '[Vakardien]',
        'lastWeek' => '[Pagājušā] l',
        'sameElse' => 'l',
        'withTime' => '[plkst.] H:i',
        'default'  => 'd.m.Y',
    ),
    'relativeTime'  => array(
        'future' => 'pēc %s',
        'past'   => 'pirms %s',
        's'      => 'dažām sekundēm',
        'ss'     => '%d sekundēm',
        'm'      => 'minūtes',
        'mm'     => '%d minūtēm',
        'h'      => 'stundas',
        'hh'     => '%d stundām',
        'd'      => 'dienas',
        'dd'     => '%d dienām',
        'M'      => 'mēneša',
        'MM'     => '%d mēnešiem',
        'y'      => 'gada',
        'yy'     => '%d gadiem',
    ),
    'ordinal' => function ($number) {
        return $number . '.';
    },
    'week'         => array(
        'dow' => 1, // Monday is the first day of the week.
        'doy' => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);
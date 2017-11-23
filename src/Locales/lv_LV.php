<?php

// locale: Latviešu (Latvian) (lv_LV)
// author: Artjoms Nemiro https://github.com/LinMAD

return array(
    'months'  => explode(
        '_',
        'Janvārī_Februāra_Marta_Aprīļa_Maija_Jūnija_Jūlija_Augustā_Septembrī_Oktobra_Novembra_Decembra'
    ),
    'monthsNominative' => explode(
        '_',
        'Janvāris_Februāris_Marts_Aprīlis_Maijs_Jūnijs_Jūlijs_Augusts_Septembris_Oktobris_Novembris_Decembris'
    ),
    'monthsShort'  => explode(
        '_',
        'Jan_Feb_Mar_Apr_Maijs_Jūnijs_Jūlijs_Aug_Sept_Okt_Nov_Dec'
    ),
    'weekdays'  => explode(
        '_',
        'Pirmdiena_Otrdiena_Trešdiena_Ceturtdiena_Piektdiena_Sestdiena_Svētdiena'
    ),
    'weekdaysShort'    => explode('_', 'Pr_Ot_Tr_Ce_Pk_Se_Sv'),
    'calendar'         => [
        'sameDay'  => '[Šodien]',
        'nextDay'  => '[Rīt]',
        'lastDay'  => '[Vakar]',
        'lastWeek' => '[Pagājušā] l',
        'sameElse' => 'l',
        'withTime' => '[plkst.] H:i',
        'default'  => 'd.m.Y',
    ],
    'relativeTime'  => array(
        'future' => 'pēc %s',
        'past'   => '%s atpakaļ',
        's'      => 'dažām sekundēm',
        'm'      => 'minūte',
        'mm'     => '%d minūtes',
        'h'      => 'stunda',
        'hh'     => '%d stundas',
        'd'      => 'diena',
        'dd'     => '%d dienas',
        'M'      => 'mēnesis',
        'MM'     => '%d mēneši',
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
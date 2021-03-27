<?php

// locale: Finnish (fi_FI)
// author: Jesper Skytte Marcussen https://github.com/greew

use Moment\Moment;

$numbersPast = explode(' ', 'nolla yksi kaksi kolme neljä viisi kuusi seitsemän kahdeksan yhdeksän');
$numbersFuture = [
    'nolla', 'yhden', 'kahden', 'kolmen', 'neljän', 'viiden', 'kuuden', $numbersPast[7], $numbersPast[8], $numbersPast[9]
];

$verbalNumber = function ($number, $direction) use ($numbersPast, $numbersFuture) {
    $isFuture = $direction !== 'past';
    return ($number < 10 ? ($isFuture ? $numbersFuture[$number] : $numbersPast[$number]) : $number);
};

return array(
  "months"        => explode('_', 'tammikuu_helmikuu_maaliskuu_huhtikuu_toukokuu_kesäkuu_heinäkuu_elokuu_syyskuu_lokakuu_marraskuu_joulukuu'),
  "monthsShort"   => explode('_', 'tammi_helmi_maalis_huhti_touko_kesä_heinä_elo_syys_loka_marras_joulu'),
  "weekdays"      => explode('_', 'sunnuntai_maanantai_tiistai_keskiviikko_torstai_perjantai_lauantai'),
  "weekdaysShort" => explode('_', 'su_ma_ti_ke_to_pe_la'),
  "calendar"      => array(
    "sameDay"  => '[tänään] [klo] LT',
    "nextDay"  => '[huomenna] [klo] LT',
    "lastDay"  => '[eilen] [klo] LT',
    "lastWeek" => '[viime] dddd[na] [klo] LT',
    "sameElse" => 'L',
    "withTime" => '[kl] H.i',
    "default"  => 'd/m/Y',
  ),
  "relativeTime"  => array(
    "future" => '%s päästä',
    "past"   => '%s sitten',
    "s"      => function ($count, $direction, Moment $m) {
        return $direction !== 'past' ? 'muutaman sekunnin' : 'muutama sekunti';
    },
    "m"      => function ($count, $direction, Moment $m) {
        return $direction !== 'past' ? 'minuutin' : 'minuutti';
    },
    "mm"     => function ($count, $direction, Moment $m) use ($verbalNumber) {
        $result = $direction !== 'past' ? 'minuutin' : 'minuuttia';
        return $verbalNumber($count, $direction) . ' ' . $result;
    },
    "h"      => function ($count, $direction, Moment $m) {
        return $direction !== 'past' ? 'tunnin' : 'tunti';
    },
    "hh"     => function ($count, $direction, Moment $m) use ($verbalNumber) {
        $result = $direction !== 'past' ? 'tunnin' : 'tuntia';
        return $verbalNumber($count, $direction) . ' ' . $result;
    },
    "d"      => function ($count, $direction, Moment $m) {
        return $direction !== 'past' ? 'päivän' : 'päivä';
    },
    "dd"     => function ($count, $direction, Moment $m) use ($verbalNumber) {
        $result = $direction !== 'past' ? 'päivän' : 'päivää';
        return $verbalNumber($count, $direction) . ' ' . $result;
    },
    "M"      => function ($count, $direction, Moment $m) {
        return $direction !== 'past' ? 'kuukauden' : 'kuukausi';
    },
    "MM"     => function ($count, $direction, Moment $m) use ($verbalNumber) {
        $result = $direction !== 'past' ? 'kuukauden' : 'kuukautta';
        return $verbalNumber($count, $direction) . ' ' . $result;
    },
    "y"      => function ($count, $direction, Moment $m) {
        return $direction !== 'past' ? 'vuoden' : 'vuosi';
    },
    "yy"     => function ($count, $direction, Moment $m) use ($verbalNumber) {
        $result = $direction !== 'past' ? 'vuoden' : 'vuotta';
        return $verbalNumber($count, $direction) . ' ' . $result;
    },
  ),
  "ordinal"       => function ($number)
  {
    return $number . '.';
  },
  "week"          => array(
    "dow" => 1, // Monday is the first day of the week.
    "doy" => 4  // The week that contains Jan 4th is the first week of the year.
  ),
);

<?php

// locale: Polski (Poland) (pl_PL)
// author: Mateusz Błaszczyk https://github.com/Zaszczyk

use Moment\Moment;

$ifLastDigitIsSpecial = function ($count, $trueString, $falseString)
{
    $specialDigits = array('2', '3', '4');

    return
        (in_array(mb_substr((string)$count, -1), $specialDigits) && $count > 20)
        || in_array((string)$count, $specialDigits)
            ? $trueString : $falseString;
};

return array(
    "months"        => explode('_', 'stycznia_lutego_marca_kwietnia_maja_czerwca_lipca_sierpnia_września_października_listopada_grudnia'),
    "monthsShort"   => explode('_', 'sty._lut._mar._kwi._maj_cze._lip._sie._wrz._paź._lis._gru.'),
    "weekdays"      => explode('_', 'poniedziałek_wtorek_środa_czwartek_piątek_sobota_niedziela'),
    "weekdaysShort" => explode('_', 'pon._wt._śr._czw._pt._sob._niedz.'),
    "calendar"      => array(
        "sameDay"  => '[dzisiaj]',
        "nextDay"  => '[jutro]',
        "lastDay"  => '[wczoraj]',
        "lastWeek" => function (Moment $moment)
        {
            $pre = 'ostatni';

            if ($moment->getWeekday() >= 6)
            {
                $pre = 'ostatnia';
            }

            return '[' . $pre . '] l';
        },
        "sameElse" => 'l',
        "withTime" => '[o] H:i',
        "default"  => 'd.m.Y',
    ),
    "relativeTime"  => array(
        "future" => 'za %s',
        "past"   => '%s temu',
        "s"      => 'kilka sekund',
        "m"      => '1 minutę',
        "mm"     => function ($count) use ($ifLastDigitIsSpecial)
        {
            return $ifLastDigitIsSpecial($count, '%d minuty', '%d minut');
        },
        "h"      => '1 godzinę',
        "hh"     => function ($count) use ($ifLastDigitIsSpecial)
        {
            return $ifLastDigitIsSpecial($count, '%d godziny', '%d godzin');
        },
        "d"      => 'dzień',
        "dd"     => '%d dni',
        "M"      => 'miesiąc',
        "MM"     => function ($count) use ($ifLastDigitIsSpecial)
        {
            return $ifLastDigitIsSpecial($count, '%d miesiące', '%d miesięcy');
        },
        "y"      => '1 rok',
        "yy"     => function ($count) use ($ifLastDigitIsSpecial)
        {
            return $ifLastDigitIsSpecial($count, '%d lata', '%d lat');
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
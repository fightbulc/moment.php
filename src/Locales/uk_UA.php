<?php

// locale: Українська (Ukrainian) (uk_UA)
// author: Mykola Pukhalskyi

/**
 * returns ending for plural form of word by number and array of variants (1, 4, 5)
 * example variants for apples ['яблуко', 'яблука', 'яблук']
 */

/**
 * @param int $number
 * @param array $endingArray
 *
 * @return string
 */
$getNumEnding = function ($number, array $endingArray)
{
    $number = $number % 100;

    if ($number >= 11 && $number <= 19)
    {
        return $endingArray[2];
    }

    $i = $number % 10;

    switch ($i)
    {
        case (1):
            $ending = $endingArray[0];
            break;
        case (2):
        case (3):
        case (4):
            $ending = $endingArray[1];
            break;
        default:
            $ending = $endingArray[2];
    }

    return $ending;
};

return array(
    'months'            => explode('_', 'січня_лютого_березня_квітня_травня_червня_липня_серпня_вересня_жовтня_листопада_грудня'),
    'monthsNominative'  => explode('_', 'січень_лютий_березень_квітень_травень_червень_липень_серпень_вересень_жовтень_листопад_грудень'),
    'monthsShort'       => explode('_', 'січ_лют_бер_квіт_трав_черв_лип_серп_вер_жовт_лист_груд'),
    'weekdays'          => explode('_', 'понеділок_вівторок_середа_четвер_п’ятниця_субота_неділя'),
    'weekdaysShort'     => explode('_', 'пн_вт_ср_чт_пт_сб_нд'),
    'calendar'          => array(
        'sameDay'  => '[сьогодні]',
        'nextDay'  => '[завтра]',
        'lastDay'  => '[вчора]', // or "учора". 
        'lastWeek' => 'l',
        'sameElse' => 'l',
        'withTime' => function (\Moment\Moment $number)
        {
            return $number->format('G') == 11 ? '[об] H:i' : '[о] H:i';
        },
        'default'  => 'd-m-Y',
    ),
    'relativeTime'      => array(
//        'future' => 'о %s', // or "об"
        'future' => function (\Moment\Moment $number)
        {
            return $number->format('G') == 11 ? 'об %s' : 'о %s';
        },
        'past'   => '%s тому',
        's'      => 'кілька секунд',
        'ss'      => 'кілька секунд',   // needs review by native speaker see https://github.com/fightbulc/moment.php/issues/166
        'm'      => 'хвилину',
        'mm'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d хвилину', '%d хвилини', '%d хвилин'));
        },
        'h'      => 'година',
        'hh'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d годину', '%d години', '%d годин'));
        },
        'd'      => 'день',
        'dd'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d день', '%d дні', '%d днів'));
        },
        'M'      => 'місяць',
        'MM'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d місяць', '%d місяці', '%d місяців'));
        },
        'y'      => 'рік',
        'yy'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d рік', '%d роки', '%d років'));
        },
    ),
    'ordinal'       => function ($number)
    {
        $n = $number % 100;
        $k = $number % 10;
        $ends = array('-ше', '-ге', '-тє', '-те', '-те', '-те', '-ме', '-ме', '-те', '-те');

        if ($n >= 11 && $n <= 13)
        {
            return $number . '[th]';
        }

        if ($n != 13 && $k = 3) {
            return $number . '[' . $ends[2] . ']';
        }

        return $number . '[' . $ends[$k] . ']';
    },
    'week'          => array(
        'dow' => 1, // Monday is the first day of the week.
        'doy' => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

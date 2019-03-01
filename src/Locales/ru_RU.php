<?php

// locale: Русский (Russia) (ru_RU)
// author: Oleg Bogdanov https://github.com/wormen

/**
 * returns ending for plural form of word by number and array of variants (1, 4, 5)
 * example variants for apples ['яблоко', 'яблока', 'яблок']
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
    'months'            => explode('_', 'января_февраля_марта_апреля_мая_июня_июля_августа_сентября_октября_ноября_декабря'),
    'monthsNominative'  => explode('_', 'январь_февраль_март_апрель_май_июнь_июль_август_сентябрь_октябрь_ноябрь_декабрь'),
    'monthsShort'       => explode('_', 'янв_фев_мрт_апр_май_июн_июл_авг_сен_окт_нбр_дек'),
    'weekdays'          => explode('_', 'понедельник_вторник_среда_четверг_пятница_суббота_воскресенье'),
    'weekdaysShort'     => explode('_', 'пн_вт_ср_чт_пт_сб_вс'),
    'calendar'          => array(
        'sameDay'  => '[сегодня]',
        'nextDay'  => '[завтра]',
        'lastDay'  => '[вчера]',
        'lastWeek' => 'l',
        'sameElse' => 'l',
        'withTime' => '[в] H:i',
        'default'  => 'd/m/Y',
    ),
    'relativeTime'      => array(
        'future' => 'через %s',
        'past'   => '%s назад',
        's'      => 'несколько секунд',
        'ss'     => function ($number) use ($getNumEnding)
        {
           return $getNumEnding($number, array('%d секунду', '%d секунды', '%d секунд'));
        },
        'm'      => 'минуту',
        'mm'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d минуту', '%d минуты', '%d минут'));
        },
        'h'      => 'час',
        'hh'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d час', '%d часа', '%d часов'));
        },
        'd'      => 'день',
        'dd'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d день', '%d дня', '%d дней'));
        },
        'M'      => 'месяц',
        'MM'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d месяц', '%d месяца', '%d месяцев'));
        },
        'y'      => 'год',
        'yy'     => function ($number) use ($getNumEnding)
        {
            return $getNumEnding($number, array('%d год', '%d года', '%d лет'));
        },
    ),
    'ordinal'       => function ($number)
    {
        return $number . 'е';
    },
    'week'          => array(
        'dow' => 1, // Monday is the first day of the week.
        'doy' => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

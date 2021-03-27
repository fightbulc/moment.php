<?php

// locale: Қазақша (Qazaqstan) (kz_KZ)
// author: Aibek Q https://github.com/AibekQ

/**
 * @param int $number
 * @param string $word
 * @param string $time
 * @return string
 */
$getTimeSuffix = function ($number, $word, $time) {
    switch ($word) {
        case 'секунд':
        case 'минут':
        case 'сағат':
            if ($time == 'future') {
                $word .= 'тан';
            }
            break;

        case 'күн':
            if ($time == 'future') {
                $word .= 'нен';
            }
            break;

        case 'ай':
        case 'жыл':
            if ($time == 'future') {
                $word .= 'дан';
            }
            break;
    }

    return "{$number} {$word}";
};

return array(
    'months' => explode('_', 'Қаңтар_Ақпан_Наурыз_Сәуір_Мамыр_Маусым_Шілде_Тамыз_Қыркүйек_Қазан_Қараша_Желтоқсан'),
    'monthsNominative' => explode('_', 'Қаңтар_Ақпан_Наурыз_Сәуір_Мамыр_Маусым_Шілде_Тамыз_Қыркүйек_Қазан_Қараша_Желтоқсан'),
    'monthsShort' => explode('_', 'Қаң_Ақп_Нау_Сәу_Мам_Мау_Шіл_Там_Қыр_Қаз_Қар_Жел'),
    'weekdays' => explode('_', 'Дүйсенбі_Сейсенбі_Сәрсенбі_Бейсенбі_Жұма_Сенбі_Жексенбі'),
    'weekdaysShort' => explode('_', 'Дб_Сc_Ср_Бб_Жм_Сб_Жб'),
    'calendar' => array(
        'sameDay' => '[бүгін]',
        'nextDay' => '[ертең]',
        'lastDay' => '[кеше]',
        'lastWeek' => 'l',
        'sameElse' => 'l',
        'withTime' => 'H:i уақытта',
        'default' => 'd.m.Y',
    ),
    'relativeTime' => array(
        'future' => '%s кейін',
        'past' => '%s бұрын',
        's' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'секунд', $time);
        },
        'ss' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'секунд', $time);
        },
        'm' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'минут', $time);
        },
        'mm' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'минут', $time);
        },
        'h' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'сағат', $time);
        },
        'hh' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'сағат', $time);
        },
        'd' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'күн', $time);
        },
        'dd' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'күн', $time);
        },
        'M' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'ай', $time);
        },
        'MM' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'ай', $time);
        },
        'y' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'жыл', $time);
        },
        'yy' => function ($number, $time) use ($getTimeSuffix) {
            return $getTimeSuffix($number, 'жыл', $time);
        },
    ),
    'ordinal' => function ($number) {
        return $number . 'е';
    },
    'week' => array(
        'dow' => 1, // Monday is the first day of the week.
        'doy' => 4  // The week that contains Jan 4th is the first week of the year.
    ),
);

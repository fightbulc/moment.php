<?php

// locale: Iranian farsi (fa_IR)

$locale = require __DIR__ . '/en_GB.php';
$locale['calendar']['withTime'] = '[at] h:i A';
$locale['calendar']['default'] = 'm/d/Y';
$locale['week']['dow'] = 7;
$locale["relativeTime"] = [
    "future" => 'در %s',
    "past" => '%s پیش',
    "s" => 'در چند ثانیه گذشته',
    "m" => 'یک دقیقه',
    "mm" => '%d دقیقه',
    "h" => 'یک ساعت',
    "hh" => '%d ساعت',
    "d" => 'یک روز',
    "dd" => '%d روز',
    "M" => 'یک ماه',
    "MM" => '%d ماه',
    "y" => 'یک سال',
    "yy" => '%d سال',
];
return $locale;

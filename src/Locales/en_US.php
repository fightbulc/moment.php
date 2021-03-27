<?php

// locale: american english (en_US)

$locale = require __DIR__ . '/en_GB.php';
$locale['calendar']['withTime'] = '[at] h:i A';
$locale['calendar']['default'] = 'm/d/Y';
$locale['week']['dow'] = 7;
$locale["customFormats"] = array(
    "LT"   => "g:i A", // 8:30 PM
    "L"    => "m/d/Y", // 09/04/1986
    "l"    => "n/j/Y", // 9/4/1986
    "LL"   => "F j, Y", // September 4, 1986
    "ll"   => "M j, Y", // Sep 4, 1986
    "LLL"  => "F j, Y g:i A", // September 4, 1986 8:30 PM
    "lll"  => "M j, Y g:i A", // Sep 4, 1986 8:30 PM
    "LLLL" => "l, F j, Y g:i A", // Thursday, September 4, 1986 8:30 PM
    "llll" => "D, M j, Y g:i A", // Thu, Sep 4, 1986 8:30 PM
);

return $locale;
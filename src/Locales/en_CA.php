<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Canadian English Locale (en_CA)
 *
 * @author     Abdoulaye Siby <https://github.com/asiby>
 * @copyright  2020 - Abdoulaye Siby
 * @license    MIT
 * @version    1.0
 *
 * February 14, 2020
 */

$locale = require __DIR__ . '/en_GB.php';

return array_merge($locale, array(
    "week"          => array_merge($locale['week'], array(
        "dow" => 7, // Monday is the first day of the week.
    )),
    "customFormats" => array_merge($locale['customFormats'], array(
        "LT"   => "g:i A",            // 10:00 PM
        "LTS"  => "g:i:s A",          // 10:00:00 PM
        "L"    => "Y/m/d",            // 1986/09/04
        "l"    => "Y/n/j",            // 1986/9/4
        "LL"   => "F j Y",            // September 14 986
        "ll"   => "M j Y",            // Sep 12 1986
        "LLL"  => "F j Y g:i A",      // September 12 1986 10:00 PM
        "lll"  => "M j Y g:i A",      // Sep 12 1986 10:00 PM
        "LLLL" => "l, F j Y g:i A",   // Saturday, September 12 1986 10:00 PM
        "llll" => "D, M j Y g:i A",   // Sat, Sep 12 1986 10:00 PM
    )),
));

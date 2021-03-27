<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Canadian French Locale (fr_CA)
 *
 * @author     Abdoulaye Siby <https://github.com/asiby>
 * @copyright  2020 - Abdoulaye Siby
 * @license    MIT
 * @version    1.0
 *
 * February 14, 2020
 */

$locale = require __DIR__ . '/fr_FR.php';

return array_merge($locale, array(
    "monthsShort"   => explode('_', 'jan._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'),
    "weekdaysShort" => explode('_', 'lun._mar._mer._jeu._ven._sam._dim.'),
    "calendar"      => array_merge($locale['calendar'], array(
        "default" => 'Y/m/d',
    )),
    "week"          => array_merge($locale['week'], array(
        "dow" => 7, // Monday is the first day of the week.
    )),
    "customFormats" => array_merge($locale['customFormats'], array(
        "L" => "Y/m/d", // 1986/09/04
        "l" => "Y/n/j", // 1986/9/4
    )),
));

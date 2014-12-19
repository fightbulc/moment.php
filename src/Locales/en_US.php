<?php

// moment.js locale configuration
// locale => american english (en_US)

$locale = require __DIR__ . '/en_GB.php';
$locale['calendar']['withTime'] = '[at] h:i A';
$locale['calendar']['default'] = 'm/d/Y';

return $locale;
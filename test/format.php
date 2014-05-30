<?php

require __DIR__ . '/../vendor/autoload.php';

$twitterCreatedAt = 'Fri Jun 24 17:43:26 +0000 2011';

$m = new \Moment\Moment($twitterCreatedAt);
echo $m->format('U');
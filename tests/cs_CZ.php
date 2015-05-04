<?php

require __DIR__ . '/../vendor/autoload.php';

\Moment\Moment::setLocale('cs_CZ');

$m1 = new \Moment\Moment('2013-02-01T07:00:00');
$m2 = $m1->cloning();

$m2->subtractDays(1);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(1);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(3);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(30);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(60);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(60);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(210);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

$m2->subtractDays(210);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";


$m2->subtractDays(1000);
echo $m2->from($m1)->getRelative() . "\n";
echo $m1->from($m2)->getRelative() . "\n";
echo "\n";

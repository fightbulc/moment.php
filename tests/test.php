<?php

require __DIR__ . '/../vendor/autoload.php';

$response = array();

// ############################################

$m = new \Moment\Moment();
$response['test01'] = $m->format();

// ------------------------------------------

$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
$response['test02'] = $m->addHours(2)->format();

// ------------------------------------------

$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
$response['test03'] = $m
    ->subtractDays(7)
    ->subtractMinutes(15)
    ->format();

// ------------------------------------------

$m = new \Moment\Moment('2013-02-01T07:00:00');
$result = $m->from('2011-09-25T10:00:00');
$response['test04.01'] = $result->getSeconds();
$response['test04.02'] = $result->getMinutes();
$response['test04.03'] = $result->getHours();
$response['test04.04'] = $result->getDays();
$response['test04.05'] = $result->getWeeks();
$response['test04.06'] = $result->getMonths();
$response['test04.07'] = $result->getYears();
$response['test04.08'] = $result->getRelative();

// ------------------------------------------

$m = new \Moment\Moment('2014-12-09T07:00:00');
$result = $m->fromNow();
$response['test05.00'] = $m->format('c');
$response['test05.01'] = $result->getSeconds();
$response['test05.02'] = $result->getMinutes();
$response['test05.03'] = $result->getHours();
$response['test05.04'] = $result->getDays();
$response['test05.05'] = $result->getWeeks();
$response['test05.06'] = $result->getMonths();
$response['test05.07'] = $result->getYears();
$response['test05.08'] = $result->getRelative();

// ------------------------------------------

$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
$response['test06.01'] = $m->format();
$response['test06.02'] = $m->setTimezone('UTC')->format();

// ------------------------------------------

$response['test07.locale'] = isset($_GET['locale']) ? $_GET['locale'] : 'fr_FR';
$m = new \Moment\Moment('2012-04-25T15:00:00', 'CET');
$response['test07.00'] = $m->format('l, dS F Y / H:i (e)');

$momentJs = new \Moment\CustomFormats\MomentJs();
$response['test07.01'] = $m->format('LT', $momentJs);
$m->setLocale($response['test07.locale'], true);
$response['test07.02'] = $m->format('LT', $momentJs);
$response['test07.03'] = $m->format('L', $momentJs);
$response['test07.04'] = $m->format('l', $momentJs);
$response['test07.05'] = $m->format('LL', $momentJs);
$response['test07.06'] = $m->format('ll', $momentJs);
$response['test07.07'] = $m->format('LLL', $momentJs);
$response['test07.08'] = $m->format('lll', $momentJs);
$response['test07.09'] = $m->format('LLLL', $momentJs);
$response['test07.10'] = $m->format('llll', $momentJs);

// ------------------------------------------

$m = new \Moment\Moment('2013-10-23T10:00:00', 'CET');
$momentPeriodVo = $m->getPeriod('week');

$response['test08.00'] = $momentPeriodVo
    ->getRefDate()
    ->format('Y-m-d');

$response['test08.01'] = $momentPeriodVo
    ->getStartDate()
    ->format('Y-m-d');

$response['test08.02'] = $momentPeriodVo
    ->getEndDate()
    ->format('Y-m-d');

$response['test08.03'] = $momentPeriodVo->getInterval();

$momentPeriodVo = $m->getPeriod('month');

$response['test08.04'] = $momentPeriodVo
    ->getStartDate()
    ->format('Y-m-d');

$response['test08.05'] = $momentPeriodVo
    ->getEndDate()
    ->format('Y-m-d');

$response['test08.06'] = $momentPeriodVo->getInterval();

$momentPeriodVo = $m->getPeriod('quarter');

$response['test08.07'] = $momentPeriodVo
    ->getStartDate()
    ->format('Y-m-d');

$response['test08.08'] = $momentPeriodVo
    ->getEndDate()
    ->format('Y-m-d');

$response['test08.09'] = $momentPeriodVo->getInterval();

// ------------------------------------------

//$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
$response['test09.01'] = $m->format('l, F jS Y g:i A');
$response['test09.02'] = $m->format('LLLL', new \Moment\CustomFormats\MomentJs());
$response['test09.03'] = $m->format('WS [week of the year]');
$response['test09.04'] = $m->format('Wo [week of the year]', new \Moment\CustomFormats\MomentJs());

// ------------------------------------------

$date = 'now';

// last week
$m = new \Moment\Moment($date, 'CET');
$response['test10.01'] = $m->subtractDays(6)->calendar();

// yesterday
$m = new \Moment\Moment($date, 'CET');
$response['test10.02'] = $m->subtractDays(1)->calendar();

// today
$m = new \Moment\Moment($date, 'CET');
$response['test10.03'] = $m->calendar();

// tomorrow
$m = new \Moment\Moment($date, 'CET');
$response['test10.04'] = $m->addDays(1)->calendar();

$m = new \Moment\Moment($date, 'CET');
$response['test10.05'] = $m->addDays(3)->calendar();

// everything else
$m = new \Moment\Moment($date, 'CET');
$response['test10.06'] = $m->addDays(10)->calendar();

// ------------------------------------------

$date = '20140515T10:15:23';
$m = new \Moment\Moment($date, 'CET');

$response['test11.00'] = $m->format();

foreach (array('minute', 'hour', 'day', 'week', 'month', 'quarter', 'year') as $k => $period)
{
    $index = $k + 1;
    $response['test11.0' . $index] = $m->startOf($period)->format();
}

// ------------------------------------------

$date = '20140515T10:15:23';
$m = new \Moment\Moment($date, 'CET');

$response['test12.00'] = $m->format();

foreach (array('minute', 'hour', 'day', 'week', 'month', 'quarter', 'year') as $k => $period)
{
    $index = $k + 1;
    $response['test12.0' . $index] = $m->endOf($period)->format();
}

// ############################################

$tmpl = join('', file('test.html'));

foreach ($response as $key => $value)
{
    $tmpl = str_replace('{{' . $key . '}}', $value, $tmpl);
}

echo $tmpl;

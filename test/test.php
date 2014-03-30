<?php

    require __DIR__ . '/../vendor/autoload.php';

    $response = array();

    // ############################################

    $m = new \Moment\Moment();
    $response['test01'] = $m->format();

    // ------------------------------------------

    $m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
    $response['test02'] = $m
        ->add('hours', 2)
        ->format();

    // ------------------------------------------

    $m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
    $response['test03'] = $m
        ->subtract('days', 7)
        ->subtract('minutes', 15)
        ->format();

    // ------------------------------------------

    $m = new \Moment\Moment('2012-05-12T15:00:00');
    $result = $m->from('2011-09-25T10:00:00');
    $response['test04.01'] = $result->getSeconds();
    $response['test04.02'] = $result->getMinutes();
    $response['test04.03'] = $result->getHours();
    $response['test04.04'] = $result->getDays();
    $response['test04.05'] = $result->getWeeks();

    // ------------------------------------------

    $m = new \Moment\Moment('2013-02-01T07:00:00');
    $result = $m->fromNow();
    $response['test05.01'] = $result->getSeconds();
    $response['test05.02'] = $result->getMinutes();
    $response['test05.03'] = $result->getHours();
    $response['test05.04'] = $result->getDays();
    $response['test05.05'] = $result->getWeeks();

    // ------------------------------------------

    $m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
    $response['test06.01'] = $m->format();
    $response['test06.02'] = $m
        ->setTimezone('UTC')
        ->format();

    // ------------------------------------------

    $m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
    $response['test07'] = $m->format('l, dS F Y / H:i (e)');

    // ------------------------------------------

    $m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
    $momentPeriodVo = $m->getPeriod('week');

    $response['test08.01'] = $momentPeriodVo
        ->getStartDate()
        ->format('Y-m-d');

    $response['test08.02'] = $momentPeriodVo
        ->getEndDate()
        ->format('Y-m-d');

    $response['test08.03'] = $momentPeriodVo
        ->getRefDate()
        ->format('Y-m-d');

    // ------------------------------------------

    $m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
    $response['test09.01'] = $m->format('l, F jS Y g:i A');
    $response['test09.02'] = $m->format('LLLL', new \Moment\CustomFormats\MomentJs());

    // ------------------------------------------

    $date = 'now';
    $response['test10.01'] = (new \Moment\Moment($date, 'CET'))->subtractDays(6)->calendar();
    $response['test10.02'] = (new \Moment\Moment($date, 'CET'))->subtractDays(1)->calendar();
    $response['test10.03'] = (new \Moment\Moment($date, 'CET'))->calendar();
    $response['test10.04'] = (new \Moment\Moment($date, 'CET'))->addDays(1)->calendar();
    $response['test10.05'] = (new \Moment\Moment($date, 'CET'))->addDays(3)->calendar();
    $response['test10.06'] = (new \Moment\Moment($date, 'CET'))->addDays(10)->calendar();

    // ############################################

    $tmpl = join('', file('test.html'));

    foreach ($response as $key => $value)
    {
        $tmpl = str_replace('{{' . $key . '}}', $value, $tmpl);
    }

    echo $tmpl;
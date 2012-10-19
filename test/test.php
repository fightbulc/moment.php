<?php

  require __DIR__ . '/../vendor/autoload.php';

  $response = array();

  // ############################################

  $m = new Moment();
  $response['test01'] = $m->format();

  $m = new Moment('2012-05-15T12:30:00', 'CET');
  $response['test02'] = $m->add('hours', 2)->format();

  $m = new Moment('2012-05-15T12:30:00', 'CET');
  $response['test03'] = $m->subtract('days', 7)->subtract('minutes', 15)->format();

  $m = new Moment('2012-05-12T15:00:00');
  $result = $m->from('2011-09-25T10:00:00');
  $response['test04.01'] = $result['seconds'];
  $response['test04.02'] = $result['minutes'];
  $response['test04.03'] = $result['hours'];
  $response['test04.04'] = $result['days'];
  $response['test04.05'] = $result['weeks'];

  $m = new Moment('2013-02-01T07:00:00');
  $result = $m->fromNow();
  $response['test05.01'] = $result['seconds'];
  $response['test05.02'] = $result['minutes'];
  $response['test05.03'] = $result['hours'];
  $response['test05.04'] = $result['days'];
  $response['test05.05'] = $result['weeks'];

  $m = new Moment('2012-04-25T03:00:00', 'CET');
  $response['test06.01'] = $m->format();
  $response['test06.02'] = $m->setTimezone('UTC')->format();

  $m = new Moment('2012-04-25T03:00:00', 'CET');
  $response['test07'] = $m->format('l, dS F Y / H:i (e)');

  // ############################################

  $tmpl = join('', file('test.html'));

  foreach($response as $key => $value)
  {
    $tmpl = str_replace('{{' . $key . '}}', $value, $tmpl);
  }

  echo $tmpl;
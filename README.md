<pre>
                                      _           _           
 _ __ ___   ___  _ __ ___   ___ _ __ | |_   _ __ | |__  _ __  
| '_ ` _ \ / _ \| '_ ` _ \ / _ \ '_ \| __| | '_ \| '_ \| '_ \ 
| | | | | | (_) | | | | | |  __/ | | | |_ _| |_) | | | | |_) |
|_| |_| |_|\___/|_| |_| |_|\___|_| |_|\__(_) .__/|_| |_| .__/ 
                                           |_|         |_|    
</pre>

# Intro

### What is moment.php?
Date library for parsing, manipulating and formatting dates.

### Any dependencies?
PHP 5.3 or later since moment.php is based on php's [DateTime Class](http://php.net/manual/en/class.datetime.php).

# Install

Below you see the easiest setup to install moment:

```json
{
    "require": {
        "fightbulc/moment": "1.2.*"
    }
}
```

If you wanna add it to your existing project just use the package reference: ```"fightbulc/moment": "1.2.*"```.

# Quick examples

### 1. Get a moment
```php
$m = new Moment(); // default is "now" UTC
echo $m->format(); // e.g. 2012-10-03T10:00:00+0000

$m = new Moment('now', 'Europe/Berlin');
echo $m->format(); // e.g. 2012-10-03T12:00:00+0200
```

### 2. Custom format

### 2.1 PHP only (Standard)

```php
$m = new Moment('2012-04-25T03:00:00', 'CET');
echo $m->format('l, dS F Y / H:i (e)'); // Wednesday, 25th April 2012 / 03:00 (Europe/Berlin)
```
Formats are based on PHP's [Date function](http://php.net/manual/en/function.date.php) and [DateTime class](http://www.php.net/manual/en/datetime.formats.php).

### 2.2 Non-php formats

You can now inject different format handling by passing along a class which implements the ```FormatsInterface```. You can find an example within the test folder for implementing all formats from [moment.js](http://momentjs.com/docs/#/displaying/format/). Thanks to [Ashish](https://github.com/ashishtilara) for taking the time to match ```moment.js``` formats to those of PHP. Have a look at the [test script](https://github.com/fightbulc/moment.php/blob/master/test/test.php) to see the example in action.

Everybody can write format classes in the same manner. Its easy and scalable.

```php
// get  desired formats class
require 'MomentJs.php';

// create a moment
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');

// format with moment.js definitions
echo $m->format('LLLL', new MomentJs()); // Wednesday, April 25th 2012 3:00 AM
```

### 3. Switch timezones
```php
$m = new Moment('2012-04-25T03:00:00', 'CET');
echo $m->setTimezone('UTC')->format(); // 2012-04-25T01:00:00+0000
```

### 4. Create a custom moment and manipulate it
```php
$m = new Moment('2012-05-15T12:30:00', 'CET');
echo $m->add('hours', 2)->format(); // 2012-05-15T14:30:00+0200

$m = new Moment('2012-05-15T12:30:00', 'CET');
echo $m->subtract('days', 7)->subtract('minutes', 15)->format(); // 2012-05-08T12:15:00+0200
```

### 5. Difference between dates
```php
$m = new Moment('2013-02-01T07:00:00');
$momentFromVo = $m->fromNow();

// or from a specific moment
$m = new Moment('2013-02-01T07:00:00');
$momentFromVo = $m->from('2011-09-25T10:00:00');

// result comes as a value object class
echo $momentFromVo->getSeconds()    // -19630800
echo $momentFromVo->getMinutes()    // -327180
echo $momentFromVo->getHours()      // -5453
echo $momentFromVo->getDays()       // -227.21
echo $momentFromVo->getWeeks()      // -32.46
```

### 6. Get date periods (week, month)
Sometimes its helpful to get the period boundaries of a given date. For instance in case that today is Wednesday and I need the starting-/end dates from today's week. Allowed periods are ```week``` and ```month```.

```php
$m = new Moment('2013-10-23T10:00:00');
$momentPeriodVo = $m->getPeriod('week');

// results comes as well as a value object class
echo $momentPeriodVo
    ->getStartDate()
    ->format('Y-m-d'); // 2013-10-21

echo $momentPeriodVo
    ->getEndDate()
    ->format('Y-m-d'); // 2013-10-27

echo $momentPeriodVo
    ->getRefDate()
    ->format('Y-m-d'); // 2013-10-23
```

# Roadmap

### Date validation
Handle invalid dates.

### Useful date calculations
Get date periods by a given interval. Valid periods would be: week, month, quarter, halfyear, year.
```php
$m = new Moment();

// Get the period for the 2nd quarter of 2012
$m->getPeriodByInterval('2012', 'quarter', 2);

// result as array
[reference] => 2012-04-01, [start] => 2012-04-01, [end] => 2012-06-30, [interval] => 2
```

# License
Moment.php is freely distributable under the terms of the MIT license.

Copyright (c) 2013 Tino Ehrich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

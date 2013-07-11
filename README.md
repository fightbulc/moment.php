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
        "fightbulc/moment": "1.0.*"
    }
}
```

If you wanna add it to your existing project just use the package reference: ```"fightbulc/moment": "1.0.*"```.

# Quick examples

### 1. Get a moment
```php
$m = new \Moment\Moment(); // default is "now" UTC
echo $m->format(); // e.g. 2012-10-03T10:00:00+0000

$m = new Moment('now', 'Europe/Berlin');
echo $m->format(); // e.g. 2012-10-03T12:00:00+0200
```

### 2. Custom format
```php
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
echo $m->format('l, dS F Y / H:i (e)'); // Wednesday, 25th April 2012 / 03:00 (Europe/Berlin)
```
Formats are based on PHP's [Date function](http://php.net/manual/en/function.date.php)
and [DateTime class](http://www.php.net/manual/en/datetime.formats.php).

### 3. Switch timezones
```php
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
echo $m->setTimezone('UTC')->format(); // 2012-04-25T01:00:00+0000
```

### 4. Create a custom moment and manipulate it
```php
$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
echo $m->add('hours', 2)->format(); // 2012-05-15T14:30:00+0200

$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
echo $m->subtract('days', 7)->subtract('minutes', 15)->format(); // 2012-05-08T12:15:00+0200
```

### 5. Difference between dates
```php
$m = new \Moment\Moment('2013-02-01T07:00:00');
$difference = $m->fromNow();

// or from a specific moment
$m = new \Moment\Moment('2013-02-01T07:00:00');
$difference = $m->from('2011-09-25T10:00:00');

// result comes as an array
var_dump($difference);

/* array(5) {
  ["seconds"]=> string(9) "-19630800"
  ["minutes"]=> string(7) "-327180"
  ["hours"]=> string(5) "-5453"
  ["days"]=> string(7) "-227.21"
  ["weeks"]=> string(6) "-32.46"
} */
```

# Roadmap

### Date validation
Handle invalid dates.

### Useful date calculations
Get the period by a given date. Valid periods would be: week, month, quarter, halfyear, year.
```php
$m = new \Moment\Moment();

// Get the period for the given date
$m->getPeriodByDate('2012-04-08', 'month');

// result as array
[reference] => 2012-04-08, [start] => 2012-04-01, [end] => 2012-04-30, [interval] => 04
```

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

Copyright (c) 2012 Tino Ehrich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

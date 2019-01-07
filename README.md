<pre>
                                      _           _           
 _ __ ___   ___  _ __ ___   ___ _ __ | |_   _ __ | |__  _ __  
| '_ ` _ \ / _ \| '_ ` _ \ / _ \ '_ \| __| | '_ \| '_ \| '_ \
| | | | | | (_) | | | | | |  __/ | | | |_ _| |_) | | | | |_) |
|_| |_| |_|\___/|_| |_| |_|\___|_| |_|\__(_) .__/|_| |_| .__/
                                           |_|         |_|    
</pre>

[![Build Status](https://travis-ci.org/fightbulc/moment.php.svg?branch=master)](https://travis-ci.org/fightbulc/moment.php)
[![Total Downloads](https://img.shields.io/packagist/dt/fightbulc/moment.svg?style=flat-square)](https://packagist.org/packages/fightbulc/moment)

[Change log](#changelog)

# Intro

### What is moment.php?

Date library for parsing, manipulating and formatting dates w/ i18n.

### Any dependencies?

PHP 5.3 or later since moment.php is based on php's [DateTime Class](http://php.net/manual/en/class.datetime.php).

-------------------------------------------------

# Install

Easy install via composer. Still no idea what composer is? Inform yourself [here](http://getcomposer.org).

```
composer require fightbulc/moment
```

-------------------------------------------------

# Quick examples

### Get a moment

```php
$m = new \Moment\Moment(); // default is "now" UTC
echo $m->format(); // e.g. 2012-10-03T10:00:00+0000

$m = new \Moment\Moment('now', 'Europe/Berlin');
echo $m->format(); // e.g. 2012-10-03T12:00:00+0200

$m = new \Moment\Moment('2017-06-06T10:00:00', 'Europe/Berlin');
echo $m->format(); // e.g. 2012-10-03T12:00:00+0200

$m = new \Moment\Moment(1499366585);
echo $m->format(); // e.g. 2017-07-06T18:43:05+0000
```

-------------------------------------------------

### Accepted date formats

Moment parses the following date formats as input:

```php
const ATOM = 'Y-m-d\TH:i:sP'; // 2005-08-15T15:52:01+00:00
const COOKIE = 'l, d-M-y H:i:s T'; // Monday, 15-Aug-2005 15:52:01 UTC
const ISO8601 = 'Y-m-d\TH:i:sO'; // 2005-08-15T15:52:01+0000
const RFC822 = 'D, d M y H:i:s O'; // Mon, 15 Aug 05 15:52:01 +0000
const RFC850 = 'l, d-M-y H:i:s T'; // Monday, 15-Aug-05 15:52:01 UTC
const RFC1036 = 'D, d M y H:i:s O'; // Mon, 15 Aug 05 15:52:01 +0000
const RFC1123 = 'D, d M Y H:i:s O'; // Mon, 15 Aug 2005 15:52:01 +0000
const RFC2822 = 'D, d M Y H:i:s O'; // Mon, 15 Aug 2005 15:52:01 +0000
const RSS = 'D, d M Y H:i:s O'; // Mon, 15 Aug 2005 15:52:01 +0000
const W3C = 'Y-m-d\TH:i:sP'; // 2005-08-15T15:52:01+00:00

// Moment also tries to parse dates without timezone or without seconds

const NO_TZ_MYSQL = 'Y-m-d H:i:s'; // 2005-08-15 15:52:01
const NO_TZ_NO_SECS = 'Y-m-d H:i'; // 2005-08-15 15:52
const NO_TIME = 'Y-m-d'; // 2005-08-15

// time fractions ".000" will be automatically removed
$timeWithFraction = '2016-05-04T10:00:00.000';
```

-------------------------------------------------

### Switch locale

Have a look at the ```Locales``` folder to see all supported languages. Default locale is ```en_GB```.

```php
$m = new \Moment\Moment();
echo $m->format('[Weekday:] l'); // e.g. Weekday: Wednesday

// set german locale
\Moment\Moment::setLocale('de_DE');

$m = new \Moment\Moment();
echo $m->format('[Wochentag:] l'); // e.g. Wochentag: Mittwoch
```

__Supported languages so far:__

```ar_TN``` Arabic (Tunisia)  
```ca_ES``` Catalan  
```zh_CN``` Chinese  
```zh_TW``` Chinese (traditional)  
```cs_CZ``` Czech  
```da_DK``` Danish  
```nl_NL``` Dutch  
```en_GB``` English (British)  
```en_US``` English (American)  
```fr_FR``` French (Europe)  
```de_DE``` German (Germany)  
```hu_HU``` Hungarian    
```id_ID``` Indonesian  
```it_IT``` Italian  
```ja_JP``` Japanese  
```oc_LNC``` Lengadocian
```lv_LV``` Latvian (Latviešu)
```pl_PL``` Polish  
```pt_BR``` Portuguese (Brazil)  
```pt_PT``` Portuguese (Portugal)  
```ru_RU``` Russian (Basic version)  
```es_ES``` Spanish (Europe)  
```se_SV``` Swedish  
```uk_UA``` Ukrainian  
```th_TH``` Thai  
```tr_TR``` Turkish  
```vi_VN``` Vietnamese  

-------------------------------------------------

### Switch timezones

```php
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
echo $m->setTimezone('UTC')->format(); // 2012-04-25T01:00:00+0000
```

#### Change default timezone

```php
\Moment\Moment::setDefaultTimezone('CET');

$m = new \Moment\Moment('2016-09-13T14:32:06');
echo $m->format(); // 2016-09-13T14:32:06+0100
```


-------------------------------------------------

### Custom format

#### I. PHP only (Standard)

```php
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
echo $m->format('l, dS F Y / H:i (e)'); // Wednesday, 25th April 2012 / 03:00 (Europe/Berlin)
```
Formats are based on PHP's [Date function](http://php.net/manual/en/function.date.php) and [DateTime class](http://www.php.net/manual/en/datetime.formats.php).

#### II. Non-php formats

You can now inject different format handling by passing along a class which implements the ```FormatsInterface```. You can find an example within the test folder for implementing all formats from [moment.js](http://momentjs.com/docs/#/displaying/format/). Thanks to [Ashish](https://github.com/ashishtilara) for taking the time to match ```moment.js``` formats to those of PHP. Have a look at the [test script](https://github.com/fightbulc/moment.php/blob/master/test/test.php) to see the example in action.

Everybody can write format classes in the same manner. Its easy and scalable.

```php
// get  desired formats class
// create a moment
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');

// format with moment.js definitions
echo $m->format('LLLL', new \Moment\CustomFormats\MomentJs()); // Wednesday, April 25th 2012 3:00 AM
```

`Custom formats` can also come as part of every `Locale`. If it does not exist for your locale yet go ahead and add it. See an example for the [French locale](https://github.com/fightbulc/moment.php/blob/master/src/Locales/fr_FR.php). 

#### III. Easy text escaping

Just wrap all your text within ```[]``` and all characters will be automatically escaped for you.

```php
$m = new \Moment\Moment('2012-04-25T03:00:00', 'CET');
echo $m->format('[We are in the month of:] F'); // We are in the month of: April
```

#### IV. Fixed ordinal representations

PHP's interal ordinal calculation seems to be buggy. I added a quick fix to handle this issue.

The following example prints the week of the year of the given date. It should print ```22nd```:

```php
// internal function
date('WS', mktime(12, 22, 0, 5, 27, 2014)); // 22th

// moment.php
$m = new \Moment\Moment('2014-05-27T12:22:00', 'CET');
$m->format('WS'); // 22nd
```

-------------------------------------------------

### Create custom moments and manipulate it

#### I. Past/Future moments

```php
$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
echo $m->addHours(2)->format(); // 2012-05-15T14:30:00+0200

$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
echo $m->subtractDays(7)->subtractMinutes(15)->format(); // 2012-05-08T12:15:00+0200

$m = new \Moment\Moment('@1401443979', 'CET'); // unix time
echo $m->subtractDays(7)->subtractMinutes(15)->format(); // 2014-05-23T09:44:39+0000
```

#### II. Clone a given moment

Sometimes its useful to take a given moment and work with it without changing the origin. For that use ```cloning()```.

```php
$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET');
$c = $m->cloning()->addDays(1);

echo $m->getDay(); // 15
echo $c->getDay(); // 16
```

Alternately, you can enable immutable mode on the origin.

```php
$m = new \Moment\Moment('2012-05-15T12:30:00', 'CET', true);
$c = $m->addDays(1);

echo $m->getDay(); // 15
echo $c->getDay(); // 16

// You can also change the immutable mode after creation:
$m->setImmutableMode(false)->subtractDays(1);

echo $m->getDay(); // 14
```

Immutable mode makes all modification methods call `cloning()` implicitly before applying their modifications.

#### III. Methods for manipulating the date/time

Add             | Subtract
---             | ---
addSeconds($s)  | subtractSeconds($s)
addMinutes($i)  | subtractMinutes($i)
addHours($h)    | subtractHours($h)
addDays($d)     | subtractDays($d)
addWeeks($w)    | subtractWeeks($w)
addMonths($m)   | subtractMonths($m)
addYears($y)    | subtractYears($y)

#### IV. Setter/Getter

Setter          | Getter
---             | ---
setSecond($s)   | getSecond()
setMinute($m)   | getMinute()
setHour($h)     | getHour()
setDay($d)      | getDay()
setMonth($m)    | getMonth()
setYear($y)     | getYear()
--              | getQuarter()

-------------------------------------------------

### Difference between dates

```php
$m = new \Moment\Moment('2013-02-01T07:00:00');
$momentFromVo = $m->fromNow();

// or from a specific moment
$m = new \Moment\Moment('2013-02-01T07:00:00');
$momentFromVo = $m->from('2011-09-25T10:00:00');

// result comes as a value object class
echo $momentFromVo->getDirection()  // "future"
echo $momentFromVo->getSeconds()    // -42411600
echo $momentFromVo->getMinutes()    // -706860
echo $momentFromVo->getHours()      // -11781
echo $momentFromVo->getDays()       // -490.88
echo $momentFromVo->getWeeks()      // -70.13
echo $momentFromVo->getMonths()     // -17.53
echo $momentFromVo->getYears()      // -1.42
echo $momentFromVo->getRelative()   // in a year
```

-------------------------------------------------

### Get date periods (week, month, quarter)

Sometimes its helpful to get the period boundaries of a given date. For instance in case that today is Wednesday and I need the starting-/end dates from today's week. Allowed periods are ```week```, ```month``` and ```quarter```.

```php
$m = new \Moment\Moment('2013-10-23T10:00:00');
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

echo $momentPeriodVo->getInterval(); // 43 = week of year
```

Same procedure for monthly and quarterly periods:

```php
$momentPeriodVo = $m->getPeriod('month');
$momentPeriodVo = $m->getPeriod('quarter');
```

-------------------------------------------------

### Calendar Times

Calendar time displays time relative to ```now```, but slightly differently than ```Moment::fromNow()```. ```Moment::calendar()``` will format a date with different strings depending on how close to today the date is.

```php
(new \Moment\Moment('2014-03-30T16:58:00', 'CET'))->subtractDays(6)->calendar(); // last week
(new \Moment\Moment('2014-03-30T16:58:00', 'CET'))->subtractDays(1)->calendar(); // yesterday
(new \Moment\Moment('2014-03-30T16:58:00', 'CET'))->calendar(); // today
(new \Moment\Moment('2014-03-30T16:58:00', 'CET'))->addDays(1)->calendar(); // tomorrow
(new \Moment\Moment('2014-03-30T16:58:00', 'CET'))->addDays(3)->calendar(); // next week
(new \Moment\Moment('2014-03-30T16:58:00', 'CET'))->addDays(10)->calendar(); // everything else
```

Time            | Display
---             | ---
Last week       | Last Monday at 15:54
The day before  | Yesterday at 15:54
The same day    | Today at 15:54
The next day    | Tomorrow at 15:54
The next week   | Wednesday at 15:54
Everything else | 04/09/2014

__Note:__ Use ```$moment->calendar(false)``` to leave out the time ```at 00:00```.

-------------------------------------------------

### startOf / endOf

Same process as for moment.js: mutates the original moment by setting it to the start/end of a unit of time.

```php
$m = new \Moment\Moment('20140515T10:15:23', 'CET');

$m->startOf('year');    // set to January 1st, 00:00 this year
$m->startOf('quarter');  // set to the beginning of the current quarter, 1st day of months, 00:00
$m->startOf('month');   // set to the first of this month, 00:00
$m->startOf('week');    // set to the first day of this week, 00:00
$m->startOf('day');     // set to 00:00 today
$m->startOf('hour');    // set to now, but with 0 mins, 0 secs
$m->startOf('minute');  // set to now, but with 0 seconds

$m->endOf('year');    // set to December 31st, 23:59 this year
$m->endOf('quarter');  // set to the end of the current quarter, last day of month, 23:59
$m->endOf('month');   // set to the last of this month, 23:59
$m->endOf('week');    // set to the last day of this week, 23:59
$m->endOf('day');     // set to 23:59 today
$m->endOf('hour');    // set to now, but with 59 mins, 59 secs
$m->endOf('minute');  // set to now, but with 59 seconds
```

__Note:__ I ignored the period of ```second``` since we are not dealing with milliseconds.

-------------------------------------------------

### Get dates for given weekdays for upcoming weeks

For one of my customers I needed to get moments by selected weekdays. __The task was:__ give me the dates for
```Tuesdays``` and ```Thursdays``` for the next three weeks. So I added a small handler which does exactly this.
As result you will receive an array filled with ```Moment Objects```.

```php
// 1 - 7 = Mon - Sun
$weekdayNumbers = [
    2, // tuesday
    4, // thursday
];

$m = new \Moment\Moment();
$dates = $m->getMomentsByWeekdays($weekdayNumbers, 3);

// $dates = [Moment, Moment, Moment ...]
```

You can now run through the result and put it formatted into a drop-down field or for whatever you might need it.

-------------------------------------------------

# Roadmap

- Try to port useful methods from moment.js
- Add unit tests

-------------------------------------------------

# Changelog

### 1.29.0
 - updated Italian locale
 - added:
    - custom formats for en_US
    - flag for loading similar locale

### 1.28.3
 - fixed typehint issue

### 1.28.2
 - fixed:
    - missing relativeTime format
    - allow 9-digit unixtime

### 1.28.1
 - fixed RFC2822 as valid format

### 1.28.0
 - fixed relative time
 - added Norwegian locale

### 1.27.0
 - fixes and locale additions [(see commits for the 22.11.2018)](https://github.com/fightbulc/moment.php/commits/master)

### 1.26.10
 - fixed:
    - Occitan locale

### 1.26.9
 - fixed:
    - Russian locale [issue](https://github.com/fightbulc/moment.php/issues/68#issuecomment-264890181)

### 1.26.8
 - added:
    - Portuguese (pt_PT)

### 1.26.7
 - fixed:
    - Hungarian locale weekdays order

### 1.26.6
 - added:
    - allow initialising Moment with unix timestamp without leading @

### 1.26.5
 - fixed:
    - Fix format of 'LLL' in Custom Formats

### 1.26.4
 - fixed:
    - removed php5.4+ only syntax

### 1.26.3
 - fixed:
    - Danish day- and monthnames correct case
    - French locale
    - PHPDocs
  - added:
    - consts for `NO_TZ_MYSQL`, `NO_TZ_NO_SECS` and `NO_TIME` when parsing dates
    
### 1.26.2
 - added:
    - Dutch customFormat

### 1.26.1
 - fixed:
    - Russian locale

### 1.26.0
 - added:
    - Turkish locale  
 - fixed:
    - Lengadocian locale

### 1.25.1
 - fixed:
    - PHP7.1 setTime requires `$microseconds`  

### 1.25
 - added:
    - Ukrainian locale  

### 1.24
 - added:
    - Hungarian locale  

### 1.23.1
 - fixed:
    - Lengadocian locale  

### 1.23.0
 - added:
    - Vietnamese locale
    - Lengadocian locale  

### 1.22.0
 - added:
    - Change default timezone
- fixed:
    - FormatsInterface docs
    
### 1.21.0
 - added:
    - Arabic locale
    - Custom format on locale level

### 1.20.9
 - fixed:
    - Russian locale
 - added:
    - Russian locale tests

### 1.20.8
 - fixed:
    - Polish locale
    - Calculation of seconds
    
### 1.20.7
- fixed:
    - Russian: more relative time fixes

### 1.20.6
- fixed:
    - Russian locale relative time: day handling

### 1.20.5
- fixed:
    - missing immutable handling

### 1.20.4
- fixed:
    - Improved Polish locale (added Nominativ)

### 1.20.3
- fixed:
    - Chinese locale

### 1.20.2
- added accepted formats to README

### 1.20.1
- fixed:
    - Thai locale

### 1.20.0
- added:
    - Catalan locale
- fixed:
    - Polish locale test

### 1.19.0
- added:
    - Russian locale
- fixed:
    - Polish locale test

### 1.18.0
- added:
    - Immutable mode
- fixed:
    - Polish locale

### 1.17.0
- added:
    - Polish locale

### 1.16.0
- added:
    - Indonesian locale

### 1.15.0
- added:
    - Japanese locale

### 1.14.1
- fixed:
    - typo in Dutch locale

### 1.14.0
- added:
    - Dutch locale

### 1.13.0
- added:
    - Swedish locale

### 1.12.0
- added:
    - Danish locale

### 1.11.4
- fixed:
    - fixed starting/ending weekday for Romanian locale

### 1.11.3
- fixed:
    - adding delimiter character to Italian locale

### 1.11.1
- fixed:
    - passing back new instance for startOf/endOf for week, month, quarter

### 1.11.0
- added:
    - locale Czech

### 1.10.4
- added:
    - ```calendar``` locale receives as \Closure the following params ```function(Moment $m) {}```
    - ```relativeTime``` locale receives as \Closure the following params ```function($count, $direction, Moment $m) {}```

### 1.10.3
- added:
    - fixed passing closures to locale (calendar, relativeTime)
    - set correct german locale information

### 1.10.2
- added:
    - fixed Thai locale strings

### 1.10.1
- added:
    - locale traditional Chinese

### 1.10.0
- added:
    - locale Chinese
    - ordinal formatter receives now the ```token``` e.g. the token within ```dS``` is ```d```  

### 1.9.1
- fixed: english ordinal issue for numbers between 11 - 13

### 1.9.0
- added: locale Italian

### 1.8.1
- fixed: english ordinal issue

### 1.8.0
- added: locale Portuguese

### 1.7.2
- fixed:
    - Locale displayed wrong month name (#34)
    - Changed the order of weekdays within locale files

### 1.7.1
- added:
    - getWeekdayNameLong()
    - getWeekdayNameShort()
    - getMonthNameLong()
    - getMonthNameShort()

### 1.7.0
- added:
    - Locale: Thai

### 1.6.0
- added:
    - Locale
    - MomentFromVo:
        - getMonths()
        - getYears()
        - getRelative()
- fixed:
    - MomentFromVo:
        - getSeconds() shows now direction as well

### 1.5.3
- fixed:
    - timezone issue which occured only for unixtime dates
- other:
    - MomentFromVo:
        - direction returns now: "future" (-) / "past" (+)
        - time values are now type casted as floats

### 1.5.2
- fixed:
    - unrecognised timezone when constructing a Moment

### 1.5.1
- added:
    - getMomentsByWeekdays()
    - getWeekday()
    - getWeekOfYear()
- other:
    - escaped text

### 1.5.0
- added:
    - startOf and endOf as implemented by [moment.js](http://momentjs.com/docs/#/manipulating/start-of/)
    - get the quarter period of a given date
    - setDay()
    - getDay()
    - setMonth()
    - getMonth()
    - setYear()
    - getYear()
    - getQuarter()
    - setSecond()
    - getSecond()
    - setMinute()
    - getMinute()
    - setHour()
    - getHour()
    - added cloning()
        - create a new mutable moment based of the given instance
    - added ```getInterval()``` to ```MomentPeriodVo``` to indicate the interval of the given period
        - ```week``` = week of the year
        - ```month``` = month of the year
        - ```quarter``` = quarter of the year
    - added a static class ```MomentHelper```
        - get the period for a given quarter in a given year
    - fixed PHP's internal ordinal calculation (also in combination with moment.js formatting)
        - e.g. ```WS``` for 21th week of the year shows now correct ```21th``` etc.
    - you can now escape text by wrapping it in ```[]```
        - e.g. ```[Hello World]``` will be automatically transformed into ```\H\e\l\l\o \W\o\r\l\d```

- removed:
    - add()
    - subtract()

### 1.4.0
- added:
    - calendar format as implemented by [moment.js](http://momentjs.com/docs/#/displaying/calendar-time/)

### 1.3.0
- fixed:
    - incompatibility w/ PHP 5.3

- added:
    - Exception throw as ```MomentException```
    - Date validation on instantiation:
        - test for dates w/ format ```YYYY-mm-dd``` and ```YYYY-mm-ddTHH:ii:ss```
        - throws MomentException on invalid dates
    - addSeconds()
    - addMinutes()
    - addHours()
    - addDays()
    - addWeeks()
    - addMonths()
    - addYears()
    - subtractSeconds()
    - subtractMinutes()
    - subtractHours()
    - subtractDays()
    - subtractWeeks()
    - subtractMonths()
    - subtractYears()

- deprecated:
    - add()
    - subtract()

-------------------------------------------------

# License
Moment.php is freely distributable under the terms of the MIT license.

Copyright (c) 2017 Tino Ehrich

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

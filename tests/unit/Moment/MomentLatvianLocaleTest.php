<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentLatvianLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('lv_LV');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2017-10-20T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('Pr', 'Pirmdiena'),
            2 => array('Ot', 'Otrdiena'),
            3 => array('Tr', 'Trešdiena'),
            4 => array('Ce', 'Ceturtdiena'),
            5 => array('Pk', 'Piektdiena'),
            6 => array('Se', 'Sestdiena'),
            7 => array('Sv', 'Svētdiena'),
        );

        for ($d = 1; $d < 7; $d++) {
            // Check short names
            self::assertEquals(
                $weekdayNames[$moment->getWeekday()][0],
                $moment->getWeekdayNameShort(),
                'weekday short name failed'
            );

            // Check long names
            self::assertEquals(
                $weekdayNames[$moment->getWeekday()][1],
                $moment->getWeekdayNameLong(),
                'weekday long name failed'
            );

            $moment->addDays(); // Add one day
        }
    }

    public function testMonthFormat()
    {
        $startingDate = '2016-01-01T00:00:00+0000';

        $moment = new Moment($startingDate);

        $months = array(
            '01' => array('Janv', 'Janvāris', 'Janvārī'),
            '02' => array('Febr', 'Februāris', 'Februārī'),
            '03' => array('Mar', 'Marts', 'Martā'),
            '04' => array('Apr', 'Aprīlis', 'Aprīlī'),
            '05' => array('Maijs', 'Maijs', 'Maijā'),
            '06' => array('Jūn', 'Jūnijs', 'Jūnijā'),
            '07' => array('Jūl', 'Jūlijs', 'Jūlijā'),
            '08' => array('Aug', 'Augusts', 'Augustā'),
            '09' => array('Sept', 'Septembris', 'Septembrī'),
            '10' => array('Okt', 'Oktobris', 'Oktobrī'),
            '11' => array('Nov', 'Novembris', 'Novembrī'),
            '12' => array('Dec', 'Decembris', 'Decembrī'),
        );
        $moment->format('f');

        for ($d = 1, $dMax = \count($months); $d < $dMax; $d++) {
            // Check short names
            self::assertEquals(
                $months[$moment->getMonth()][0],
                $moment->getMonthNameShort(),
                'moths short name failed'
            );

            // Check long names months
            self::assertEquals(
                $months[$moment->getMonth()][1],
                $moment->format('f'),
                'moths long name failed'
            );

            // Check long names nominative
            self::assertEquals(
                $months[$moment->getMonth()][2],
                $moment->getMonthNameLong(),
                'moths long name in nominative failed'
            );

            $moment->addMonths();
        }
    }

    public function testDayMonthFormat001()
    {
        $string = '2015-06-14 20:46:22';
        $moment = new Moment($string, 'Europe/Riga');
        self::assertEquals('14 Jūnijā', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Riga');
        self::assertEquals('8 Martā', $moment->format('j F'));
    }

    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Riga');

        $relative = $past->from('2016-01-03 16:34:07');
        self::assertEquals('pirms 17 minūtēm', $relative->getRelative());
    }

    public function testShowRelativeCalendarDates()
    {
        $past = new Moment('2016-04-10 16:30:07');
        self::assertEquals('Pagājušā Svētdiena plkst. 16:30', $past->calendar(true, new Moment('2016-04-12')));

        $past = new Moment('2016-04-10');
        self::assertEquals('Pagājušā Svētdiena', $past->calendar(false, new Moment('2016-04-13')));

        $past = new Moment('2016-04-13');
        self::assertEquals('Trešdiena', $past->calendar(false, new Moment('2016-04-11')));

        $past = new Moment('2016-04-13');
        self::assertEquals('Vakardien', $past->calendar(false, new Moment('2016-04-14')));

        $past = new Moment('2016-04-12');
        self::assertEquals('Šodien', $past->calendar(false, new Moment('2016-04-12')));

        $past = new Moment('2016-04-13');
        self::assertEquals('Rītdien', $past->calendar(false, new Moment('2016-04-12')));

        $past = new Moment('2116-04-15');
        self::assertEquals('15.04.2116', $past->calendar(false, new Moment('2017-04-23')));
    }

    public function testFutureRelative()
    {
        $date = new Moment('2017-01-11 01:00:00');

        self::assertEquals('pēc dažām sekundēm', $date->from('2017-01-11 00:59:59')->getRelative(), 'seconds');
        self::assertEquals('pēc 2 minūtēm', $date->from('2017-01-11 00:58:00')->getRelative(), 'minutes');
        self::assertEquals('pēc stundas', $date->from('2017-01-10 23:30:59')->getRelative(), 'hours');
        self::assertEquals('pēc 2 stundām', $date->from('2017-01-10 23:00:00')->getRelative(), 'hours');
        self::assertEquals('pēc dienas', $date->from('2017-01-10 00:00:00')->getRelative(), 'days');
        self::assertEquals('pēc 10 dienām', $date->from('2017-01-01 00:00:00')->getRelative(), 'days');
        self::assertEquals('pēc mēneša', $date->from('2016-12-11 00:00:00')->getRelative(), 'month');
        self::assertEquals('pēc 3 mēnešiem', $date->from('2016-10-11 00:00:00')->getRelative(), 'month');
        self::assertEquals('pēc gada', $date->from('2016-01-11 00:00:00')->getRelative(), 'year');
        self::assertEquals('pēc 7 gadiem', $date->from('2010-01-11 00:00:00')->getRelative(), 'year');
    }

    public function testPastRelative()
    {
        $date = new Moment('2010-01-11 01:00:00');
        self::assertEquals('pirms dažām sekundēm', $date->from('2010-01-11 01:00:01')->getRelative(), 'seconds');
        self::assertEquals('pirms 10 sekundēm', $date->from('2010-01-11 01:00:10')->getRelative(), 'seconds');
        self::assertEquals('pirms 2 minūtēm', $date->from('2010-01-11 01:02:00')->getRelative(), 'minutes');
        self::assertEquals('pirms 2 stundām', $date->from('2010-01-11 03:00:00')->getRelative(), 'hours');
        self::assertEquals('pirms dienas', $date->from('2010-01-12 01:00:00')->getRelative(), 'days');
        self::assertEquals('pirms 10 dienām', $date->from('2010-01-21 01:00:00')->getRelative(), 'days');
        self::assertEquals('pirms mēneša', $date->from('2010-02-11 01:00:00')->getRelative(), 'month');
        self::assertEquals('pirms 3 mēnešiem', $date->from('2010-04-11 01:00:00')->getRelative(), 'month');
        self::assertEquals('pirms gada', $date->from('2011-01-11 01:00:00')->getRelative(), 'year');
        self::assertEquals('pirms 5 gadiem', $date->from('2015-01-11 01:00:00')->getRelative(), 'year');
    }

    public function testOrdinalFormat()
    {
        $date = new Moment('2017-01-01 01:00:00', 'Europe/Riga');
        self::assertEquals('1. Janvāris 2017', $date->format('jS f Y'));

        $date = new Moment('2017-03-12 01:00:00', 'Europe/Riga');
        self::assertEquals('12. Marts 2017', $date->format('jS f Y'));

        $date = new Moment('2017-06-23 01:00:00', 'Europe/Riga');
        self::assertEquals('23. Jūnijs 2017', $date->format('jS f Y'));

        $date = new Moment('2017-10-03 01:00:00', 'Europe/Riga');
        self::assertEquals('3. Oktobris 2017', $date->format('jS f Y'));
    }
}

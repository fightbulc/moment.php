<?php

namespace Moment;

class MomentLatvianLocaleTest extends \PHPUnit_Framework_TestCase
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
            $this->assertEquals(
                $weekdayNames[$moment->getWeekday()][0],
                $moment->getWeekdayNameShort(),
                'weekday short name failed'
            );

            // Check long names
            $this->assertEquals(
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
            '01' => array('Jan', 'Janvāris', 'Janvārī'),
            '02' => array('Feb', 'Februāris', 'Februāra'),
            '03' => array('Mar', 'Marts', 'Marta'),
            '04' => array('Apr', 'Aprīlis', 'Aprīļa'),
            '05' => array('Maijs', 'Maijs', 'Maija'),
            '06' => array('Jūnijs', 'Jūnijs', 'Jūnija'),
            '07' => array('Jūlijs', 'Jūlijs', 'Jūlija'),
            '08' => array('Aug', 'Augusts', 'Augustā'),
            '09' => array('Sept', 'Septembris', 'Septembrī'),
            '10' => array('Okt', 'Oktobris', 'Oktobra'),
            '11' => array('Nov', 'Novembris', 'Novembra'),
            '12' => array('Dec', 'Decembris', 'Decembra'),
        );
        $moment->format('f');

        for ($d = 1, $dMax = \count($months); $d < $dMax; $d++) {
            // Check short names
            $this->assertEquals(
                $months[$moment->getMonth()][0],
                $moment->getMonthNameShort(),
                'moths short name failed'
            );

            // Check long names months
            $this->assertEquals(
                $months[$moment->getMonth()][1],
                $moment->format('f'),
                'moths long name failed'
            );

            // Check long names nominative
            $this->assertEquals(
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
        $this->assertEquals('14 Jūnija', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Riga');
        $this->assertEquals('8 Marta', $moment->format('j F'));
    }

    public function testDayMonthFormat002()
    {
        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Riga');
        $this->assertEquals('3 Decembra', $moment->subtractMonths()->format('j F'));
    }

    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Riga');

        $relative = $past->from('2016-01-03 16:34:07');
        $this->assertEquals('17 minūtes atpakaļ', $relative->getRelative());
    }

    public function testLastWeekWeekend()
    {
        $past = new Moment('2016-04-10 16:30:07');
        $this->assertEquals('Pagājušā Svētdiena plkst. 16:30', $past->calendar(true, new Moment('2016-04-12')));

        $past = new Moment('2016-04-11');
        $this->assertEquals('Pagājušā Pirmdiena', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-12');
        $this->assertEquals('Šodien', $past->calendar(false, new Moment('2016-04-12')));

        $past = new Moment('2016-04-13');
        $this->assertEquals('Vakar', $past->calendar(false, new Moment('2016-04-14')));

        $past = new Moment('2016-04-14');
        $this->assertEquals('Rīt', $past->calendar(false, new Moment('2016-04-13')));

        $past = new Moment('2116-04-15');
        $this->assertEquals('15.04.2116', $past->calendar(false, new Moment('2017-04-23')));

        $past = new Moment('2016-04-16');
        $this->assertEquals('16.04.2016', $past->calendar(false, new Moment('2017-04-17')));

        $past = new Moment('2016-04-16');
        $this->assertEquals('Pagājušā Sestdiena', $past->calendar(false, new Moment('2016-04-18')));
    }

    public function testFutureRelative()
    {
        $date = new Moment('2017-01-11 01:00:00');

        $this->assertEquals('pēc dažām sekundēm', $date->from('2017-01-11 00:59:59')->getRelative(), 'seconds');
        $this->assertEquals('pēc 2 minūtes', $date->from('2017-01-11 00:58:00')->getRelative(), 'minutes');
        $this->assertEquals('pēc 2 stundas', $date->from('2017-01-10 23:00:00')->getRelative(), 'hours');
        $this->assertEquals('pēc diena', $date->from('2017-01-10 00:00:00')->getRelative(), 'days');
        $this->assertEquals('pēc 10 dienas', $date->from('2017-01-01 00:00:00')->getRelative(), 'days');
        $this->assertEquals('pēc mēnesis', $date->from('2016-12-11 00:00:00')->getRelative(), 'month');
        $this->assertEquals('pēc 3 mēneši', $date->from('2016-10-11 00:00:00')->getRelative(), 'month');
        $this->assertEquals('pēc gada', $date->from('2016-01-11 00:00:00')->getRelative(), 'year');
        $this->assertEquals('pēc 7 gadiem', $date->from('2010-01-11 00:00:00')->getRelative(), 'year');
    }

    public function testOrdinalFormat()
    {
        $date = new Moment('2017-01-01 01:00:00', 'Europe/Riga');
        $this->assertEquals('1. Janvāris 2017', $date->format('jS f Y'));

        $date = new Moment('2017-01-12 01:00:00', 'Europe/Riga');
        $this->assertEquals('12. Janvāris 2017', $date->format('jS f Y'));

        $date = new Moment('2017-01-23 01:00:00', 'Europe/Riga');
        $this->assertEquals('23. Janvāris 2017', $date->format('jS f Y'));

        $date = new Moment('2017-01-25 01:00:00', 'Europe/Riga');
        $this->assertEquals('25. Janvāris 2017', $date->format('jS f Y'));
    }
}
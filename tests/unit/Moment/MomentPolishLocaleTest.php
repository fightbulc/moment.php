<?php

namespace Moment;

class MomentPolishLocaleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Moment::setLocale('pl_PL');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2016-01-29T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('pon.', 'poniedziałek'),
            2 => array('wt.', 'wtorek'),
            3 => array('śr.', 'środa'),
            4 => array('czw.', 'czwartek'),
            5 => array('pt.', 'piątek'),
            6 => array('sob.', 'sobota'),
            7 => array('niedz.', 'niedziela'),
        );

        for ($d = 1; $d < 7; $d++)
        {
            $this->assertEquals($weekdayNames[$moment->getWeekday()][0], $moment->getWeekdayNameShort(), 'weekday short name failed');
            $this->assertEquals($weekdayNames[$moment->getWeekday()][1], $moment->getWeekdayNameLong(), 'weekday long name failed');

            $moment->addDays(1);
        }
    }
/*
    public function testMonthNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $monthNames = array(
            1  => array('Jan', 'Januar'),
            2  => array('Feb', 'Februar'),
            3  => array('Mär', 'März'),
            4  => array('Apr', 'April'),
            5  => array('Mai', 'Mai'),
            6  => array('Jun', 'Juni'),
            7  => array('Jul', 'Juli'),
            8  => array('Aug', 'August'),
            9  => array('Sep', 'September'),
            10 => array('Okt', 'Oktober'),
            11 => array('Nov', 'November'),
            12 => array('Dez', 'Dezember'),
        );

        for ($d = 1; $d < 12; $d++)
        {
            $this->assertEquals($monthNames[$moment->format('n')][0], $moment->getMonthNameShort(), 'month short name failed');
            $this->assertEquals($monthNames[$moment->format('n')][1], $moment->getMonthNameLong(), 'month long name failed');

            $moment->addMonths(1);
        }
    }*/

    public function testHirbodIssueLocaleDate001()
    {
        // @see: https://github.com/fightbulc/moment.php/issues/50

        $string = '2015-06-14 20:46:22';
        $moment = new Moment($string, 'Europe/Berlin');
        $this->assertEquals('14 czerwca', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Berlin');
        $this->assertEquals('8 marca', $moment->format('j F'));
    }

    public function testHirbodIssueLocaleDate002()
    {
        // @see: https://github.com/fightbulc/moment.php/issues/61

        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Berlin');
        $this->assertEquals('3 grudnia', $moment->subtractMonths(1)->format('j F'));
    }

    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Berlin');

        $relative = $past->from('2016-01-03 16:34:07');
        $this->assertEquals('17 minut temu', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:40:07');
        $this->assertEquals('23 minuty temu', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:30:07');
        $this->assertEquals('13 minut temu', $relative->getRelative());
    }
}
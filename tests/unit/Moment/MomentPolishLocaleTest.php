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

    public function testDayMonthFormat001()
    {
        $string = '2015-06-14 20:46:22';
        $moment = new Moment($string, 'Europe/Berlin');
        $this->assertEquals('14 czerwca', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Berlin');
        $this->assertEquals('8 marca', $moment->format('j F'));
    }

    public function testDayMonthFormat002()
    {
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
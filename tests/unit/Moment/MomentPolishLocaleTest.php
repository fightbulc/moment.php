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

        for ($d = 1; $d < 7; $d++) {
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

    public function testMonthFormatFN()
    {
        $startingDate = '2016-01-01T00:00:00+0000';

        $moment = new Moment($startingDate);

        $monthsNominative = array(
            1 => 'styczeń',
            2 => 'luty',
            3 => 'marzec',
            4 => 'kwiecień',
            5 => 'maj',
            6 => 'czerwiec',
            7 => 'lipiec',
            8 => 'sierpień',
            9 => 'wrzesień',
            10 => 'październik',
            11 => 'listopad',
            12 => 'grudzień'
        );

        for ($d = 1; $d < count($monthsNominative); $d++) {
            $this->assertEquals($monthsNominative[$moment->format('n')], $moment->format('f'), 'month nominative failed');

            $moment->addMonths(1);
        }
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

    public function testLastWeekWeekend()
    {
        $past = new Moment('2016-04-10');
        $this->assertEquals('ostatnia niedziela', $past->calendar(false, new Moment('2016-04-12')));

        $past = new Moment('2016-04-11');
        $this->assertEquals('ostatni poniedziałek', $past->calendar(false, new Moment('2016-04-17')));
        
        $past = new Moment('2016-04-12');
        $this->assertEquals('ostatni wtorek', $past->calendar(false, new Moment('2016-04-17')));
        
        $past = new Moment('2016-04-13');
        $this->assertEquals('ostatnia środa', $past->calendar(false, new Moment('2016-04-17')));
        
        $past = new Moment('2016-04-14');
        $this->assertEquals('ostatni czwartek', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-15');
        $this->assertEquals('ostatni piątek', $past->calendar(false, new Moment('2016-04-17')));
        
        $past = new Moment('2016-04-16');
        $this->assertEquals('wczoraj', $past->calendar(false, new Moment('2016-04-17')));
        
        $past = new Moment('2016-04-16');
        $this->assertEquals('ostatnia sobota', $past->calendar(false, new Moment('2016-04-18')));
    }
}
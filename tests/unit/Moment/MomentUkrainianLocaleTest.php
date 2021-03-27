<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentUkrainianLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('uk_UA');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2016-01-29T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('пн', 'понеділок'),
            2 => array('вт', 'вівторок'),
            3 => array('ср', 'середа'),
            4 => array('чт', 'четвер'),
            5 => array('пт', 'п’ятниця'),
            6 => array('сб', 'субота'),
            7 => array('нд', 'неділя'),
        );

        for ($d = 1; $d < 7; $d++) {
            self::assertEquals($weekdayNames[$moment->getWeekday()][0], $moment->getWeekdayNameShort(), 'weekday short name failed');
            self::assertEquals($weekdayNames[$moment->getWeekday()][1], $moment->getWeekdayNameLong(), 'weekday long name failed');

            $moment->addDays(1);
        }
    }

    public function testDayMonthFormat001()
    {
        $string = '2015-06-14 20:46:22';
        $moment = new Moment($string, 'Europe/Kiev');
        self::assertEquals('14 червня', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Kiev');
        self::assertEquals('8 березня', $moment->format('j F'));
    }

    public function testDayMonthFormat002()
    {
        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Kiev');
        self::assertEquals('3 грудня', $moment->subtractMonths(1)->format('j F'));
    }

    public function testMonthFormatFN()
    {
        $startingDate = '2016-01-01T00:00:00+0000';

        $moment = new Moment($startingDate);

        $monthsNominative = array(
            1 => 'січень',
            2 => 'лютий',
            3 => 'березень',
            4 => 'квітень',
            5 => 'травень',
            6 => 'червень',
            7 => 'липень',
            8 => 'серпень',
            9 => 'вересень',
            10 => 'жовтень',
            11 => 'листопад',
            12 => 'грудень'
        );

        for ($d = 1; $d < count($monthsNominative); $d++) {
            self::assertEquals($monthsNominative[$moment->format('n')], $moment->format('f'), 'month nominative failed');

            $moment->addMonths(1);
        }
    }


    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Kiev');

        $relative = $past->from('2016-01-03 16:34:07');
        self::assertEquals('17 хвилин тому', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:40:07');
        self::assertEquals('23 хвилини тому', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:30:07');
        self::assertEquals('13 хвилин тому', $relative->getRelative());
    }

    public function testLastWeekWeekend()
    {
        $past = new Moment('2016-04-10 16:30:07');
        self::assertEquals('неділя о 16:30', $past->calendar(true, new Moment('2016-04-12')));

        $past = new Moment('2016-09-24 11:30:07');
        self::assertEquals('субота об 11:30', $past->calendar(true, new Moment('2016-09-26')));

        $past = new Moment('2016-04-11');
        self::assertEquals('понеділок', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-12');
        self::assertEquals('вівторок', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-13');
        self::assertEquals('середа', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-14');
        self::assertEquals('четвер', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-15');
        self::assertEquals('п’ятниця', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        self::assertEquals('вчора', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        self::assertEquals('субота', $past->calendar(false, new Moment('2016-04-18')));
    }
}

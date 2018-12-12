<?php

// locale: British English (en_GB)
// author: https://github.com/blacknell

namespace Moment;

use Moment\CustomFormats\MomentJs;
use PHPUnit\Framework\TestCase;

class MomentBritishEnglishLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('en_GB');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('Mon', 'Monday'),
            2 => array('Tue', 'Tuesday'),
            3 => array('Wed', 'Wednesday'),
            4 => array('Thu', 'Thursday'),
            5 => array('Fri', 'Friday'),
            6 => array('Sat', 'Saturday'),
            7 => array('Sun', 'Sunday'),
        );

        for ($d = 1; $d < 7; $d++) {
            self::assertEquals($weekdayNames[$moment->getWeekday()][0], $moment->getWeekdayNameShort(), 'weekday short name failed');
            self::assertEquals($weekdayNames[$moment->getWeekday()][1], $moment->getWeekdayNameLong(), 'weekday long name failed');

            $moment->addDays(1);
        }
    }

    public function testMonthNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $monthNames = array(
            1 => array('Jan', 'January'),
            2 => array('Feb', 'February'),
            3 => array('Mar', 'March'),
            4 => array('Apr', 'April'),
            5 => array('May', 'May'),
            6 => array('Jun', 'June'),
            7 => array('Jul', 'July'),
            8 => array('Aug', 'August'),
            9 => array('Sep', 'September'),
            10 => array('Oct', 'October'),
            11 => array('Nov', 'November'),
            12 => array('Dec', 'December'),
        );

        for ($d = 1; $d < 12; $d++) {
            self::assertEquals($monthNames[$moment->format('n')][0], $moment->getMonthNameShort(), 'month short name failed');
            self::assertEquals($monthNames[$moment->format('n')][1], $moment->getMonthNameLong(), 'month long name failed');

            $moment->addMonths(1);
        }
    }

    public function testFormat()
    {
        $a = array(
            array('l, d F Y, G:i:s', 'Saturday, 12 June 2010, 22:00:00'),
            array('D, gA', 'Sat, 10PM'),
            array('n m F M', '6 06 June Jun'),
            array('Y y', '2010 10'),
            array('j d', '12 12'),
            array('[the] z [day of the year]', 'the 162 day of the year')
        );
        $b = new Moment('2010-06-12 22:00:00');
        for ($i = 0; $i < count($a); $i++) {
            self::assertEquals($a[$i][1], $b->format($a[$i][0]));
        }
    }

    public function testCustomLocaleFormat()
    {
        $a = array(
            array('LT', '22:00',),
            array('LTS', '22:00:00'),
            array('L', '12/06/2010'),
            array('l', '12/6/2010'),
            array('LL', '12 June 2010'),
            array('ll', '12 Jun 2010'),
            array('LLL', '12 June 2010 22:00'),
            array('lll', '12 Jun 2010 22:00'),
            array('LLLL', 'Saturday, 12 June June 2010 22:00'),
            array('llll', 'Sat, 12 Jun 2010 22:00')
        );
        $b = new Moment('2010-06-12 22:00:00');
        for ($i = 0; $i < count($a); $i++) {
            self::assertEquals($a[$i][1], $b->format($a[$i][0], new MomentJs()));
        }
    }

    public function testOrdinalsFormat()
    {
        $moment = new Moment('2010-06-02T00:00:00+0000');
        self::assertEquals('2nd', $moment->format('jS'));
        $moment = new Moment('2010-06-12T00:00:00+0000');
        self::assertEquals('12th', $moment->format('jS'));
    }

	public function testRelative()
	{
		Moment::setLocale('en_GB');

		$beginningMoment = new Moment('2010-06-12 00:00:00', 'Europe/London');

		$a = array(
			array(new Moment('2010-06-12 00:00:01', 'Europe/London'), 'in a few seconds', 'a few seconds ago', '0s - 3s'),
			array(new Moment('2010-06-12 00:00:07', 'Europe/London'), 'in 7 seconds', '7 seconds ago', '4s - 59s'),
			array(new Moment('2010-06-12 00:01:10', 'Europe/London'), 'in a minute', 'a minute ago', '60s - 89s'),
			array(new Moment('2010-06-12 00:05:45', 'Europe/London'), 'in 6 minutes', '6 minutes ago', '90s - 45m'),
			array(new Moment('2010-06-12 00:45:45', 'Europe/London'), 'in an hour', 'an hour ago', '45m - 89m'),
			array(new Moment('2010-06-12 08:00:45', 'Europe/London'), 'in 8 hours', '8 hours ago', '90m - 22h'),
			array(new Moment('2010-06-12 23:00:45', 'Europe/London'), 'in a day', 'a day ago', '22h - 35h'),
			array(new Moment('2010-06-13 15:00:45', 'Europe/London'), 'in 2 days', '2 days ago', '36h - 25d'),
			array(new Moment('2010-07-12 00:00:45', 'Europe/London'), 'in a month', 'a month ago', '25d - 44d'),
			array(new Moment('2010-08-12 00:00:45', 'Europe/London'), 'in 2 months', '2 months ago', '45ds - 344d'),
			array(new Moment('2011-06-12 00:00:45', 'Europe/London'), 'in a year', 'a year ago', '345d - 547d'),
			array(new Moment('2013-06-12 00:00:45', 'Europe/London'), 'in 3 years', '3 years ago', '547d -'),
		);

		for ($i = 0; $i < count($a); $i++) {
			$endMoment = $a[$i][0];
			self::assertEquals($a[$i][1], $endMoment->from($beginningMoment)->getRelative(), $a[$i][3]);
			self::assertEquals($a[$i][2], $beginningMoment->from($endMoment)->getRelative(), $a[$i][3]);
		}

	}

}

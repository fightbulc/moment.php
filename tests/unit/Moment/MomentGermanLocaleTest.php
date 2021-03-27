<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentGermanLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('de_DE');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('Mo', 'Montag'),
            2 => array('Di', 'Dienstag'),
            3 => array('Mi', 'Mittwoch'),
            4 => array('Do', 'Donnerstag'),
            5 => array('Fr', 'Freitag'),
            6 => array('Sa', 'Samstag'),
            7 => array('So', 'Sonntag'),
        );

        for ($d = 1; $d < 7; $d++)
        {
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
            self::assertEquals($monthNames[$moment->format('n')][0], $moment->getMonthNameShort(), 'month short name failed');
            self::assertEquals($monthNames[$moment->format('n')][1], $moment->getMonthNameLong(), 'month long name failed');

            $moment->addMonths(1);
        }
    }

    public function testHirbodIssueLocaleDate001()
    {
        // @see: https://github.com/fightbulc/moment.php/issues/50

        $string = '2015-06-14 20:46:22';
        $moment = new Moment($string, 'Europe/Berlin');
        self::assertEquals('14. Juni', $moment->format('d. F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Berlin');
        self::assertEquals('08. März', $moment->format('d. F'));
    }

    public function testHirbodIssueLocaleDate002()
    {
        // @see: https://github.com/fightbulc/moment.php/issues/61

        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Berlin');
        self::assertEquals('03. Dezember', $moment->subtractMonths(1)->format('d. F'));
    }

    public function testMonthsNominativeFallback()
    {
        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Berlin');
        self::assertEquals('Januar 2016', $moment->format('f Y'));
    }
}

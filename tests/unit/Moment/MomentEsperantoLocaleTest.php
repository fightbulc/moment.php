<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentEsperantoLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('eo');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('lun', 'lundo'),
            2 => array('mard', 'mardo'),
            3 => array('merk', 'merkredo'),
            4 => array('ĵaŭ', 'ĵaŭdo'),
            5 => array('ven', 'vendredo'),
            6 => array('sab', 'sabato'),
            7 => array('dim', 'dimanĉo'),
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
            1  => array('jan', 'januaro'),
            2  => array('feb', 'februaro'),
            3  => array('mart', 'marto'),
            4  => array('apr', 'aprilo'),
            5  => array('maj', 'majo'),
            6  => array('jun', 'junio'),
            7  => array('jul', 'julio'),
            8  => array('aŭg', 'aŭgusto'),
            9  => array('sept', 'septembro'),
            10 => array('okt', 'oktobro'),
            11 => array('nov', 'novembro'),
            12 => array('dec', 'decembro'),
        );

        for ($d = 1; $d < 12; $d++) {
            self::assertEquals($monthNames[$moment->format('n')][0], $moment->getMonthNameShort(), 'month short name failed');
            self::assertEquals($monthNames[$moment->format('n')][1], $moment->getMonthNameLong(), 'month long name failed');

            $moment->addMonths(1);
        }
    }

    public function testFormat()
    {
        $targetDate = new Moment('2010-06-09 15:25:50');
        $formats = array(
            array('l, F d Y, g:i:s a',                  'merkredo, junio 09 2010, 3:25:50 pm'),
            array('D, gA',                              'merk, 3PM'),
            array('n m F M',                            '6 06 junio jun'),
            array('Y y',                                '2010 10'),
            array('j d',                                '9 09'),
            array('[the] z [day of the year]',          'the 159 day of the year'),
            array('l[n], [la] j[-an de] F, Y G:i',      'merkredon, la 9-an de junio, 2010 15:25')
        );
        for ($i = 0; $i < count($formats); $i++) {
            $format = $formats[$i];
            self::assertEquals($format[1], $targetDate->format($format[0]));
        }
    }

    public function _testRelative()
    {
        $beginningMoment = new Moment('2015-06-14 20:46:22', 'Europe/Berlin');
        $endMoment = new Moment('2015-06-14 20:48:32', 'Europe/Berlin');
        self::assertEquals('post 2 minutoj', $endMoment->from($beginningMoment)->getRelative());
        self::assertEquals('antaŭ 2 minutoj', $beginningMoment->from($endMoment)->getRelative());
    }

    public function testRelative()
    {
        $tz = 'Europe/Berlin';
        $beginningMoment = new Moment('2010-06-12 00:00:00', $tz);
        $a = array(
            array(new Moment('2010-06-12 00:00:01', $tz), 'post kelkaj sekundoj', 'antaŭ kelkaj sekundoj', '0s - 3s'),
            array(new Moment('2010-06-12 00:00:07', $tz), 'post 7 sekundoj', 'antaŭ 7 sekundoj', '4s - 59s'),
            array(new Moment('2010-06-12 00:01:10', $tz), 'post unu minuto', 'antaŭ unu minuto', '60s - 89s'),
            array(new Moment('2010-06-12 00:05:45', $tz), 'post 6 minutoj', 'antaŭ 6 minutoj', '90s - 45m'),
            array(new Moment('2010-06-12 00:45:45', $tz), 'post unu horo', 'antaŭ unu horo', '45m - 89m'),
            array(new Moment('2010-06-12 08:00:45', $tz), 'post 8 horoj', 'antaŭ 8 horoj', '90m - 22h'),
            array(new Moment('2010-06-12 23:00:45', $tz), 'post unu tago', 'antaŭ unu tago', '22h - 35h'),
            array(new Moment('2010-06-13 15:00:45', $tz), 'post 2 tagoj', 'antaŭ 2 tagoj', '36h - 25d'),
            array(new Moment('2010-07-12 00:00:45', $tz), 'post unu monato', 'antaŭ unu monato', '25d - 44d'),
            array(new Moment('2010-08-12 00:00:45', $tz), 'post 2 monatoj', 'antaŭ 2 monatoj', '45ds - 344d'),
            array(new Moment('2011-06-12 00:00:45', $tz), 'post unu jaro', 'antaŭ unu jaro', '345d - 547d'),
            array(new Moment('2013-06-12 00:00:45', $tz), 'post 3 jaroj', 'antaŭ 3 jaroj', '547d -'),
        );

        for ($i = 0; $i < count($a); $i++) {
            $endMoment = $a[$i][0];
            self::assertEquals($a[$i][1], $endMoment->from($beginningMoment)->getRelative(), $a[$i][3]);
            self::assertEquals($a[$i][2], $beginningMoment->from($endMoment)->getRelative(), $a[$i][3]);
        }
    }
}

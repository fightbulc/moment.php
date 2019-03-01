<?php
/**
 * Turkish (tr-TR) language support
 * @author Engin Dumlu <engindumlu@gmail.com>
 * @github https://github.com/roadrunner
 */

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentTurkishLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('tr_TR');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('Pts', 'Pazartesi'),
            2 => array('Sal', 'Salı'),
            3 => array('Çar', 'Çarşamba'),
            4 => array('Per', 'Perşembe'),
            5 => array('Cum', 'Cuma'),
            6 => array('Cts', 'Cumartesi'),
            7 => array('Paz', 'Pazar'),
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
            1  => array('Oca', 'Ocak'),
            2  => array('Şub', 'Şubat'),
            3  => array('Mar', 'Mart'),
            4  => array('Nis', 'Nisan'),
            5  => array('May', 'Mayıs'),
            6  => array('Haz', 'Haziran'),
            7  => array('Tem', 'Temmuz'),
            8  => array('Ağu', 'Ağustos'),
            9  => array('Eyl', 'Eylül'),
            10 => array('Eki', 'Ekim'),
            11 => array('Kas', 'Kasım'),
            12 => array('Ara', 'Aralık'),
        );

        for ($d = 1; $d <= 12; $d++) {
            self::assertEquals($monthNames[$moment->format('n')][0], $moment->getMonthNameShort(), 'month short name failed');
            self::assertEquals($monthNames[$moment->format('n')][1], $moment->getMonthNameLong(), 'month long name failed');

            $moment->addMonths(1);
        }
    }

    public function testFormat()
    {
        $a = array(
            array('l, F d Y, g:i:s a',                  'Pazar, Şubat 14 2010, 3:25:50 pm'),
            array('D, gA',                              'Paz, 3PM'),
            array('n m F M',                            '2 02 Şubat Şub'),
            array('Y y',                                '2010 10'),
            array('j d',                                '14 14'),
            array('[the] z [day of the year]',          'the 44 day of the year')
        );
        $b = new Moment('2010-02-14 15:25:50');
        for ($i = 0; $i < count($a); $i++) {
            self::assertEquals($a[$i][1], $b->format($a[$i][0]));
        }
    }

    public function testRelative()
    {
        $beginningMoment = new Moment('2015-06-14 20:46:22', 'Europe/Istanbul');
        $endMoment = new Moment('2015-06-14 20:48:32', 'Europe/Istanbul');
        self::assertEquals('2 dakika sonra', $endMoment->from($beginningMoment)->getRelative());
        self::assertEquals('2 dakika önce', $beginningMoment->from($endMoment)->getRelative());
    }

    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Kiev');

        $relative = $past->from('2016-01-03 16:34:07');
        self::assertEquals('17 dakika önce', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:40:07');
        self::assertEquals('23 dakika önce', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:30:07');
        self::assertEquals('13 dakika önce', $relative->getRelative());
    }

    public function testLastWeekWeekend()
    {
        $past = new Moment('2016-04-10 16:30:07');
        self::assertEquals('Geçen hafta Pazar 16:30', $past->calendar(true, new Moment('2016-04-12')));

        $past = new Moment('2016-09-24 11:30:07');
        self::assertEquals('Geçen hafta Cumartesi 11:30', $past->calendar(true, new Moment('2016-09-26')));

        $past = new Moment('2016-04-11');
        self::assertEquals('Geçen hafta Pazartesi', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-12');
        self::assertEquals('Geçen hafta Salı', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-13');
        self::assertEquals('Geçen hafta Çarşamba', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-14');
        self::assertEquals('Geçen hafta Perşembe', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-15');
        self::assertEquals('Geçen hafta Cuma', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        self::assertEquals('Dün', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        self::assertEquals('Geçen hafta Cumartesi', $past->calendar(false, new Moment('2016-04-18')));
    }
}

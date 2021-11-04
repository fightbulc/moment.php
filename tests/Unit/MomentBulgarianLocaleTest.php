<?php

namespace Moment\Test\Unit;

use Moment\Moment;
use PHPUnit\Framework;

final class MomentBulgarianLocaleTest extends Framework\TestCase
{
    protected function setUp(): void
    {
        Moment::setLocale('bg_BG');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('пон', 'понеделник'),
            2 => array('вто', 'вторник'),
            3 => array('сря', 'сряда'),
            4 => array('чет', 'четвъртък'),
            5 => array('пет', 'петък'),
            6 => array('съб', 'събота'),
            7 => array('нед', 'неделя'),
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
            1  => array('яну', 'януари'),
            2  => array('фев', 'февруари'),
            3  => array('мар', 'март'),
            4  => array('апр', 'април'),
            5  => array('май', 'май'),
            6  => array('юни', 'юни'),
            7  => array('юли', 'юли'),
            8  => array('авг', 'август'),
            9  => array('сеп', 'септември'),
            10 => array('окт', 'октомври'),
            11 => array('ное', 'ноември'),
            12 => array('дек', 'декември'),
        );

        for ($d = 1; $d < 12; $d++)
        {
            self::assertEquals($monthNames[$moment->format('n')][0], $moment->getMonthNameShort(), 'month short name failed');
            self::assertEquals($monthNames[$moment->format('n')][1], $moment->getMonthNameLong(), 'month long name failed');

            $moment->addMonths(1);
        }
    }

    public function testFormat()
    {
        $values = array(
            array('l, F d Y, g:i:s a',                  'неделя, февруари 14 2010, 3:25:50 pm'),
            array('D, gA',                              'нед, 3PM'),
            array('n m F M',                            '2 02 февруари фев'),
            array('Y y',                                '2010 10'),
            array('j d',                                '14 14'),
            array('[the] z [day of the year]',          'the 44 day of the year')
        );

        $moment = new Moment('2010-02-14 15:25:50');

        for ($i = 0; $i < count($values); $i++) {
            self::assertEquals($values[$i][1], $moment->format($values[$i][0]));
        }
    }

    public function testRelative()
    {
        $begin = new Moment('2015-06-14 20:46:22', 'Europe/Berlin');

        $end = new Moment('2015-06-14 20:48:32', 'Europe/Berlin');

        self::assertEquals('след 2 минути', $end->from($begin)->getRelative());
        self::assertEquals('преди 2 минути', $begin->from($end)->getRelative());
    }
}

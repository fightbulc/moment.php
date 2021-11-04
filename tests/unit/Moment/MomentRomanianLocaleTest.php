<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentRomanianLocaleTest extends TestCase
{
    public function setUp(): void
    {
        Moment::setLocale('ro_RO');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('Lun', 'luni'),
            2 => array('Mar', 'marți'),
            3 => array('Mie', 'miercuri'),
            4 => array('Joi', 'joi'),
            5 => array('Vin', 'vineri'),
            6 => array('Sâm', 'sâmbătă'),
            7 => array('Dum', 'duminică'),
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
            1  => array('ian.', 'ianuarie'),
            2  => array('febr.', 'februarie'),
            3  => array('mart.', 'martie'),
            4  => array('apr.', 'aprilie'),
            5  => array('mai', 'mai'),
            6  => array('iun.', 'iunie'),
            7  => array('iul.', 'iulie'),
            8  => array('aug.', 'august'),
            9  => array('sept.', 'septembrie'),
            10 => array('oct.', 'octombrie'),
            11 => array('nov.', 'noiembrie'),
            12 => array('dec.', 'decembrie'),
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
        $a = array(
            array('l, F d Y, g:i:s a',                  'duminică, februarie 14 2010, 3:25:50 pm'),
            array('D, gA',                              'Dum, 3PM'),
            array('n m F M',                            '2 02 februarie febr.'),
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
        $beginningMoment = new Moment('2015-06-14 20:46:22', 'Europe/Berlin');
        $endMoment = new Moment('2015-06-14 20:48:32', 'Europe/Berlin');
        self::assertEquals('peste 2 minute', $endMoment->from($beginningMoment)->getRelative());
        self::assertEquals('În urmă cu 2 minute', $beginningMoment->from($endMoment)->getRelative());
    }
}

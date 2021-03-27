<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentFrenchLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('fr_FR');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2015-01-04T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('lun.', 'lundi'),
            2 => array('mar.', 'mardi'),
            3 => array('mer.', 'mercredi'),
            4 => array('jeu.', 'jeudi'),
            5 => array('ven.', 'vendredi'),
            6 => array('sam.', 'samedi'),
            7 => array('dim.', 'dimanche'),
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
            1  => array('janv.', 'janvier'),
            2  => array('févr.', 'février'),
            3  => array('mars', 'mars'),
            4  => array('avr.', 'avril'),
            5  => array('mai', 'mai'),
            6  => array('juin', 'juin'),
            7  => array('juil.', 'juillet'),
            8  => array('août', 'août'),
            9  => array('sept.', 'septembre'),
            10 => array('oct.', 'octobre'),
            11 => array('nov.', 'novembre'),
            12 => array('déc.', 'décembre'),
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
            array('l, F d Y, g:i:s a',                  'dimanche, février 14 2010, 3:25:50 pm'),
            array('D, gA',                              'dim., 3PM'),
            array('n m F M',                            '2 02 février févr.'),
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
        self::assertEquals('dans 2 minutes', $endMoment->from($beginningMoment)->getRelative());
        self::assertEquals('il y a 2 minutes', $beginningMoment->from($endMoment)->getRelative());
    }
}

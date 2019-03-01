<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentRussianLocaleTest extends TestCase
{
    public function setUp()
    {
        Moment::setLocale('ru_RU');
    }

    public function testWeekdayNames()
    {
        $startingDate = '2016-01-29T00:00:00+0000';

        $moment = new Moment($startingDate);

        $weekdayNames = array(
            1 => array('пн', 'понедельник'),
            2 => array('вт', 'вторник'),
            3 => array('ср', 'среда'),
            4 => array('чт', 'четверг'),
            5 => array('пт', 'пятница'),
            6 => array('сб', 'суббота'),
            7 => array('вс', 'воскресенье'),
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
        $moment = new Moment($string, 'Europe/Moscow');
        self::assertEquals('14 июня', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Moscow');
        self::assertEquals('8 марта', $moment->format('j F'));
    }

    public function testDayMonthFormat002()
    {
        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Moscow');
        self::assertEquals('3 декабря', $moment->subtractMonths(1)->format('j F'));
    }

    public function testMonthFormatFN()
    {
        $startingDate = '2016-01-01T00:00:00+0000';

        $moment = new Moment($startingDate);

        $monthsNominative = array(
            1 => 'январь',
            2 => 'февраль',
            3 => 'март',
            4 => 'апрель',
            5 => 'май',
            6 => 'июнь',
            7 => 'июль',
            8 => 'август',
            9 => 'сентябрь',
            10 => 'октябрь',
            11 => 'ноябрь',
            12 => 'декабрь'
        );

        for ($d = 1; $d < count($monthsNominative); $d++) {
            self::assertEquals($monthsNominative[$moment->format('n')], $moment->format('f'), 'month nominative failed');

            $moment->addMonths(1);
        }
    }


    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Moscow');

        $relative = $past->from('2016-01-03 16:34:07');
        self::assertEquals('17 минут назад', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:40:07');
        self::assertEquals('23 минуты назад', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:30:07');
        self::assertEquals('13 минут назад', $relative->getRelative());
    }

    public function testSeconds()
    {
       $past = new Moment('2017-08-30 20:49:30', 'Europe/Samara');

       $relative = $past->from('2017-08-30 20:49:31');
       self::assertEquals('несколько секунд назад', $relative->getRelative());

       $relative = $past->from('2017-08-30 20:49:34');
       self::assertEquals('4 секунды назад', $relative->getRelative());

       $relative = $past->from('2017-08-30 20:49:35');
       self::assertEquals('5 секунд назад', $relative->getRelative());
       }

    public function testLastWeekWeekend()
    {
        $past = new Moment('2016-04-10 16:30:07');
        self::assertEquals('воскресенье в 16:30', $past->calendar(true, new Moment('2016-04-12')));

        $past = new Moment('2016-04-11');
        self::assertEquals('понедельник', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-12');
        self::assertEquals('вторник', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-13');
        self::assertEquals('среда', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-14');
        self::assertEquals('четверг', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-15');
        self::assertEquals('пятница', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        self::assertEquals('вчера', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        self::assertEquals('суббота', $past->calendar(false, new Moment('2016-04-18')));
    }

    public function testFutureRelative()
    {
        $date = new Moment('2017-01-11 01:00:00');

	    self::assertEquals('через несколько секунд', $date->from('2017-01-11 00:59:59')->getRelative(), 'seconds');
	    self::assertEquals('через 30 секунд', $date->from('2017-01-11 00:59:30')->getRelative(), 'seconds');
        self::assertEquals('через 2 минуты', $date->from('2017-01-11 00:58:00')->getRelative(), 'minutes');
        self::assertEquals('через 2 часа', $date->from('2017-01-10 23:00:00')->getRelative(), 'hours');
        self::assertEquals('через день', $date->from('2017-01-10 00:00:00')->getRelative(), 'days');
        self::assertEquals('через месяц', $date->from('2016-12-11 00:00:00')->getRelative(), 'month');
        self::assertEquals('через год', $date->from('2016-01-11 00:00:00')->getRelative(), 'year');
    }


    public function testOrdinalFormat()
    {
        $date = new Moment('2017-01-01 01:00:00');
        self::assertEquals('1е января 2017', $date->format('jS F Y'));

        $date = new Moment('2017-01-12 01:00:00');
        self::assertEquals('12е января 2017', $date->format('jS F Y'));

        $date = new Moment('2017-01-23 01:00:00');
        self::assertEquals('23е января 2017', $date->format('jS F Y'));

        $date = new Moment('2017-01-25 01:00:00');
        self::assertEquals('25е января 2017', $date->format('jS F Y'));
    }
}

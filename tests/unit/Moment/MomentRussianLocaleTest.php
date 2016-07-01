<?php

namespace Moment;

class MomentRussianLocaleTest extends \PHPUnit_Framework_TestCase
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
            $this->assertEquals($weekdayNames[$moment->getWeekday()][0], $moment->getWeekdayNameShort(), 'weekday short name failed');
            $this->assertEquals($weekdayNames[$moment->getWeekday()][1], $moment->getWeekdayNameLong(), 'weekday long name failed');

            $moment->addDays(1);
        }
    }

    public function testDayMonthFormat001()
    {
        $string = '2015-06-14 20:46:22';
        $moment = new Moment($string, 'Europe/Moscow');
        $this->assertEquals('14 июня', $moment->format('j F'));

        $string = '2015-03-08T15:14:53-0500';
        $moment = new Moment($string, 'Europe/Moscow');
        $this->assertEquals('8 марта', $moment->format('j F'));
    }

    public function testDayMonthFormat002()
    {
        $moment = new Moment('2016-01-03 16:17:07', 'Europe/Moscow');
        $this->assertEquals('3 декабря', $moment->subtractMonths(1)->format('j F'));
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
            $this->assertEquals($monthsNominative[$moment->format('n')], $moment->format('f'), 'month nominative failed');

            $moment->addMonths(1);
        }
    }


    public function testMinutes()
    {
        $past = new Moment('2016-01-03 16:17:07', 'Europe/Moscow');

        $relative = $past->from('2016-01-03 16:34:07');
        $this->assertEquals('17 минут назад', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:40:07');
        $this->assertEquals('23 минуты назад', $relative->getRelative());

        $relative = $past->from('2016-01-03 16:30:07');
        $this->assertEquals('13 минут назад', $relative->getRelative());
    }

    public function testLastWeekWeekend()
    {
        $past = new Moment('2016-04-10 16:30:07');
        $this->assertEquals('воскресенье в 16:30', $past->calendar(true, new Moment('2016-04-12')));

        $past = new Moment('2016-04-11');
        $this->assertEquals('понедельник', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-12');
        $this->assertEquals('вторник', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-13');
        $this->assertEquals('среда', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-14');
        $this->assertEquals('четверг', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-15');
        $this->assertEquals('пятница', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        $this->assertEquals('вчера', $past->calendar(false, new Moment('2016-04-17')));

        $past = new Moment('2016-04-16');
        $this->assertEquals('суббота', $past->calendar(false, new Moment('2016-04-18')));
    }
}

<?php

namespace Moment;

use PHPUnit\Framework\TestCase;

class MomentTest extends TestCase
{
    public function testMoment()
    {
        $data = '1923-12-31 12:30:00';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.000';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.123';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.123+02:00';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0200', $m->format());

        $data = '1923-12-31T12:30:00.123+0200';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0200', $m->format());

        $data = '1923-12-31T12:30:00.123Z';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.123Europe/Warsaw';
        $m = new Moment($data);
        self::assertEquals('1923-12-31T12:30:00+0100', $m->format());

        $data = '1923-12-31T12:30:00.123Europe/Warsaw';
        $m = new Moment($data, 'UTC');
        self::assertEquals('1923-12-31T12:30:00+0100', $m->format());

        $data = '1923-12-31T12:30:00.123UTC';
        $m = new Moment($data, 'Europe/Warsaw');
        self::assertEquals('1923-12-31T12:30:00+0000', $m->format());
    }

    public function testIsMoment()
    {
        $m = new Moment();
        self::assertFalse($m->isMoment('2012-12-01T12:00:00'));
        self::assertTrue($m->isMoment(new Moment('2012-12-01T12:00:00')));
    }

    public function testFromOnLeapYear()
    {
        $m = new Moment('2017-01-01 00:00:00');
        $from = $m->from('2016-01-01 00:00:00');

        self::assertEquals(-366, $from->getSeconds() / 60 / 60 / 24);
    }

    public function testIsBefore()
    {
        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:10:12');
        self::assertTrue($s->isBefore($i));
        self::assertFalse($i->isBefore($s));

        self::assertFalse($s->isBefore($i, 'minute'));
        self::assertFalse($i->isBefore($s, 'minute'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:12:12');
        self::assertTrue($s->isBefore($i, 'minute'));
        self::assertFalse($i->isBefore($s, 'minute'));

        self::assertFalse($s->isBefore($i, 'hour'));
        self::assertFalse($i->isBefore($s, 'hour'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T12:12:12');
        self::assertTrue($s->isBefore($i, 'minute'));
        self::assertFalse($i->isBefore($s, 'minute'));

        self::assertFalse($s->isBefore($i, 'day'));
        self::assertFalse($i->isBefore($s, 'day'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-02T12:12:12');
        self::assertTrue($s->isBefore($i, 'day'));
        self::assertFalse($i->isBefore($s, 'day'));

        self::assertFalse($s->isBefore($i, 'month'));
        self::assertFalse($i->isBefore($s, 'month'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-02-02T12:12:12');
        self::assertTrue($s->isBefore($i, 'month'));
        self::assertFalse($i->isBefore($s, 'month'));

        self::assertFalse($s->isBefore($i, 'year'));
        self::assertFalse($i->isBefore($s, 'year'));

        //from string
        $s = new Moment('2014-01-01T10:10:11');
        $i = '2014-01-01T10:12:12';
        self::assertTrue($s->isBefore($i, 'minute'));

        $s = '2014-01-01T10:10:11';
        $i = new Moment('2014-01-01T10:12:12');

        self::assertFalse($i->isBefore($s, 'minute'));
    }

    public function testIsAfter()
    {
        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:10:12');
        self::assertTrue($i->isAfter($s));
        self::assertFalse($s->isAfter($i));

        self::assertFalse($s->isAfter($i, 'minute'));
        self::assertFalse($i->isAfter($s, 'minute'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:12:12');
        self::assertFalse($s->isAfter($i, 'minute'));
        self::assertTrue($i->isAfter($s, 'minute'));

        self::assertFalse($s->isAfter($i, 'hour'));
        self::assertFalse($i->isAfter($s, 'hour'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T12:12:12');
        self::assertFalse($s->isAfter($i, 'minute'));
        self::assertTrue($i->isAfter($s, 'minute'));

        self::assertFalse($s->isAfter($i, 'day'));
        self::assertFalse($i->isAfter($s, 'day'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-02T12:12:12');
        self::assertFalse($s->isAfter($i, 'day'));
        self::assertTrue($i->isAfter($s, 'day'));

        self::assertFalse($s->isAfter($i, 'month'));
        self::assertFalse($i->isAfter($s, 'month'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-02-02T12:12:12');
        self::assertFalse($s->isAfter($i, 'month'));
        self::assertTrue($i->isAfter($s, 'month'));

        self::assertFalse($s->isAfter($i, 'year'));
        self::assertFalse($i->isAfter($s, 'year'));

        //from string
        $s = new Moment('2014-01-01T10:10:11');
        $i = '2014-01-01T10:12:12';
        self::assertFalse($s->isAfter($i, 'minute'));

        $s = '2014-01-01T10:10:11';
        $i = new Moment('2014-01-01T10:12:12');

        self::assertTrue($i->isAfter($s, 'minute'));
    }

    public function testIsAfterTz()
    {
        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00+0000');

        self::assertTrue($i->isAfter($s));
        self::assertFalse($s->isAfter($i));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:01+0000');

        self::assertTrue($i->isAfter($s));
        self::assertFalse($s->isAfter($i));

        $s = new Moment('2014-01-01T10:10:00CET');
        $i = new Moment('2014-01-01T09:10:00UTC');

        self::assertFalse($i->isAfter($s));
        self::assertFalse($s->isAfter($i));

        $s = new Moment('2014-01-01T10:10:00Europe/Warsaw');
        $i = new Moment('2014-01-01T09:10:01UTC');

        self::assertTrue($i->isAfter($s));
        self::assertFalse($s->isAfter($i));
    }

    public function testIsSame()
    {
        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00+0000');

        self::assertFalse($i->isSame($s));
        self::assertFalse($s->isSame($i));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00CET');
        self::assertTrue($i->isSame($s));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00Europe/Warsaw');
        self::assertTrue($i->isSame($s));


        $s = new Moment('2014-01-01T10:10:00CET');
        $i = new Moment('2014-01-01T09:10:00UTC');
        self::assertTrue($i->isSame($s));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = '2014-01-01T10:10:00Europe/Warsaw';
        self::assertTrue($s->isSame($i));

        //Periods

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T09:10:01+0000');

        self::assertFalse($i->isSame($s));

        self::assertTrue($i->isSame($s, 'minute'));

        $i = new Moment('2014-01-01T09:11:01+0000');
        self::assertFalse($i->isSame($s, 'minute'));
        self::assertTrue($i->isSame($s, 'hour'));
    }

    public function testIsSameHour()
    {
        // half an hour abbreviation
        $s = new Moment('2014-01-01T09:40:00+0030');
        $i = new Moment('2014-01-01T09:10:00+0000');

        self::assertTrue($i->isSame($s));
        self::assertTrue($s->isSame($i));

        $s = new Moment('2014-01-01T10:05:00+0045');
        $i = new Moment('2014-01-01T09:20:00+0000');

        self::assertTrue($i->isSame($s));
        self::assertTrue($s->isSame($i));

        $s = new Moment('2014-01-01T10:04:00+0045');
        $i = new Moment('2014-01-01T09:20:00+0000');

        self::assertTrue($i->isSame($s, 'hour'));
        self::assertTrue($s->isSame($i, 'hour'));
    }

    public function testIsSameDay()
    {
        $s = new Moment('2014-01-01T00:14:00+0230');
        $i = new Moment('2013-12-31T23:45:00+0000');

        self::assertFalse($i->isSame($s));
        self::assertFalse($s->isSame($i));

        self::assertFalse($i->isSame($s, 'hour'));
        self::assertFalse($s->isSame($i, 'hour'));

        self::assertTrue($i->isSame($s, 'day'));
        self::assertTrue($s->isSame($i, 'day'));

        self::assertTrue($i->isSame($s, 'month'));
        self::assertTrue($s->isSame($i, 'month'));

        self::assertTrue($i->isSame($s, 'year'));
        self::assertTrue($s->isSame($i, 'year'));
    }

    public function testIsSameMonth()
    {
        $s = new Moment('2014-01-01T00:14:00+0230');
        $i = new Moment('2013-12-30T23:45:00+0000');

        self::assertFalse($i->isSame($s));
        self::assertFalse($s->isSame($i));

        self::assertFalse($i->isSame($s, 'hour'));
        self::assertFalse($s->isSame($i, 'hour'));

        self::assertFalse($i->isSame($s, 'day'));
        self::assertFalse($s->isSame($i, 'day'));

        self::assertTrue($i->isSame($s, 'month'));
        self::assertTrue($s->isSame($i, 'month'));

        self::assertTrue($i->isSame($s, 'year'));
        self::assertTrue($s->isSame($i, 'year'));
    }

    public function testIsSameYear()
    {
        $s = new Moment('2014-01-01T00:14:00+0230');
        $i = new Moment('2013-11-30T23:45:00+0000');

        self::assertFalse($i->isSame($s));
        self::assertFalse($s->isSame($i));

        self::assertFalse($i->isSame($s, 'hour'));
        self::assertFalse($s->isSame($i, 'hour'));

        self::assertFalse($i->isSame($s, 'day'));
        self::assertFalse($s->isSame($i, 'day'));

        self::assertFalse($i->isSame($s, 'month'));
        self::assertFalse($s->isSame($i, 'month'));

        self::assertTrue($i->isSame($s, 'year'));
        self::assertTrue($s->isSame($i, 'year'));
    }

    public function testIsBetween()
    {
        $l = new Moment('2014-01-01T10:00:00Z');
        $r = new Moment('2014-01-01T12:00:00Z');

        $n = $l->cloning();
        self::assertTrue($n->isBetween($l, $r, true));
        self::assertFalse($n->isBetween($l, $r, false));

        $n = $r->cloning();
        self::assertTrue($n->isBetween($l, $r, true));
        self::assertFalse($n->isBetween($l, $r, false));

        //Minutes
        $l = new Moment('2014-01-01T10:30:30Z');
        $r = new Moment('2014-01-01T12:30:30Z');

        $n = new Moment('2014-01-01T10:30:00Z');
        self::assertFalse($n->isBetween($l, $r, true));
        $n = new Moment('2014-01-01T12:30:45Z');
        self::assertFalse($n->isBetween($l, $r, true));

        $n = new Moment('2014-01-01T10:30:00Z');
        self::assertTrue($n->isBetween($l, $r, true, 'minute'));
        $n = new Moment('2014-01-01T12:30:45Z');
        self::assertTrue($n->isBetween($l, $r, true, 'minute'));

        //Hour
        $n = new Moment('2014-01-01T10:29:00Z');
        self::assertFalse($n->isBetween($l, $r, true, 'minute'));
        $n = new Moment('2014-01-01T12:31:45Z');
        self::assertFalse($n->isBetween($l, $r, true, 'minute'));

        $n = new Moment('2014-01-01T10:29:00Z');
        self::assertTrue($n->isBetween($l, $r, true, 'hour'));
        $n = new Moment('2014-01-01T12:31:45Z');
        self::assertTrue($n->isBetween($l, $r, true, 'hour'));

        //Day
        $n = new Moment('2014-01-01T09:29:00Z');
        self::assertFalse($n->isBetween($l, $r, true, 'hour'));
        $n = new Moment('2014-01-01T13:31:45Z');
        self::assertFalse($n->isBetween($l, $r, true, 'hour'));

        $n = new Moment('2014-01-01T10:29:00Z');
        self::assertTrue($n->isBetween($l, $r, true, 'day'));
        $n = new Moment('2014-01-01T12:31:45Z');
        self::assertTrue($n->isBetween($l, $r, true, 'day'));

        //Month
        $l = new Moment('2014-01-10T10:30:30Z');
        $r = new Moment('2014-01-20T12:30:30Z');

        $n = new Moment('2014-01-09T09:29:00Z');
        self::assertFalse($n->isBetween($l, $r, true, 'day'));
        $n = new Moment('2014-01-21T13:31:45Z');
        self::assertFalse($n->isBetween($l, $r, true, 'day'));

        $n = new Moment('2014-01-09T10:29:00Z');
        self::assertTrue($n->isBetween($l, $r, true, 'month'));
        $n = new Moment('2014-01-21T12:31:45Z');
        self::assertTrue($n->isBetween($l, $r, true, 'month'));

        //year
        $l = new Moment('2014-04-10T10:30:30Z');
        $r = new Moment('2015-08-20T12:30:30Z');

        $n = new Moment('2014-03-09T09:29:00Z');
        self::assertFalse($n->isBetween($l, $r, true, 'month'));
        $n = new Moment('2015-09-21T13:31:45Z');
        self::assertFalse($n->isBetween($l, $r, true, 'month'));

        $n = new Moment('2014-03-09T10:29:00Z');
        self::assertTrue($n->isBetween($l, $r, true, 'year'));
        $n = new Moment('2015-09-21T12:31:45Z');
        self::assertTrue($n->isBetween($l, $r, true, 'year'));
    }

    public function testLocaleDow()
    {
        //Test en_GB for Monday start of week
        Moment::setLocale('en_GB');

        //Expected Values
        $gb_start = new Moment('2015-04-27T00:00:00Z');
        $gb_end = new Moment('2015-05-03T23:59:59Z');

        //Current date: Middle of the week
        $gb = new Moment('2015-04-28T10:29:00Z');

        self::assertTrue($gb->cloning()->startOf('week')->isSame($gb_start));
        self::assertTrue($gb->cloning()->endOf('week')->isSame($gb_end));

        //Current Date: Beginning of the week
        $gb = new Moment('2015-04-27T10:29:00Z');

        self::assertTrue($gb->cloning()->startOf('week')->isSame($gb_start));
        self::assertTrue($gb->cloning()->endOf('week')->isSame($gb_end));

        //Current Date: End of week
        $gb = new Moment('2015-05-03T10:29:00Z');

        self::assertTrue($gb->cloning()->startOf('week')->isSame($gb_start));
        self::assertTrue($gb->cloning()->endOf('week')->isSame($gb_end));


        //Test en_US for Sunday start of week
        Moment::setLocale('en_US');

        //Expected Values
        $us_start = new Moment('2015-04-26T00:00:00Z');
        $us_end = new Moment('2015-05-02T23:59:59Z');

        //Current date: Middle of the week
        $us = new Moment('2015-04-28T10:29:00Z');

        self::assertTrue($us->cloning()->startOf('week')->isSame($us_start));
        self::assertTrue($us->cloning()->endOf('week')->isSame($us_end));

        //Current Date: Beginning of the week
        $us = new Moment('2015-04-26T10:29:00Z');

        self::assertTrue($us->cloning()->startOf('week')->isSame($us_start));
        self::assertTrue($us->cloning()->endOf('week')->isSame($us_end));

        //Current Date: End of week
        $us = new Moment('2015-05-02T10:29:00Z');

        self::assertTrue($us->cloning()->startOf('week')->isSame($us_start));
        self::assertTrue($us->cloning()->endOf('week')->isSame($us_end));
    }

    public function testImplicitCloning()
    {
        $origin = new Moment('1923-12-31 12:30:00', 'UTC', true);

        self::assertNotSame($origin, $origin->addMonths(1));
        $origin->setImmutableMode(false);
        self::assertSame($origin, $origin->addMonths(1));
        $origin->setImmutableMode(true);
        self::assertNotSame($origin, $origin->addMonths(1));
    }

    public function testRFC2822Parsing()
    {
        $tz = 'CET';
        $format = 'Y-m-d H:i';

        $dates = array(
            array(
                'input'  => 'Tue, 11 Dec 2018 14:12:01 +0000',
                'output' => '2018-12-11 15:12',
            ),
            array(
                'input'  => 'Tue, 11 Dec 2018 07:46:41 -0500',
                'output' => '2018-12-11 13:46',
            ),
        );

        foreach ($dates as $date)
        {
            $m = new Moment($date['input']);
            self::assertEquals($date['output'], $m->setTimezone($tz)->format($format));
        }
    }

    public function testValidUnixtimeLength()
    {
        $dates = array(
            999992800, // September 9th, 2001 1:46 AM
            1544652373 // December 12th, 2018 11:06 PM
        );

        foreach ($dates as $date)
        {
            $m = new Moment($date);
            self::assertEquals($date, $m->format('U'));
        }
    }

    /**
     * @link https://github.com/fightbulc/moment.php/issues/62
     */
//    public function testLeapYear()
//    {
//        $now = new Moment('2016-01-31', 'Asia/Tokyo');
//
//        $now
//            ->subtractDays(1)
//            ->addDays(1)
//            ->startOf('day')
//            ->cloning()
//            ->startOf('month')
//            ->addMonths(1)
//            ->setDay('30')
//            ->subtractMonths(1)
//            ->endOf('month')
//            ->format();
//    }
}

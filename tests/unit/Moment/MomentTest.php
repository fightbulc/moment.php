<?php

namespace Moment;

class MomentTest extends \PHPUnit_Framework_TestCase
{
    public function testMoment()
    {
        $data = '1923-12-31 12:30:00';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.000';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.123';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.123+02:00';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0200', $m->format());

        $data = '1923-12-31T12:30:00.123+0200';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0200', $m->format());

        $data = '1923-12-31T12:30:00.123Z';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0000', $m->format());

        $data = '1923-12-31T12:30:00.123Europe/Warsaw';
        $m = new Moment($data);
        $this->assertEquals('1923-12-31T12:30:00+0100', $m->format());

        $data = '1923-12-31T12:30:00.123Europe/Warsaw';
        $m = new Moment($data, 'UTC');
        $this->assertEquals('1923-12-31T12:30:00+0100', $m->format());

        $data = '1923-12-31T12:30:00.123UTC';
        $m = new Moment($data, 'Europe/Warsaw');
        $this->assertEquals('1923-12-31T12:30:00+0000', $m->format());
    }

    public function testIsMoment()
    {
        $m = new Moment();
        $this->assertFalse($m->isMoment('2012-12-01T12:00:00'));
        $this->assertTrue($m->isMoment(new Moment('2012-12-01T12:00:00')));
    }

    public function testFromOnLeapYear()
    {
        $m = new Moment('2017-01-01 00:00:00');
        $from = $m->from('2016-01-01 00:00:00');

        $this->assertEquals(-366, $from->getSeconds() / 60 / 60 / 24);
    }

    public function testIsBefore()
    {
        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:10:12');
        $this->assertTrue($s->isBefore($i));
        $this->assertFalse($i->isBefore($s));

        $this->assertFalse($s->isBefore($i, 'minute'));
        $this->assertFalse($i->isBefore($s, 'minute'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:12:12');
        $this->assertTrue($s->isBefore($i, 'minute'));
        $this->assertFalse($i->isBefore($s, 'minute'));

        $this->assertFalse($s->isBefore($i, 'hour'));
        $this->assertFalse($i->isBefore($s, 'hour'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T12:12:12');
        $this->assertTrue($s->isBefore($i, 'minute'));
        $this->assertFalse($i->isBefore($s, 'minute'));

        $this->assertFalse($s->isBefore($i, 'day'));
        $this->assertFalse($i->isBefore($s, 'day'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-02T12:12:12');
        $this->assertTrue($s->isBefore($i, 'day'));
        $this->assertFalse($i->isBefore($s, 'day'));

        $this->assertFalse($s->isBefore($i, 'month'));
        $this->assertFalse($i->isBefore($s, 'month'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-02-02T12:12:12');
        $this->assertTrue($s->isBefore($i, 'month'));
        $this->assertFalse($i->isBefore($s, 'month'));

        $this->assertFalse($s->isBefore($i, 'year'));
        $this->assertFalse($i->isBefore($s, 'year'));

        //from string
        $s = new Moment('2014-01-01T10:10:11');
        $i = '2014-01-01T10:12:12';
        $this->assertTrue($s->isBefore($i, 'minute'));

        $s = '2014-01-01T10:10:11';
        $i = new Moment('2014-01-01T10:12:12');

        $this->assertFalse($i->isBefore($s, 'minute'));
    }

    public function testIsAfter()
    {
        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:10:12');
        $this->assertTrue($i->isAfter($s));
        $this->assertFalse($s->isAfter($i));

        $this->assertFalse($s->isAfter($i, 'minute'));
        $this->assertFalse($i->isAfter($s, 'minute'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T10:12:12');
        $this->assertFalse($s->isAfter($i, 'minute'));
        $this->assertTrue($i->isAfter($s, 'minute'));

        $this->assertFalse($s->isAfter($i, 'hour'));
        $this->assertFalse($i->isAfter($s, 'hour'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-01T12:12:12');
        $this->assertFalse($s->isAfter($i, 'minute'));
        $this->assertTrue($i->isAfter($s, 'minute'));

        $this->assertFalse($s->isAfter($i, 'day'));
        $this->assertFalse($i->isAfter($s, 'day'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-01-02T12:12:12');
        $this->assertFalse($s->isAfter($i, 'day'));
        $this->assertTrue($i->isAfter($s, 'day'));

        $this->assertFalse($s->isAfter($i, 'month'));
        $this->assertFalse($i->isAfter($s, 'month'));

        $s = new Moment('2014-01-01T10:10:11');
        $i = new Moment('2014-02-02T12:12:12');
        $this->assertFalse($s->isAfter($i, 'month'));
        $this->assertTrue($i->isAfter($s, 'month'));

        $this->assertFalse($s->isAfter($i, 'year'));
        $this->assertFalse($i->isAfter($s, 'year'));

        //from string
        $s = new Moment('2014-01-01T10:10:11');
        $i = '2014-01-01T10:12:12';
        $this->assertFalse($s->isAfter($i, 'minute'));

        $s = '2014-01-01T10:10:11';
        $i = new Moment('2014-01-01T10:12:12');

        $this->assertTrue($i->isAfter($s, 'minute'));
    }

    public function testIsAfterTz()
    {
        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00+0000');

        $this->assertTrue($i->isAfter($s));
        $this->assertFalse($s->isAfter($i));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:01+0000');

        $this->assertTrue($i->isAfter($s));
        $this->assertFalse($s->isAfter($i));

        $s = new Moment('2014-01-01T10:10:00CET');
        $i = new Moment('2014-01-01T09:10:00UTC');

        $this->assertFalse($i->isAfter($s));
        $this->assertFalse($s->isAfter($i));

        $s = new Moment('2014-01-01T10:10:00Europe/Warsaw');
        $i = new Moment('2014-01-01T09:10:01UTC');

        $this->assertTrue($i->isAfter($s));
        $this->assertFalse($s->isAfter($i));
    }

    public function testIsSame()
    {
        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00+0000');

        $this->assertFalse($i->isSame($s));
        $this->assertFalse($s->isSame($i));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00CET');
        $this->assertTrue($i->isSame($s));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T10:10:00Europe/Warsaw');
        $this->assertTrue($i->isSame($s));


        $s = new Moment('2014-01-01T10:10:00CET');
        $i = new Moment('2014-01-01T09:10:00UTC');
        $this->assertTrue($i->isSame($s));

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = '2014-01-01T10:10:00Europe/Warsaw';
        $this->assertTrue($s->isSame($i));

        //Periods

        $s = new Moment('2014-01-01T10:10:00+0100');
        $i = new Moment('2014-01-01T09:10:01+0000');

        $this->assertFalse($i->isSame($s));

        $this->assertTrue($i->isSame($s, 'minute'));

        $i = new Moment('2014-01-01T09:11:01+0000');
        $this->assertFalse($i->isSame($s, 'minute'));
        $this->assertTrue($i->isSame($s, 'hour'));
    }

    public function testIsSameHour()
    {
        // half an hour abbreviation
        $s = new Moment('2014-01-01T09:40:00+0030');
        $i = new Moment('2014-01-01T09:10:00+0000');

        $this->assertTrue($i->isSame($s));
        $this->assertTrue($s->isSame($i));

        $s = new Moment('2014-01-01T10:05:00+0045');
        $i = new Moment('2014-01-01T09:20:00+0000');

        $this->assertTrue($i->isSame($s));
        $this->assertTrue($s->isSame($i));

        $s = new Moment('2014-01-01T10:04:00+0045');
        $i = new Moment('2014-01-01T09:20:00+0000');

        $this->assertTrue($i->isSame($s, 'hour'));
        $this->assertTrue($s->isSame($i, 'hour'));
    }

    public function testIsSameDay()
    {
        $s = new Moment('2014-01-01T00:14:00+0230');
        $i = new Moment('2013-12-31T23:45:00+0000');

        $this->assertFalse($i->isSame($s));
        $this->assertFalse($s->isSame($i));

        $this->assertFalse($i->isSame($s, 'hour'));
        $this->assertFalse($s->isSame($i, 'hour'));

        $this->assertTrue($i->isSame($s, 'day'));
        $this->assertTrue($s->isSame($i, 'day'));

        $this->assertTrue($i->isSame($s, 'month'));
        $this->assertTrue($s->isSame($i, 'month'));

        $this->assertTrue($i->isSame($s, 'year'));
        $this->assertTrue($s->isSame($i, 'year'));
    }

    public function testIsSameMonth()
    {
        $s = new Moment('2014-01-01T00:14:00+0230');
        $i = new Moment('2013-12-30T23:45:00+0000');

        $this->assertFalse($i->isSame($s));
        $this->assertFalse($s->isSame($i));

        $this->assertFalse($i->isSame($s, 'hour'));
        $this->assertFalse($s->isSame($i, 'hour'));

        $this->assertFalse($i->isSame($s, 'day'));
        $this->assertFalse($s->isSame($i, 'day'));

        $this->assertTrue($i->isSame($s, 'month'));
        $this->assertTrue($s->isSame($i, 'month'));

        $this->assertTrue($i->isSame($s, 'year'));
        $this->assertTrue($s->isSame($i, 'year'));
    }

    public function testIsSameYear()
    {
        $s = new Moment('2014-01-01T00:14:00+0230');
        $i = new Moment('2013-11-30T23:45:00+0000');

        $this->assertFalse($i->isSame($s));
        $this->assertFalse($s->isSame($i));

        $this->assertFalse($i->isSame($s, 'hour'));
        $this->assertFalse($s->isSame($i, 'hour'));

        $this->assertFalse($i->isSame($s, 'day'));
        $this->assertFalse($s->isSame($i, 'day'));

        $this->assertFalse($i->isSame($s, 'month'));
        $this->assertFalse($s->isSame($i, 'month'));

        $this->assertTrue($i->isSame($s, 'year'));
        $this->assertTrue($s->isSame($i, 'year'));
    }

    public function testIsBetween()
    {
        $l = new Moment('2014-01-01T10:00:00Z');
        $r = new Moment('2014-01-01T12:00:00Z');

        $n = $l->cloning();
        $this->assertTrue($n->isBetween($l, $r, true));
        $this->assertFalse($n->isBetween($l, $r, false));

        $n = $r->cloning();
        $this->assertTrue($n->isBetween($l, $r, true));
        $this->assertFalse($n->isBetween($l, $r, false));

        //Minutes
        $l = new Moment('2014-01-01T10:30:30Z');
        $r = new Moment('2014-01-01T12:30:30Z');

        $n = new Moment('2014-01-01T10:30:00Z');
        $this->assertFalse($n->isBetween($l, $r, true));
        $n = new Moment('2014-01-01T12:30:45Z');
        $this->assertFalse($n->isBetween($l, $r, true));

        $n = new Moment('2014-01-01T10:30:00Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'minute'));
        $n = new Moment('2014-01-01T12:30:45Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'minute'));

        //Hour
        $n = new Moment('2014-01-01T10:29:00Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'minute'));
        $n = new Moment('2014-01-01T12:31:45Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'minute'));

        $n = new Moment('2014-01-01T10:29:00Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'hour'));
        $n = new Moment('2014-01-01T12:31:45Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'hour'));

        //Day
        $n = new Moment('2014-01-01T09:29:00Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'hour'));
        $n = new Moment('2014-01-01T13:31:45Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'hour'));

        $n = new Moment('2014-01-01T10:29:00Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'day'));
        $n = new Moment('2014-01-01T12:31:45Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'day'));

        //Month
        $l = new Moment('2014-01-10T10:30:30Z');
        $r = new Moment('2014-01-20T12:30:30Z');

        $n = new Moment('2014-01-09T09:29:00Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'day'));
        $n = new Moment('2014-01-21T13:31:45Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'day'));

        $n = new Moment('2014-01-09T10:29:00Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'month'));
        $n = new Moment('2014-01-21T12:31:45Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'month'));

        //year
        $l = new Moment('2014-04-10T10:30:30Z');
        $r = new Moment('2015-08-20T12:30:30Z');

        $n = new Moment('2014-03-09T09:29:00Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'month'));
        $n = new Moment('2015-09-21T13:31:45Z');
        $this->assertFalse($n->isBetween($l, $r, true, 'month'));

        $n = new Moment('2014-03-09T10:29:00Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'year'));
        $n = new Moment('2015-09-21T12:31:45Z');
        $this->assertTrue($n->isBetween($l, $r, true, 'year'));
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

        $this->assertTrue($gb->cloning()->startOf('week')->isSame($gb_start));
        $this->assertTrue($gb->cloning()->endOf('week')->isSame($gb_end));

        //Current Date: Beginning of the week
        $gb = new Moment('2015-04-27T10:29:00Z');

        $this->assertTrue($gb->cloning()->startOf('week')->isSame($gb_start));
        $this->assertTrue($gb->cloning()->endOf('week')->isSame($gb_end));

        //Current Date: End of week
        $gb = new Moment('2015-05-03T10:29:00Z');

        $this->assertTrue($gb->cloning()->startOf('week')->isSame($gb_start));
        $this->assertTrue($gb->cloning()->endOf('week')->isSame($gb_end));


        //Test en_US for Sunday start of week
        Moment::setLocale('en_US');

        //Expected Values
        $us_start = new Moment('2015-04-26T00:00:00Z');
        $us_end = new Moment('2015-05-02T23:59:59Z');

        //Current date: Middle of the week
        $us = new Moment('2015-04-28T10:29:00Z');

        $this->assertTrue($us->cloning()->startOf('week')->isSame($us_start));
        $this->assertTrue($us->cloning()->endOf('week')->isSame($us_end));

        //Current Date: Beginning of the week
        $us = new Moment('2015-04-26T10:29:00Z');

        $this->assertTrue($us->cloning()->startOf('week')->isSame($us_start));
        $this->assertTrue($us->cloning()->endOf('week')->isSame($us_end));

        //Current Date: End of week
        $us = new Moment('2015-05-02T10:29:00Z');

        $this->assertTrue($us->cloning()->startOf('week')->isSame($us_start));
        $this->assertTrue($us->cloning()->endOf('week')->isSame($us_end));
    }

    public function testImplicitCloning()
    {
        $origin = new Moment('1923-12-31 12:30:00', 'UTC', true);

        $this->assertNotSame($origin, $origin->addMonths(1));
        $origin->setImmutableMode(false);
        $this->assertSame($origin, $origin->addMonths(1));
        $origin->setImmutableMode(true);
        $this->assertNotSame($origin, $origin->addMonths(1));
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

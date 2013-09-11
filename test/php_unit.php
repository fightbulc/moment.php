<?php
require_once ("../src/Moment/Moment.php");

class MomentTest extends PHPUnit_Framework_TestCase
{
    
    private $object;
    private $cases;
    
    protected function setUp()
    {
        
        $this->object = new \Moment\Moment('2013-07-11T14:08:00');
    }


    public function testFormat()
    {
        $cases = array(
            "dddd, MMMM Do YYYY, h:mm:ss a" => "l, F jS Y, g:i:s a",    //Sunday, February 14th 2010, 3:25:50 pm
            "dddd" => "l",                                              //Thursday
            "MMM Do YY" => "M jS y",                                    //Thursday
            "YYYY [escaped] YYYY" => "Y \\e\\s\\c\\a\\p\\e\\d Y",       //2013 escaped 2013
            "LT" => "g:i A",                                            //8:30 PM
            "L" => "m/d/Y",                                             //07/11/2013
            "LL" => "F dS Y",                                           //July 11th 2013
            "l" => "n/j/Y",                                             //9/4/1986
            "ll" => "M j Y",                                            //Sep 4 1986
        );
        
        
        foreach($cases as $momentjsFormat => $phpFormat) {
            $momentjs = $this->object->format($momentjsFormat, true);
            $php = $this->object->format($phpFormat);
            $this->assertEquals($momentjs, $php);
        }
    }
}

<?php

/**
 * Wrapper for PHP's DateTime class inspired by moment.js
 *
 * @author  Tino Ehrich <ehrich@efides.com>
 * @version 0.1
 *
 * @dependencies  >= PHP 5.3.0
 *
 */
namespace Moment;

class Moment extends \DateTime
{
    /**
     * @param string $dateTime
     * @param string $timezone
     */
    public function __construct($dateTime = 'now', $timezone = 'UTC')
    {
        parent::__construct($dateTime, $this->_getDateTimeZone($timezone));

        return $this;
    }

    // ##########################################

    /**
     * @param $timezone
     * @return \DateTimeZone
     */
    protected function _getDateTimeZone($timezone)
    {
        return new \DateTimeZone($timezone);
    }

    // ##########################################

    /**
     * @param \DateTimeZone $timezone
     * @return \DateTime|Moment
     */
    public function setTimezone($timezone)
    {
        parent::setTimezone($this->_getDateTimeZone($timezone));

        return $this;
    }

    // ##########################################

    /**
     * @param string $dateTime
     * @param string $timezone
     * @return Moment
     */
    public function resetDateTime($dateTime = 'now', $timezone = 'UTC')
    {
        parent::__construct($dateTime, $this->_getDateTimeZone($timezone));

        return $this;
    }

    // ##########################################

    /**
     * @param null $format
     * @return string
     */
    public function format($format = NULL, $isMomentjs = false)
    {
        if ($format === NULL) {
            $format = \DateTime::ISO8601;
        }

        if ($isMomentjs === true) {
            $format = $this->momentjsToPhp($format);
        }

        return parent::format($format);
    }

    // ############################################

    /**
     * @param string $type
     * @param int $value
     * @return Moment
     */
    public function add($type = 'day', $value = 1)
    {
        parent::modify('+' . $value . ' ' . $type);

        return $this;
    }

    // ############################################

    /**
     * @param string $type
     * @param int $value
     * @return Moment
     */
    public function subtract($type = 'day', $value = 1)
    {
        parent::modify('-' . $value . ' ' . $type);

        return $this;
    }

    // ############################################

    /**
     * @param string $dateTime
     * @param string $timezone
     * @return array
     */
    public function from($dateTime = 'now', $timezone = 'UTC')
    {
        $fromInstance = parent::diff(new Moment($dateTime, $timezone));

        $direction = $fromInstance->format('%R');

        return array(
            'seconds' => $direction . $this->_fromToSeconds($fromInstance),
            'minutes' => $direction . round($this->_fromToMinutes($fromInstance), 2),
            'hours' => $direction . round($this->_fromToHours($fromInstance), 2),
            'days' => $direction . round($this->_fromToDays($fromInstance), 2),
            'weeks' => $direction . round($this->_fromToWeeks($fromInstance), 2),
        );
    }

    // ############################################

    /**
     * @param string $timezone
     * @return array
     */
    public function fromNow($timezone = 'UTC')
    {
        return $this->from('now', $timezone);
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToSeconds(\DateInterval $dateInterval)
    {
        return ($dateInterval->y * 365 * 24 * 60 * 60) + ($dateInterval->m * 30 * 24 * 60 * 60) + ($dateInterval->d * 24 * 60 * 60) + ($dateInterval->h * 60 * 60) + $dateInterval->s;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToMinutes(\DateInterval $dateInterval)
    {
        return $this->_fromToSeconds($dateInterval) / 60;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToHours(\DateInterval $dateInterval)
    {
        return $this->_fromToMinutes($dateInterval) / 60;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToDays(\DateInterval $dateInterval)
    {
        return $this->_fromToHours($dateInterval) / 24;
    }

    // ############################################

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    protected function _fromToWeeks(\DateInterval $dateInterval)
    {
        return $this->_fromToDays($dateInterval) / 7;
    }

    // ############################################

    /**
     * @param String $format
     * @return string
     */
    protected function momentjsToPhp($format)
    {
        //conversion chart
        $tokens = array(
            "M" => "n", //1 2 ... 11 12
            "Mo" => "nS", //1st 2nd ... 11th 12th
            "MM" => "m", //01 02 ... 11 12
            "MMM" => "M", //Jan Feb ... Nov Dec
            "MMMM" => "F", //January February ... November December
            "D" => "j", //1 2 ... 30 30
            "Do" => "jS", //1st 2nd ... 30th 31st
            "DD" => "d", //01 02 ... 30 31
            "DDD" => "z", //1 2 ... 364 365
            "DDDo" => "zS", //1st 2nd ... 364th 365th
            "DDDD" => "zS", // ***001 002 ... 364 365
            "d" => "w", //0 1 ... 5 6
            "do" => "wS", //0th 1st ... 5th 6th
            "dd" => "D", // ***Su Mo ... Fr Sa
            "ddd" => "D", //Sun Mon ... Fri Sat
            "dddd" => "l", //Sunday Monday ... Friday Saturday
            "e" => "w", //0 1 ... 5 6
            "E" => "N", //1 2 ... 6 7
            "w" => "W", //1 2 ... 52 53
            "wo" => "WS", //1st 2nd ... 52nd 53rd
            "ww" => "W", // ***01 02 ... 52 53
            "W" => "W", //1 2 ... 52 53
            "Wo" => "WS", //1st 2nd ... 52nd 53rd
            "WW" => "W", // ***01 02 ... 52 53
            "YY" => "y", //70 71 ... 29 30
            "YYYY" => "Y", //1970 1971 ... 2029 2030
            "gg" => "o", //70 71 ... 29 30
            "gggg" => "o", // ***1970 1971 ... 2029 2030
            "GG" => "o", //70 71 ... 29 30
            "GGGG" => "o", // ***1970 1971 ... 2029 2030
            "A" => "A", //AM PM
            "a" => "a", //am pm
            "H" => "G", //0 1 ... 22 23
            "HH" => "H", //00 01 ... 22 23
            "h" => "g", //1 2 ... 11 12
            "hh" => "h", //01 02 ... 11 12
            "m" => "i", //0 1 ... 58 59
            "mm" => "i", // ***00 01 ... 58 59
            "s" => "s", //0 1 ... 58 59
            "ss" => "s", // ***00 01 ... 58 59
            "S" => "", //0 1 ... 8 9
            "SS" => "", //0 1 ... 98 99
            "SSS" => "", //0 1 ... 998 999
            "z or zz" => "T", //EST CST ... MST PST 
            "Z" => "P", //-07:00 -06:00 ... +06:00 +07:00
            "ZZ" => "O", //-0700 -0600 ... +0600 +0700
            "X" => "U", //1360013296
            "LT" => "g:i A", //8:30 PM
            "L" => "m/d/Y", //09/04/1986
            "l" => "n/j/Y", //9/4/1986
            "LL" => "F jS Y", //September 4th 1986
            "ll" => "M j Y", //Sep 4 1986
            "LLL" => "F js Y g:i A", //September 4th 1986 8:30 PM
            "lll" => "M j Y g:i A", //Sep 4 1986 8:30 PM
            "LLLL" => "l, F jS Y g:i A", //Thursday, September 4th 1986 8:30 PM
            "llll" => "D, M j Y g:i A", //Thu, Sep 4 1986 8:30 PM
        );

        //find all tokens from string, using regular expression
        $regExp = "/(\[[^\[]*\])|(\\\\)?(LT|LL?L?L?|l{1,4}|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|SS?S?|X|zz?|ZZ?|.)/";
        $matches = array();
        preg_match_all($regExp, $format, $matches);
        //if there is no match found then return the string as it is
        //TODO: may be return escaped string
        if (empty($matches) || is_array($matches) === false) {
            return $format;
        }

        //to match with extracted tokens
        $MomentTokens = array_keys($tokens);
        $phpMatches = array();

        foreach ($matches[0] as $id => $match) {
            //if there is a matching php token in token list
            if (in_array($match, $MomentTokens)) {
                //use the php token instead
                $phpMatches[$id] = $tokens[$match];
            //if the match's first character is [ then it would be a escaped string
            } else if (substr($match, 0, 1) === "[") {
                //remove square braces
                $temp = trim($match, "[]");
                //split string to add \ in front of each character (required for PHP escaping)
                $result = str_split($temp);
                //join string will \ in front of each character
                $phpMatches[$id] = "\\" . implode("\\", $result);
            //if matches is space or we don't have any details about it
            } else {
                //keep match as it is.
                //TODO: may be make it escaped string
                $phpMatches[$id] = $match;
            }
        }
        //join and return php specific tokens
        return implode("", $phpMatches);
    }

}

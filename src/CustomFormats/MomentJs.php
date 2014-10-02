<?php

namespace Moment\CustomFormats;

use Moment\FormatsInterface;

class MomentJs implements FormatsInterface
{
    /** @var array */
    protected $tokens = array(
        "M"       => "n", // 1 2 ... 11 12
        "Mo"      => "nS", // month: 1st 2nd ... 11th 12th
        "MM"      => "m", // 01 02 ... 11 12
        "MMM"     => "M", // Jan Feb ... Nov Dec
        "MMMM"    => "F", // January February ... November December
        "D"       => "j", // 1 2 ... 30 30
        "Do"      => "jS", // day: 1st 2nd ... 30th 31st
        "DD"      => "d", // 01 02 ... 30 31
        "DDD"     => "z", // 1 2 ... 364 365
        "DDDo"    => "zS", // day of year: 1st 2nd ... 364th 365th
        "DDDD"    => "zS", // day of year: 1st 2nd ... 364th 365th
        "d"       => "w", // 0 1 ... 5 6
        "do"      => "wS", // day of week: 0th 1st ... 5th 6th
        "dd"      => "D", //  ***Su Mo ... Fr Sa
        "ddd"     => "D", // Sun Mon ... Fri Sat
        "dddd"    => "l", // Sunday Monday ... Friday Saturday
        "e"       => "w", // 0 1 ... 5 6
        "E"       => "N", // 1 2 ... 6 7
        "w"       => "W", // 1 2 ... 52 53
        "wo"      => "WS", // week of year: 1st 2nd ... 52nd 53rd
        "ww"      => "W", //  ***01 02 ... 52 53
        "W"       => "W", // 1 2 ... 52 53
        "Wo"      => "WS", // week of year: 1st 2nd ... 52nd 53rd
        "WW"      => "W", //  ***01 02 ... 52 53
        "YY"      => "y", // 70 71 ... 29 30
        "YYYY"    => "Y", // 1970 1971 ... 2029 2030
        "gg"      => "o", // 70 71 ... 29 30
        "gggg"    => "o", //  ***1970 1971 ... 2029 2030
        "GG"      => "o", // 70 71 ... 29 30
        "GGGG"    => "o", //  ***1970 1971 ... 2029 2030
        "A"       => "A", // AM PM
        "a"       => "a", // am pm
        "H"       => "G", // 0 1 ... 22 23
        "HH"      => "H", // 00 01 ... 22 23
        "h"       => "g", // 1 2 ... 11 12
        "hh"      => "h", // 01 02 ... 11 12
        "m"       => "i", // 0 1 ... 58 59
        "mm"      => "i", //  ***00 01 ... 58 59
        "s"       => "s", // 0 1 ... 58 59
        "ss"      => "s", //  ***00 01 ... 58 59
        "S"       => "", // 0 1 ... 8 9
        "SS"      => "", // 0 1 ... 98 99
        "SSS"     => "", // 0 1 ... 998 999
        "z or zz" => "T", // EST CST ... MST PST 
        "Z"       => "P", // -07:00 -06:00 ... +06:00 +07:00
        "ZZ"      => "O", // -0700 -0600 ... +0600 +0700
        "X"       => "U", // 1360013296
        "LT"      => "g:i A", // 8:30 PM
        "L"       => "m/d/Y", // 09/04/1986
        "l"       => "n/j/Y", // 9/4/1986
        "LL"      => "F jS Y", // September 4th 1986
        "ll"      => "M j Y", // Sep 4 1986
        "LLL"     => "F js Y g:i A", // September 4th 1986 8:30 PM
        "lll"     => "M j Y g:i A", // Sep 4 1986 8:30 PM
        "LLLL"    => "l, F jS Y g:i A", // Thursday, September 4th 1986 8:30 PM
        "llll"    => "D, M j Y g:i A", // Thu, Sep 4 1986 8:30 PM
    );

    /**
     * @param $format
     *
     * @return string
     */
    public function format($format)
    {
        return $this->momentJsToPhp($format);
    }

    /**
     * @return array
     */
    public function getTokens()
    {
        return (array)$this->tokens;
    }

    /**
     * @param array $options
     *
     * @return MomentJs
     */
    public function setTokens(array $options)
    {
        $this->tokens = array_merge($this->tokens, $options);

        return $this;
    }

    /**
     * @param String $format
     *
     * @return string
     */
    protected function momentJsToPhp($format)
    {
        $tokens = $this->getTokens();

        // find all tokens from string, using regular expression
        $regExp = "/(\[[^\[]*\])|(\\\\)?(LT|LL?L?L?|l{1,4}|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|SS?S?|X|zz?|ZZ?|.)/";
        $matches = array();
        preg_match_all($regExp, $format, $matches);

        //  if there is no match found then return the string as it is
        //  TODO: might return escaped string
        if (empty($matches) || is_array($matches) === false)
        {
            return $format;
        }

        //  to match with extracted tokens
        $momentTokens = array_keys($tokens);
        $phpMatches = array();

        //  ----------------------------------

        foreach ($matches[0] as $id => $match)
        {
            // if there is a matching php token in token list
            if (in_array($match, $momentTokens))
            {
                // use the php token instead
                $string = $tokens[$match];
            }
            else
            {
                $string = $match;
            }

            $phpMatches[$id] = $string;
        }

        // join and return php specific tokens
        return implode("", $phpMatches);
    }
}
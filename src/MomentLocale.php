<?php

namespace Moment;

/**
 * MomentLocale
 * @package Moment
 * @author  Tino Ehrich (tino@bigpun.me)
 */
class MomentLocale
{
    /**
     * @var Moment
     */
    private static $moment;

    /**
     * @var string
     */
    private static $locale = 'en_GB';

    /**
     * @var boolean
     */
    private static $findSimilar = false;

    /**
     * @var array
     */
    private static $localeContent = array();

    /**
     * @param Moment $moment
     */
    public static function setMoment(Moment $moment)
    {
        self::$moment = $moment;
    }

    /**
     * @param string $locale
     * @param bool   $findSimilar
     *
     * @return void
     * @throws MomentException
     */
    public static function setLocale($locale, $findSimilar = false)
    {
        self::$locale = $locale;
        self::$findSimilar = $findSimilar;
        self::loadLocaleContent();
    }

    /**
     * @return void
     * @throws MomentException
     */
    public static function loadLocaleContent()
    {
        $pathFile = self::findLocaleFile();

        if (!$pathFile)
        {
            throw new MomentException('Locale does not exist: ' . $pathFile);
        }

        /** @noinspection PhpIncludeInspection */
        self::$localeContent = require $pathFile;
    }

    /**
     * @return array
     */
    public static function getLocaleContent()
    {
        return self::$localeContent;
    }

    /**
     * @param array $keys
     *
     * @return array|string|\Closure
     * @throws MomentException
     */
    public static function getLocaleString(array $keys)
    {
        $string = self::$localeContent;

        foreach ($keys as $key)
        {
            if (isset($string[$key]) === false)
            {
                if ($key == 'monthsNominative' && isset($string['months']))
                {
                    $string = $string['months'];
                    continue;
                }

                throw new MomentException('Locale string does not exist for key: ' . join(' > ', $keys));
            }

            $string = $string[$key];
        }

        return $string;
    }

    /**
     * @param array $localeKeys
     * @param array $formatArgs
     *
     * @return string
     * @throws MomentException
     */
    public static function renderLocaleString(array $localeKeys, array $formatArgs = array())
    {
        // get locale handler
        $localeString = self::getLocaleString($localeKeys);

        // handle callback
        if ($localeString instanceof \Closure)
        {
            $localeString = call_user_func_array($localeString, $formatArgs);
        }

        return vsprintf($localeString, $formatArgs);
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public static function prepareSpecialLocaleTags($format)
    {
        $placeholders = array(
            // months
            '(?<!\\\)F' => 'n__0001',
            '(?<!\\\)M' => 'n__0002',
            '(?<!\\\)f' => 'n__0005',
            // weekdays
            '(?<!\\\)l' => 'N__0003',
            '(?<!\\\)D' => 'N__0004',
        );

        foreach ($placeholders as $regexp => $tag)
        {
            $format = preg_replace('/' . $regexp . '/u', $tag, $format);
        }

        return $format;
    }

    /**
     * @param string $format
     *
     * @return string
     * @throws MomentException
     */
    public static function renderSpecialLocaleTags($format)
    {
        $placeholders = array(
            // months
            '\d{1,2}__0001' => 'months',
            '\d{1,2}__0002' => 'monthsShort',
            '\d{1,2}__0005' => 'monthsNominative',
            // weekdays
            '\d__0003'      => 'weekdays',
            '\d__0004'      => 'weekdaysShort',
        );

        foreach ($placeholders as $regexp => $tag)
        {
            preg_match_all('/(' . $regexp . ')/', $format, $match);

            if (isset($match[1]))
            {
                foreach ($match[1] as $date)
                {
                    list($localeIndex, $type) = explode('__', $date);
                    $localeString = self::renderLocaleString(array($tag, --$localeIndex));
                    $format = preg_replace('/' . $date . '/u', $localeString, $format);
                }
            }
        }

        return $format;
    }

    /**
     * @return null|string
     */
    private static function findLocaleFile()
    {
        $basePathFile = __DIR__ . '/Locales/' . self::$locale;
        $pathFile = $basePathFile . '.php';

        if (file_exists($pathFile) === false)
        {
            $pathFile = null;

            if (self::$findSimilar && $similarLocales = self::fetchSimilarLocales($basePathFile))
            {
                $pathFile = $similarLocales[0];
            }
        }

        return $pathFile;
    }

    /**
     * @param string $path
     *
     * @return null|array
     */
    private static function fetchSimilarLocales($path)
    {
        $locales = glob($path . '*.php');

        if ($locales && !empty($locales))
        {
            return $locales;
        }

        return null;
    }
}

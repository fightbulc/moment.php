<?php

namespace Moment;

/**
 * Improved MomentLocale with enhanced security
 * This is a demonstration of security improvements
 */
class MomentLocaleImproved
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
     * @var array Cache for loaded locales
     */
    private static $localeCache = array();

    /**
     * @var array Rate limiting for locale loads
     */
    private static $localeLoadCount = array();

    /**
     * @var int Maximum locale loads per hour
     */
    private static $localeLoadLimit = 100;

    /**
     * @var array Whitelist of allowed locales
     */
    private static $allowedLocales = null;

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
     * @param bool   $fallbackToDefault
     *
     * @return void
     * @throws MomentException
     */
    public static function setLocale($locale, $findSimilar = false, $fallbackToDefault = true)
    {
        // Sanitize locale input
        $locale = self::sanitizeLocale($locale);
        
        try {
            self::$locale = $locale;
            self::$findSimilar = $findSimilar;
            self::loadLocaleContent();
        } catch (MomentException $e) {
            if ($fallbackToDefault && $locale !== 'en_US') {
                self::setLocale('en_US', false, false);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Sanitize locale string to prevent path traversal
     *
     * @param string $locale
     * @return string
     */
    private static function sanitizeLocale($locale)
    {
        // Only allow alphanumeric, underscore, and hyphen
        return preg_replace('/[^a-zA-Z0-9_-]/', '', $locale);
    }

    /**
     * @return void
     * @throws MomentException
     */
    public static function loadLocaleContent()
    {
        $locale = self::$locale;
        
        // Check cache first
        if (isset(self::$localeCache[$locale])) {
            self::$localeContent = self::$localeCache[$locale];
            return;
        }
        
        // Check rate limiting
        self::checkLocaleLoadLimit($locale);
        
        $pathFile = self::findLocaleFile();

        if (!$pathFile) {
            throw new MomentException('Locale does not exist: ' . $locale);
        }

        // Load and validate locale content
        $content = self::loadAndValidateLocaleFile($pathFile);
        
        // Cache the content
        self::$localeCache[$locale] = $content;
        self::$localeContent = $content;
    }

    /**
     * Load and validate locale file content
     *
     * @param string $pathFile
     * @return array
     * @throws MomentException
     */
    private static function loadAndValidateLocaleFile($pathFile)
    {
        // Verify the file is within our locales directory
        $realPath = realpath($pathFile);
        $expectedDir = realpath(__DIR__ . '/Locales');
        
        if ($realPath === false || strpos($realPath, $expectedDir) !== 0) {
            throw new MomentException('Invalid locale file path');
        }
        
        /** @noinspection PhpIncludeInspection */
        $content = require $realPath;
        
        // Validate content is an array
        if (!is_array($content)) {
            throw new MomentException('Invalid locale file format: must return an array');
        }
        
        // Validate required keys exist
        $requiredKeys = ['months', 'monthsShort', 'weekdays', 'weekdaysShort', 'relativeTime'];
        foreach ($requiredKeys as $key) {
            if (!isset($content[$key])) {
                throw new MomentException("Missing required key '$key' in locale file");
            }
        }
        
        // Validate array structures
        if (!is_array($content['months']) || count($content['months']) !== 12) {
            throw new MomentException('Invalid months array: must contain 12 elements');
        }
        
        if (!is_array($content['weekdays']) || count($content['weekdays']) !== 7) {
            throw new MomentException('Invalid weekdays array: must contain 7 elements');
        }
        
        return $content;
    }

    /**
     * Check rate limiting for locale loading
     *
     * @param string $locale
     * @throws MomentException
     */
    private static function checkLocaleLoadLimit($locale)
    {
        $key = $locale . '_' . date('YmdH');
        
        if (!isset(self::$localeLoadCount[$key])) {
            self::$localeLoadCount[$key] = 0;
        }
        
        if (++self::$localeLoadCount[$key] > self::$localeLoadLimit) {
            throw new MomentException('Locale load limit exceeded for: ' . $locale);
        }
        
        // Clean up old entries (older than 2 hours)
        $currentHour = date('YmdH');
        foreach (self::$localeLoadCount as $k => $v) {
            if (substr($k, -10) < date('YmdH', strtotime('-2 hours'))) {
                unset(self::$localeLoadCount[$k]);
            }
        }
    }

    /**
     * Get list of allowed locales
     *
     * @return array
     */
    private static function getAllowedLocales()
    {
        if (self::$allowedLocales === null) {
            // Scan the Locales directory for valid locale files
            $localesDir = __DIR__ . '/Locales/';
            $files = glob($localesDir . '*.php');
            self::$allowedLocales = array();
            
            foreach ($files as $file) {
                $locale = basename($file, '.php');
                // Validate locale name format
                if (preg_match('/^[a-zA-Z]{2,3}(_[A-Z]{2})?$/', $locale)) {
                    self::$allowedLocales[] = $locale;
                }
            }
        }
        
        return self::$allowedLocales;
    }

    /**
     * @return null|string
     */
    private static function findLocaleFile()
    {
        // Ensure locale is in whitelist
        $allowedLocales = self::getAllowedLocales();
        if (!in_array(self::$locale, $allowedLocales, true)) {
            // Check if findSimilar is enabled
            if (self::$findSimilar) {
                $similar = self::findSimilarLocale(self::$locale, $allowedLocales);
                if ($similar) {
                    self::$locale = $similar;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        }
        
        $pathFile = __DIR__ . '/Locales/' . self::$locale . '.php';
        
        if (file_exists($pathFile)) {
            return $pathFile;
        }
        
        return null;
    }

    /**
     * Find a similar locale from the allowed list
     *
     * @param string $locale
     * @param array $allowedLocales
     * @return string|null
     */
    private static function findSimilarLocale($locale, $allowedLocales)
    {
        // Try to find locale with same language code
        $langCode = substr($locale, 0, 2);
        
        foreach ($allowedLocales as $allowed) {
            if (strpos($allowed, $langCode) === 0) {
                return $allowed;
            }
        }
        
        return null;
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

        foreach ($keys as $key) {
            if (isset($string[$key]) === false) {
                if ($key == 'monthsNominative' && isset($string['months'])) {
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
        if ($localeString instanceof \Closure) {
            $localeString = call_user_func_array($localeString, $formatArgs);
        }

        // Validate string before sprintf
        if (!is_string($localeString)) {
            throw new MomentException('Locale string must be a string, got: ' . gettype($localeString));
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

        foreach ($placeholders as $regexp => $tag) {
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

        foreach ($placeholders as $regexp => $tag) {
            preg_match_all('/(' . $regexp . ')/', $format, $match);

            if (isset($match[1])) {
                foreach ($match[1] as $date) {
                    list($localeIndex, $type) = explode('__', $date);
                    
                    // Validate locale index is within bounds
                    $localeIndex = (int)$localeIndex - 1;
                    
                    // Get the locale array to check bounds
                    $localeArray = self::getLocaleString(array($tag));
                    if (!is_array($localeArray) || !isset($localeArray[$localeIndex])) {
                        throw new MomentException("Invalid locale index: $localeIndex for $tag");
                    }
                    
                    $localeString = self::renderLocaleString(array($tag, $localeIndex));
                    $format = preg_replace('/' . $date . '/u', $localeString, $format);
                }
            }
        }

        return $format;
    }

    /**
     * Clear all caches (useful for testing)
     */
    public static function clearCache()
    {
        self::$localeCache = array();
        self::$localeLoadCount = array();
        self::$allowedLocales = null;
    }
}
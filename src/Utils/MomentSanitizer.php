<?php

namespace Moment\Utils;

use Moment\Exceptions\MomentValidationException;
use Moment\Exceptions\MomentTimezoneException;
use Moment\Exceptions\MomentSecurityException;

/**
 * Sanitizer utility for Moment input validation
 */
class MomentSanitizer
{
    /**
     * Regular expression for valid locale format
     */
    private const LOCALE_PATTERN = '/^[a-zA-Z]{2,3}(_[A-Z]{2})?$/';
    
    /**
     * Maximum length for various inputs
     */
    private const MAX_LOCALE_LENGTH = 10;
    private const MAX_TIMEZONE_LENGTH = 64;
    private const MAX_FORMAT_LENGTH = 256;
    
    /**
     * Sanitize and validate a locale string
     *
     * @param string $locale
     * @return string
     * @throws MomentValidationException
     */
    public static function sanitizeLocale(string $locale): string
    {
        // Check length
        if (strlen($locale) > self::MAX_LOCALE_LENGTH) {
            throw new MomentValidationException(
                'locale',
                $locale,
                'exceeds maximum length of ' . self::MAX_LOCALE_LENGTH
            );
        }
        
        // Remove any potentially dangerous characters
        $sanitized = preg_replace('/[^a-zA-Z0-9_-]/', '', $locale);
        
        // Validate format
        if (!preg_match(self::LOCALE_PATTERN, $sanitized)) {
            throw new MomentValidationException(
                'locale',
                $locale,
                'invalid format, expected format like "en_US" or "fr_FR"'
            );
        }
        
        return $sanitized;
    }
    
    /**
     * Validate a timezone string
     *
     * @param string $timezone
     * @return string
     * @throws MomentTimezoneException
     */
    public static function sanitizeTimezone(string $timezone): string
    {
        // Check length
        if (strlen($timezone) > self::MAX_TIMEZONE_LENGTH) {
            throw new MomentTimezoneException(
                $timezone,
                'exceeds maximum length of ' . self::MAX_TIMEZONE_LENGTH
            );
        }
        
        // Get list of valid timezones
        $validTimezones = timezone_identifiers_list();
        
        // Check if timezone is valid
        if (!in_array($timezone, $validTimezones, true)) {
            // Try to find a similar timezone
            $similar = self::findSimilarTimezone($timezone, $validTimezones);
            if ($similar) {
                throw new MomentTimezoneException(
                    $timezone,
                    "is invalid, did you mean '$similar'?"
                );
            } else {
                throw new MomentTimezoneException($timezone, 'is not a valid timezone');
            }
        }
        
        return $timezone;
    }
    
    /**
     * Sanitize a date format string
     *
     * @param string $format
     * @return string
     * @throws MomentValidationException
     */
    public static function sanitizeDateFormat(string $format): string
    {
        // Check length
        if (strlen($format) > self::MAX_FORMAT_LENGTH) {
            throw new MomentValidationException(
                'format',
                $format,
                'exceeds maximum length of ' . self::MAX_FORMAT_LENGTH
            );
        }
        
        // Check for potentially dangerous patterns
        if (preg_match('/[`$(){}<>]/', $format)) {
            throw new MomentSecurityException(
                'sanitizeDateFormat',
                'format contains potentially dangerous characters'
            );
        }
        
        return $format;
    }
    
    /**
     * Validate a numeric value is within reasonable bounds
     *
     * @param float|int $value
     * @param string $name
     * @param float|int $min
     * @param float|int $max
     * @return float|int
     * @throws MomentValidationException
     */
    public static function validateNumericRange($value, string $name, $min, $max)
    {
        if (!is_numeric($value)) {
            throw new MomentValidationException(
                $name,
                $value,
                'must be numeric'
            );
        }
        
        if ($value < $min || $value > $max) {
            throw new MomentValidationException(
                $name,
                $value,
                "must be between $min and $max"
            );
        }
        
        return $value;
    }
    
    /**
     * Sanitize a file path (for internal use only)
     *
     * @param string $path
     * @return string
     * @throws MomentSecurityException
     */
    public static function sanitizePath(string $path): string
    {
        // Remove any null bytes
        $path = str_replace(chr(0), '', $path);
        
        // Check for directory traversal attempts
        if (preg_match('/\.\.[\\/]/', $path)) {
            throw new MomentSecurityException(
                'sanitizePath',
                'path traversal attempt detected'
            );
        }
        
        // Convert to real path
        $realPath = realpath($path);
        
        if ($realPath === false) {
            throw new MomentSecurityException(
                'sanitizePath',
                'invalid or non-existent path'
            );
        }
        
        return $realPath;
    }
    
    /**
     * Find a similar timezone from the list
     *
     * @param string $input
     * @param array $validTimezones
     * @return string|null
     */
    private static function findSimilarTimezone(string $input, array $validTimezones): ?string
    {
        $input = strtolower($input);
        $bestMatch = null;
        $bestScore = PHP_INT_MAX;
        
        foreach ($validTimezones as $tz) {
            $distance = levenshtein(strtolower($tz), $input);
            if ($distance < $bestScore && $distance <= 5) {
                $bestScore = $distance;
                $bestMatch = $tz;
            }
        }
        
        return $bestMatch;
    }
    
    /**
     * Validate an array has expected structure
     *
     * @param array $array
     * @param array $requiredKeys
     * @param string $name
     * @throws MomentValidationException
     */
    public static function validateArrayStructure(array $array, array $requiredKeys, string $name): void
    {
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $array)) {
                throw new MomentValidationException(
                    $name,
                    'array',
                    "missing required key '$key'"
                );
            }
        }
    }
    
    /**
     * Escape output for safe display
     *
     * @param string $string
     * @return string
     */
    public static function escapeOutput(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
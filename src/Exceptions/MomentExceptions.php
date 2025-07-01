<?php

namespace Moment\Exceptions;

/**
 * Base exception class with context support
 */
class MomentException extends \Exception
{
    /**
     * @var array
     */
    private $context = [];

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param array $context
     */
    public function __construct($message = "", $code = 0, ?\Throwable $previous = null, array $context = [])
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * Get exception context
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Get formatted message with context
     *
     * @return string
     */
    public function getDetailedMessage(): string
    {
        $message = $this->getMessage();
        
        if (!empty($this->context)) {
            $message .= ' [Context: ' . json_encode($this->context) . ']';
        }
        
        return $message;
    }
}

/**
 * Exception for locale-related errors
 */
class MomentLocaleException extends MomentException
{
    /**
     * @param string $locale
     * @param string $reason
     * @param \Throwable|null $previous
     */
    public function __construct($locale, $reason = 'not found', ?\Throwable $previous = null)
    {
        $message = "Locale '$locale' $reason";
        $context = ['locale' => $locale, 'reason' => $reason];
        
        parent::__construct($message, 0, $previous, $context);
    }
}

/**
 * Exception for format-related errors
 */
class MomentFormatException extends MomentException
{
    /**
     * @param string $format
     * @param string $reason
     * @param \Throwable|null $previous
     */
    public function __construct($format, $reason = 'is invalid', ?\Throwable $previous = null)
    {
        $message = "Format '$format' $reason";
        $context = ['format' => $format, 'reason' => $reason];
        
        parent::__construct($message, 0, $previous, $context);
    }
}

/**
 * Exception for timezone-related errors
 */
class MomentTimezoneException extends MomentException
{
    /**
     * @param string $timezone
     * @param string $reason
     * @param \Throwable|null $previous
     */
    public function __construct($timezone, $reason = 'is invalid', ?\Throwable $previous = null)
    {
        $message = "Timezone '$timezone' $reason";
        $context = ['timezone' => $timezone, 'reason' => $reason];
        
        parent::__construct($message, 0, $previous, $context);
    }
}

/**
 * Exception for validation errors
 */
class MomentValidationException extends MomentException
{
    /**
     * @param string $field
     * @param mixed $value
     * @param string $reason
     * @param \Throwable|null $previous
     */
    public function __construct($field, $value, $reason, ?\Throwable $previous = null)
    {
        $message = "Validation failed for '$field': $reason";
        $context = [
            'field' => $field,
            'value' => $value,
            'reason' => $reason
        ];
        
        parent::__construct($message, 0, $previous, $context);
    }
}

/**
 * Exception for security-related errors
 */
class MomentSecurityException extends MomentException
{
    /**
     * @param string $operation
     * @param string $reason
     * @param \Throwable|null $previous
     */
    public function __construct($operation, $reason, ?\Throwable $previous = null)
    {
        $message = "Security violation in '$operation': $reason";
        $context = [
            'operation' => $operation,
            'reason' => $reason,
            'timestamp' => time()
        ];
        
        parent::__construct($message, 0, $previous, $context);
    }
}
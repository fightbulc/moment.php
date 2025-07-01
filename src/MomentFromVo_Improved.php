<?php

namespace Moment;

use Moment\Exceptions\MomentValidationException;

/**
 * Improved MomentFromVo with enhanced validation and type safety
 * This is a demonstration of security and quality improvements
 */
class MomentFromVoImproved
{
    /**
     * @var Moment
     */
    private Moment $moment;

    /**
     * @var string
     */
    private string $direction = 'past';

    /**
     * @var int
     */
    private int $seconds = 0;

    /**
     * @var float
     */
    private float $minutes = 0.0;

    /**
     * @var float
     */
    private float $hours = 0.0;

    /**
     * @var float
     */
    private float $days = 0.0;

    /**
     * @var float
     */
    private float $weeks = 0.0;

    /**
     * Valid direction values
     */
    private const VALID_DIRECTIONS = ['-', '+', 'future', 'past'];

    /**
     * @param Moment $moment
     */
    public function __construct(Moment $moment)
    {
        $this->moment = $moment;
    }

    /**
     * @return Moment
     */
    public function getMoment(): Moment
    {
        return $this->moment;
    }

    /**
     * @param float $value
     * @return float
     */
    protected function getRoundedValue(float $value): float
    {
        $value = round($value, 2);

        if ($this->getDirection() === 'future') {
            $value = -$value;
        }

        return $value;
    }

    /**
     * @param string $direction
     * @return self
     * @throws MomentValidationException
     */
    public function setDirection(string $direction): self
    {
        if (!in_array($direction, self::VALID_DIRECTIONS, true)) {
            throw new MomentValidationException(
                'direction',
                $direction,
                'must be one of: ' . implode(', ', self::VALID_DIRECTIONS)
            );
        }

        $this->direction = $direction;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction === '-' ? 'future' : 'past';
    }

    /**
     * @param float $days
     * @return self
     * @throws MomentValidationException
     */
    public function setDays(float $days): self
    {
        if ($days < 0) {
            throw new MomentValidationException('days', $days, 'cannot be negative');
        }

        $this->days = $days;
        return $this;
    }

    /**
     * @return float
     */
    public function getDays(): float
    {
        return $this->getRoundedValue($this->days);
    }

    /**
     * @param float $hours
     * @return self
     * @throws MomentValidationException
     */
    public function setHours(float $hours): self
    {
        if ($hours < 0) {
            throw new MomentValidationException('hours', $hours, 'cannot be negative');
        }

        $this->hours = $hours;
        return $this;
    }

    /**
     * @return float
     */
    public function getHours(): float
    {
        return $this->getRoundedValue($this->hours);
    }

    /**
     * @param float $minutes
     * @return self
     * @throws MomentValidationException
     */
    public function setMinutes(float $minutes): self
    {
        if ($minutes < 0) {
            throw new MomentValidationException('minutes', $minutes, 'cannot be negative');
        }

        $this->minutes = $minutes;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinutes(): float
    {
        return $this->getRoundedValue($this->minutes);
    }

    /**
     * @param int $seconds
     * @return self
     * @throws MomentValidationException
     */
    public function setSeconds(int $seconds): self
    {
        if ($seconds < 0) {
            throw new MomentValidationException('seconds', $seconds, 'cannot be negative');
        }

        $this->seconds = $seconds;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeconds(): int
    {
        return (int)$this->getRoundedValue((float)$this->seconds);
    }

    /**
     * @param float $weeks
     * @return self
     * @throws MomentValidationException
     */
    public function setWeeks(float $weeks): self
    {
        if ($weeks < 0) {
            throw new MomentValidationException('weeks', $weeks, 'cannot be negative');
        }

        $this->weeks = $weeks;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeeks(): float
    {
        return $this->getRoundedValue($this->weeks);
    }

    /**
     * @return float
     */
    public function getMonths(): float
    {
        return $this->getRoundedValue($this->weeks / 4);
    }

    /**
     * @return float
     */
    public function getYears(): float
    {
        return $this->getRoundedValue($this->days / 365);
    }

    /**
     * @return string
     * @throws \Moment\MomentException
     */
    public function getRelative(): string
    {
        $formatArgs = [];

        if ($this->valueInRange($this->getSeconds(), 0, 4)) {
            $localeKeys = ['relativeTime', 's'];
            $formatArgs[] = 1;
        } elseif ($this->valueInRange($this->getSeconds(), 4, 60)) {
            $localeKeys = ['relativeTime', 'ss'];
            $formatArgs[] = $this->roundAbs($this->getSeconds());
        } elseif ($this->valueInRange($this->getSeconds(), 60, 90)) {
            $localeKeys = ['relativeTime', 'm'];
            $formatArgs[] = 1;
        } elseif ($this->valueInRange($this->getSeconds(), 90, 45 * 60)) {
            $localeKeys = ['relativeTime', 'mm'];
            $formatArgs[] = $this->roundAbs($this->getMinutes());
        } elseif ($this->valueInRange($this->getMinutes(), 45, 90)) {
            $localeKeys = ['relativeTime', 'h'];
            $formatArgs[] = 1;
        } elseif ($this->valueInRange($this->getMinutes(), 90, 22 * 60)) {
            $localeKeys = ['relativeTime', 'hh'];
            $formatArgs[] = $this->roundAbs($this->getHours());
        } elseif ($this->valueInRange($this->getHours(), 22, 36)) {
            $localeKeys = ['relativeTime', 'd'];
            $formatArgs[] = 1;
        } elseif ($this->valueInRange($this->getHours(), 36, 25 * 24)) {
            $localeKeys = ['relativeTime', 'dd'];
            $formatArgs[] = $this->roundAbs($this->getDays());
        } elseif ($this->valueInRange($this->getDays(), 25, 45)) {
            $localeKeys = ['relativeTime', 'M'];
            $formatArgs[] = 1;
        } elseif ($this->valueInRange($this->getDays(), 45, 345)) {
            $localeKeys = ['relativeTime', 'MM'];
            $formatArgs[] = $this->roundAbs($this->getMonths());
        } elseif ($this->valueInRange($this->getDays(), 345, 548)) {
            $localeKeys = ['relativeTime', 'y'];
            $formatArgs[] = 1;
        } else {
            $localeKeys = ['relativeTime', 'yy'];
            $formatArgs[] = $this->roundAbs($this->getYears());
        }

        // add to context
        $formatArgs[] = $this->getDirection();
        $formatArgs[] = $this->getMoment();

        // render value
        $time = MomentLocale::renderLocaleString($localeKeys, $formatArgs);

        // render value result by direction string
        return MomentLocale::renderLocaleString(['relativeTime', $this->getDirection()], [$time]);
    }

    /**
     * Check if a value is within a specific range
     *
     * @param float $value
     * @param float $from
     * @param float $to
     * @return bool
     */
    private function valueInRange(float $value, float $from, float $to): bool
    {
        $absValue = abs($value);
        return $absValue >= $from && $absValue < $to;
    }

    /**
     * Get the absolute rounded value
     *
     * @param float $number
     * @return float
     */
    private function roundAbs(float $number): float
    {
        return round(abs($number));
    }

    /**
     * Create an immutable copy with a modified value
     *
     * @param string $property
     * @param mixed $value
     * @return self
     */
    public function with(string $property, $value): self
    {
        $clone = clone $this;
        $setter = 'set' . ucfirst($property);
        
        if (!method_exists($clone, $setter)) {
            throw new MomentValidationException(
                'property',
                $property,
                "no setter method '$setter' exists"
            );
        }
        
        $clone->$setter($value);
        return $clone;
    }

    /**
     * Convert to array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'direction' => $this->getDirection(),
            'seconds' => $this->getSeconds(),
            'minutes' => $this->getMinutes(),
            'hours' => $this->getHours(),
            'days' => $this->getDays(),
            'weeks' => $this->getWeeks(),
            'months' => $this->getMonths(),
            'years' => $this->getYears(),
            'relative' => $this->getRelative(),
        ];
    }
}
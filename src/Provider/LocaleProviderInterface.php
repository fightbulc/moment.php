<?php

namespace Moment\Provider;

/**
 * Interface LocaleProviderInterface
 * @package Moment\Provider
 *
 * @author xZero707 <xzero@elite7hackers.net>
 *
 * Provider interface which MUST be implemented by locale
 */
interface LocaleProviderInterface
{

    /**
     * Get locale name
     *
     * @return string
     */
    public function getName();

    /**
     * Get specific definition
     *
     * eg. getDefinition('monthsNominative')
     *
     * @param string $name
     * @param callable|null $callback
     *
     * @return mixed
     */
    public function getDefinition($name, callable $callback = null);

    /**
     * Get all locale definitions
     *
     * @param callable|null $callback
     *
     * @return array
     */
    public function getDefinitions(callable $callback = null);
}
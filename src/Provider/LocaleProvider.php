<?php

namespace Moment\Provider;

use ReflectionClass;
use Moment\Helpers\ArrayHelpers;

/**
 * Class LocaleProvider
 * @package Moment\Provider
 *
 * @author xZero707 <xzero@elite7hackers.net>
 */
abstract class LocaleProvider implements LocaleProviderInterface
{
    /** @var array */
    protected $localeDefinitions;

    /** @var string */
    protected $localeName;

    /**
     * LocaleProvider constructor.
     *
     * @param array|null $definitions
     */
    final public function __construct(array $definitions = null)
    {
        $this->localeName        = (new ReflectionClass(static::class))->getShortName();
        $this->localeDefinitions = [];

        $this->defineLocale($definitions);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->localeName;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($name, callable $callback = null)
    {
        if (isset($this->localeDefinitions[$name])) {
            $definition = $this->localeDefinitions[$name];

            return ($callback !== null) ? $callback($definition) : $definition;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions(callable $callback = null)
    {
        return ($callback !== null) ? $callback($this->localeDefinitions) : $this->localeDefinitions;
    }

    /**
     * Declares definitions - by replacing whole array with a fresh one
     *
     * @param array $definitions
     */
    protected function setDefinitions(array $definitions)
    {
        $this->localeDefinitions = $definitions;
    }

    /**
     * Allows overriding definitions
     *
     * @param array $definitionsSet
     */
    protected function alterDefinitions(array $definitionsSet)
    {
        $arrayHelpers            = new ArrayHelpers();
        $this->localeDefinitions =
            $arrayHelpers->array_merge_recursive_distinct($this->localeDefinitions, $definitionsSet);
    }

    /**
     * This is setup stub, kind of constructor. Runs every time locale is initialized
     *
     * @param array|null $definitions
     *
     * @return void
     */
    abstract protected function defineLocale(array $definitions = null);
}
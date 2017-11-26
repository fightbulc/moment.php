<?php

namespace Moment\Provider;

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

    public function __construct($name)
    {
        $this->localeName        = $name;
        $this->localeDefinitions = [];
    }

    protected function setDefinitions(array $definitions)
    {
        $this->localeDefinitions = $definitions;
    }

    protected function alterDefinitions(array $definitionsSet)
    {
        $arrayHelpers            = new ArrayHelpers();
        $this->localeDefinitions =
            $arrayHelpers->array_merge_recursive_distinct($this->localeDefinitions, $definitionsSet);
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

}
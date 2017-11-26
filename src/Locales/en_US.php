<?php

namespace Moment\Locales;

/**
 * Class en_US
 * @package Moment\Locales
 *
 * American english (en_US) locale
 *
 * @author Unknown <--- unknown --->
 */
class en_US extends en_GB
{
    /**
     * {@inheritdoc}
     */
    protected function defineLocale(array $definitions = null)
    {
        parent::defineLocale([
            'calendar' => [
                'withTime' => '[at] h:i A',
                'default'  => 'm/d/Y'
            ],
            'week'     => [
                'dow' => 7
            ]
        ]);

        if ($definitions !== null) {
            $this->alterDefinitions($definitions);
        }
    }
}

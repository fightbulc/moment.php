<?php

namespace Moment\Locales;

use Moment\Helpers\ArrayHelpers;
use Moment\Provider\LocaleProviderInterface;

/**
 * Class no_NB
 * @package Moment\Locales
 *
 * Norwegian locale
 */
class no_NB implements LocaleProviderInterface
{
    /** @var array */
    private $localeDefinitions;

    /** @var string */
    private $localeName;

    /**
     * no_NB constructor.
     *
     * @param array|null $definitions - Allows overriding or adding new definitions on the fly
     */
    public function __construct(array $definitions = null)
    {
        $this->localeName        = 'nb_NO';
        $this->localeDefinitions = [

            'months'        => explode('_',
                'Januar_Februar_Mars_April_Mai_Juni_Juli_August_September_Oktober_November_Desember'),
            'monthsShort'   => explode('_', 'Jan_Feb_Mar_Apr_Mai_Jun_Jul_Aug_Sep_Okt_Nov_Dec'),
            'weekdays'      => explode('_', 'Måndag_Tirsdag_Onsdag_Torsdag_Fredag_Lørdag_Søndag'),
            'weekdaysShort' => explode('_', 'Mån_Tir_Ons_Tor_Fre_Lør_Søn'),

            'calendar' => [
                'sameDay'  => '[Idag]',
                'nextDay'  => '[Imorgen]',
                'lastDay'  => '[Igår]',
                'lastWeek' => '[Forrige] l',
                'sameElse' => 'l',
                'withTime' => '[kl] H:i',
                'default'  => 'Y/m/d',
            ],

            'relativeTime' => [
                'future' => 'om %s',
                'past'   => '%s sent',
                's'      => 'få sekunder',
                'm'      => 'en minut',
                'mm'     => '%d minuter',
                'h'      => 'en timme',
                'hh'     => '%d timmar',
                'd'      => 'en dag',
                'dd'     => '%d dagar',
                'M'      => 'en månad',
                'MM'     => '%d månader',
                'y'      => 'ett år',
                'yy'     => '%d år',
            ],

            'ordinal' => function ($number) {
                return $number;
            },

            'week' => [
                'dow' => 1, // Monday is the first day of the week.
                'doy' => 4  // The week that contains Jan 4th is the first week of the year.
            ]

        ];

        // Apply $definitions if array is supplied
        if ($definitions !== null) {
            $arrayHelpers            = new ArrayHelpers();
            $this->localeDefinitions =
                $arrayHelpers->array_merge_recursive_distinct($this->localeDefinitions, $definitions);
        }
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

// locale: Swedish (se-SV)
// author: Martin Trobäck https://github.com/lekoaf

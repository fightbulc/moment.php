<?php

namespace Moment\Locales;

use Moment\Provider\LocaleProvider;

/**
 * Class no_NB
 * @package Moment\Locales
 *
 * Norwegian locale
 *
 * @author xZero707 <xzero@elite7hackers.net>
 */
class no_NB extends LocaleProvider
{
    /**
     * {@inheritdoc}
     */
    protected function defineLocale(array $definitions = null)
    {
        $this->setDefinitions([

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

        ]);


        // Apply $definitions if array is supplied
        if ($definitions !== null) {
            $this->alterDefinitions($definitions);
        }
    }
}

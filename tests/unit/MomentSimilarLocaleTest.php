<?php

namespace Moment\Test\Unit;

use Moment\Moment;
use Moment\MomentException;

class MomentSimilarLocaleTest extends MomentBritishEnglishLocaleTest
{
    /**
     * @throws MomentException
     */
    protected function setUp(): void
    {
        Moment::setLocale('en', true);
    }
}

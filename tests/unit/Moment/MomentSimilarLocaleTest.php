<?php

namespace Moment;

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

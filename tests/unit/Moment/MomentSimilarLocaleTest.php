<?php

namespace Moment;

class MomentSimilarLocaleTest extends MomentBritishEnglishLocaleTest
{
    /**
     * @throws MomentException
     */
    public function setUp(): void
    {
        Moment::setLocale('en', true);
    }
}

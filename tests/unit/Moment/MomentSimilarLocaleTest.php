<?php

namespace Moment;

class MomentSimilarLocaleTest extends MomentBritishEnglishLocaleTest
{
    /**
     * @throws MomentException
     */
    public function setUp()
    {
        Moment::setLocale('en', true);
    }
}

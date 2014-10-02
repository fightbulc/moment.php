<?php

/**
 * Wrapper for PHP's DateTime class inspired by moment.js
 *
 * @author  Tino Ehrich <ehrich@efides.com>
 * @version See composer.json
 *
 * @dependencies  >= PHP 5.3.0
 */

namespace Moment;

interface FormatsInterface
{
    public function format($format);
} 
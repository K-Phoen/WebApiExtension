<?php

/*
 * This file is part of the Behat WebApiExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\WebApiExtension\Differ;

use Coduo\PHPMatcher\Matcher;

/**
 * Relies on coduo/php-matcher to perform partiel diffs between two json inputs
 *
 * @author Jakub Zalas <jakub@zalas.pl>
 */
class CoduoDiffer implements Differ
{
    /**
     * @var Matcher
     */
    private $matcher;

    /**
     * @param Matcher $matcher
     */
    public function __construct(Matcher $matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * {@inheritdoc}
     */
    public function diff($actual, $expected)
    {
        if (!$this->matcher->match($actual, $expected)) {
            return $this->matcher->getError();
        }
    }
}

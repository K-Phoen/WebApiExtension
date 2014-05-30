<?php

/*
 * This file is part of the Behat WebApiExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\WebApiExtension\Differ;

/**
 * @author Jakub Zalas <jakub@zalas.pl>
 */
interface Differ
{
    /**
     * @param string $actual
     * @param string $expected
     *
     * @return string|null A difference or null
     */
    public function diff($actual, $expected);
}

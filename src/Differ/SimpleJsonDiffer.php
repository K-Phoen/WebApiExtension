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
 * Performs strict diffs between two json inputs
 *
 * @author Jakub Zalas <jakub@zalas.pl>
 */
class SimpleJsonDiffer implements Differ
{
    /**
     * {@inheritdoc}
     */
    public function diff($actual, $expected)
    {
        $actualJson = json_decode($actual);
        $expectedJson = json_decode($expected);

        if ($expectedJson != $actualJson) {
            return sprintf('Expected to get "%s" but received: "%s"', json_encode($expectedJson, JSON_PRETTY_PRINT), json_encode($actualJson, JSON_PRETTY_PRINT));
        }
    }
}

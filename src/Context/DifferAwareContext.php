<?php

/*
 * This file is part of the Behat WebApiExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\WebApiExtension\Context;

use Behat\Behat\Context\Context;
use Behat\WebApiExtension\Differ\Differ;

interface DifferAwareContext extends Context
{
    public function setDiffer(Differ $differ);
}

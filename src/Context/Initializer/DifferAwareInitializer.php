<?php

/*
 * This file is part of the Behat WebApiExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\WebApiExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Behat\WebApiExtension\Context\DifferAwareContext;
use Behat\WebApiExtension\Differ\Differ;

/**
 * Differ-aware contexts initializer.
 *
 * Sets Diff instance to the DifferAwareContext.
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class DifferAwareInitializer implements ContextInitializer
{
    /**
     * @var Differ
     */
    private $differ;

    /**
     * Initializes initializer.
     *
     * @param Client $client
     */
    public function __construct(Differ $differ)
    {
        $this->differ = $differ;
    }

    /**
     * Initializes provided context.
     *
     * @param Context $context
     */
    public function initializeContext(Context $context)
    {
        if ($context instanceof DifferAwareContext) {
            $context->setDiffer($this->differ);
        }
    }
}

<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Filter;

use Symfony\Component\EventDispatcher\Event;

/**
 * Generate internal links.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class InternalLinksFilter extends BaseFilter
{

    protected function doFilter($contents)
    {
        // @todo 

        return $contents;
    }

}

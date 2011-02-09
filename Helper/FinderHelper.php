<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Helper;

/**
 * FinderHelper
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Finder\Finder;

class FinderHelper extends Helper
{

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'finder';
    }

    /**
     * @param Finder $finder
     * @param type $base
     * @return array
     */
    public function tree(Finder $finder, $base = '/')
    {
        $tree = array();
        foreach ($finder as $file) {
            $path = explode('/', $file->getPathname());
            $current = $tree;
            while ($path_step = next($path)) {
                if (!isset($current[$path_step])) {
                    $current[$path_step] = array();
                }
            }
            $current[$path_step] = $file;
        }

        return $tree;
    }

}

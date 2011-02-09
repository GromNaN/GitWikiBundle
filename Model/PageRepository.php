<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Model;

use Git\Core\Repository;
use Symfony\Component\Finder\Finder;

/**
 * Wiki page repository (ie Git repository)
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class PageRepository extends Repository
{

    /**
     * Read or create a page file in the repository.
     *
     * @param string $name
     * @return Git\Repository\Page
     */
    public function getPage($name)
    {
        return new Page($this, $name);
    }

    /**
     * Get the list of every pages in the repository.
     *
     * @return Symfony\Component\Finder\Finder
     */
    public function getPages()
    {
        $finder = new Finder();
        $finder->files();
        $finder->in($this->getDir())
          ->sortByName();
        return $finder;
    }

}

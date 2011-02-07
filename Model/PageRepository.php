<?php

namespace Git\WikiBundle\Model;

use Git\Core\Repository;
use Symfony\Component\Finder\Finder;

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

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

use Git\Repository;
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
     * @return array
     */
    public function getPages()
    {
        return $this->buildPagesTree($this->getDir());
    }

    protected function buildPagesTree($dir)
    {
        $finder = new Finder();
        $iterator = $finder
            ->notName('.git*')
            ->in($dir)
            ->depth('0');

        $pages = array();
        foreach($iterator as $file)
        {
            if($file->isDir()) {
                $pages[$file->getRelativePathName()] = $this->buildPagesTree($file->getPathName());
            } else {
                $pages[$file->getRelativePathName()] = new Page($this, $file->getPathName());
            }
        }

        return $pages;
    }
}

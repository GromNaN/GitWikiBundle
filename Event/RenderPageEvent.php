<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Git\WikiBundle\Model\Page;

/**
 * Event used to filter the contents of a page before rendering.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class RenderPageEvent extends Event
{
    protected $page;
    
    protected $contents;
    
    /**
     * @param Page $page 
     */
    public function __construct(Page $page)
    {
        $this->page     = $page;
        $this->contents = $page->getContents();
    }
    
    /**
     *
     * @return Page The rendered page.
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * @return string The filtered page contents.
     */
    public function getContents()
    {
        return $this->contents;
    }
    
    /**
     * @param string $contents 
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }
}
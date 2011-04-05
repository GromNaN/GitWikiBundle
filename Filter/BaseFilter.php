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

use Git\WikiBundle\Event\RenderPageEvent;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * BaseFilter for wiki contents.
 * Filters are called throw EventDispatcher.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
abstract class BaseFilter extends ContainerAware
{

    /**
     * @var array
     */
    protected $extensions;

    /**
     * List of extentions for files to be filtered.
     *
     * @param array $types
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * Determine if the contents must be filtered depending of its type.
     *
     * @param Event $event
     * @param string $contents
     * @return string
     */
    public function onGitWikiRenderPage(RenderPageEvent $event)
    {
        $extension = $event->getPage()->getExtension();

        if (!$this->extensions || in_array($extension, $this->extensions)) {
            $event->setContents($this->doFilter($event->getContents()));
        }
    }

    /**
     * Process the content filter.
     *
     * @param string $contents Contents to filter
     * @return string Filtered contents
     */
    abstract protected function doFilter($contents);
}

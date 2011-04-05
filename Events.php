<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle;

final class Events
{
    /**
     * The onRenderPage event is thrown before a wiki page is rendered.
     * This event receives a Git\WikiBundle\Event\RenderPageEvent.
     * 
     * @var string
     */
    const onGitWikiRenderPage = 'onGitWikiRenderPage';
}
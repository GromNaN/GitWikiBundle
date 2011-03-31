<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Base controller.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
abstract class Controller extends ContainerAware
{
    const ALIAS = 'git_wiki';
    
    /**
     * Renders a view.
     *
     * @param string   $template   The view name inside the Bundle
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    public function renderView($template, array $parameters = array(), Response $response = null)
    {
        $renderer = $this->container->getParameter(self::ALIAS.'.template.renderer');
        $view = 'GitWiki:' . $template . '.' . $renderer;
        
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }

    /**
     * Generate a route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @return string
     */
    protected function getRoute($name, array $parameters = array())
    {
        return $this->container->get('router')->generate(self::ALIAS . '.' . $name, $parameters);
    }

    /**
     * @return Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }

    /**
     * @return Git\WikiBundle\Model\PageRepository
     */
    protected function getRepository()
    {
        return $this->container->get('git_wiki.repository');
    }
}

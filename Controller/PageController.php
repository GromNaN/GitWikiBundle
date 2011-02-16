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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Git\WikiBundle\Model\Edition;
use Git\WikiBundle\Form\EditionForm;

/**
 * Wiki pages related controller.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class PageController extends Controller
{

    /**
     * Display the content of a page.
     * If a commit is set, this version is displayed.
     *
     * @route /{name}
     * @route /{name}/{commit}
     * @param string $name
     * @param string $commit
     */
    public function viewAction($name, $commit = null)
    {
        $page = $this->getPage($name);

        if (!$page->exists()) {
            return $this->redirect($this->get('router')->generate('git_wiki.page.edit', array('name' => $name)));
            return $response;
        }

        if ($page->isDir()) {
            throw new NotFoundHttpException(sprintf('"%s" is a directory.', $name));
        }

        if (!$page->isReadable()) {
            throw new NotFoundHttpException(sprintf('"%s" is not readable.', $name));
        }

        $event = new Event($page, $this->container->getParameter('git_wiki.filter.event_name'), array('container' => $this->container));
        $contents = $this->get('event_dispatcher')->filter($event, $page->getContents());

        return $this->renderView('view', array(
            'page' => $page,
            'contents' => $contents,
        ));
    }

    /**
     * Render and process the form to edit a page.
     *
     * @route /{name}/_edit
     * @param string $name
     */
    public function editAction($name)
    {
        $page = $this->getPage($name);

        if ($page->isDir()) {
            throw new NotFoundHttpException(sprintf('"%s" is a directory.', $name));
        }

//        if (!$page->isWritable()) {
//            throw new NotFoundHttpException(sprintf('"%s" is not writable.', $name));
//        }

        $form = $this->get('git_wiki.form.edition');
        $form->bind($this->get('request'), new Edition($page));

        if ($form->isValid()) {
            $page->commit($form->getData()->getMessage(), $form->getData()->getAuthor());

            return $this->redirect($this->get('router')->generate('git_wiki.page.view', array('name' => $name)));
        }

        return $this->renderView('edit', array(
            'page' => $page,
            'form' => $form,
        ));
    }

    /**
     * List the last changes on a page.
     *
     * @route /{name}/_history
     * @param string $name
     */
    public function historyAction($name)
    {
        $page = $this->getPage($name);
        $commits = $page->log(10);

        return $this->renderView('history', array(
            'page' => $page,
            'commits' => $commits,
        ));
    }

    /**
     * Display the diff of 1 commit or between 2 commits on a page.
     *
     * @route /{name}/_compare/{hash1}
     * @route /{name}/_compare/{hash1}...{hash2}
     * @param string $name
     * @param string $hash1
     * @param string $hash2 (optional)
     */
    public function compareAction($name, $hash1, $hash2 = null)
    {
        $page = $this->getPage($name);
        $diff = $page->diff(3, $hash1, $hash2);

        return $this->renderView('compare', array(
            'page' => $page,
            'diff' => $diff,
        ));
    }

    /**
     * Get POST versions list and redirect to the compare page.
     *
     * @route /_compare
     * @param string $name
     */
    public function compareRedirectAction($name)
    {
        if ('POST' === $this->get('request')->getMethod()) {

            $hashes = $this->get('request')->get('hashes');

            if (isset($hashes[0])) {
                if (isset($hashes[1])) {
                    return $this->redirect($this->getRoute('page.compare2', array('name' => $name, 'hash1' => $hashes[1], 'hash2' => $hashes[0])));
                } else {
                    return $this->redirect($this->getRoute('page.compare1', array('name' => $name, 'hash1' => $hashes[0])));
                }
            }
        }

        throw new NotFoundHttpException('Invalid versions in POST data');
    }

    /**
     * Send raw file content. This is usefull for binary files.
     *
     * @param string $name
     */
    public function rawAction($name)
    {
        $page = $this->getPage($name);

        if ($page->isNew() || $page->isDir()) {
            throw new NotFoundHttpException(sprintf('File "%s" does not exist.', $name));
        }

        return $this->createResponse($page->getContent());
    }

    /**
     * Renders a view.
     *
     * @param string   $view The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response A response instance
     *
     * @return Response A Response instance
     */
    public function renderView($view, array $parameters = array(), Response $response = null)
    {
        return $this->get('templating')->renderResponse(
          $this->container->getParameter('git_wiki.views.page.'.$view), $parameters, $response);
    }

    /**
     * Generate a route
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    protected function getRoute($name, array $parameters = array())
    {
        return $this->container->get('router')->generate('git_wiki.'.$name, $parameters);
    }

    /**
     * @return Git\WikiBundle\Model\Page
     */
    protected function getPage($name)
    {
        $name = urldecode($name); // Route escaper makes this parameter invalid.
        return $this->container->get('git_wiki.repository')->getPage($name);
    }

}

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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $page = $this->getRepository()->getPage($name);

        if (!$page->exists()) {
            return new RedirectResponse($this->getRoute('page.edit', array('name' => $name)));
        }

        if ($page->isDir()) {
            throw new NotFoundHttpException(sprintf('"%s" is a directory.', $name));
        }

        if (!$page->isReadable()) {
            throw new NotFoundHttpException(sprintf('"%s" is not readable.', $name));
        }

        return $this->renderView('Page:view.html', array(
            'page' => $page,
            'contents' => $page->getContents(),
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
        $page = $this->getRepository()->getPage($name);

        if ($page->isDir()) {
            throw new NotFoundHttpException(sprintf('"%s" is a directory.', $name));
        }

//        if (!$page->isWritable()) {
//            throw new NotFoundHttpException(sprintf('"%s" is not writable.', $name));
//        }

        $form = $this->container->get('git_wiki.form.edition');
        $form->bind($this->getRequest(), new Edition($page));

        if ($form->isValid()) {
            $page->commit($form->getData()->getMessage(), $form->getData()->getAuthor());

            return new RedirectResponse($this->getRoute('page.view', array('name' => $name)));
        }

        return $this->renderView('Page:edit.html', array(
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
        $page = $this->getRepository()->getPage($name);
        $commits = $page->log(10);

        return $this->renderView('Page:history.html', array(
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
        $page = $this->getRepository()->getPage($name);
        $diff = $page->diff(3, $hash1, $hash2);

        return $this->renderView('Page:compare.html', array(
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
        if ('POST' === $this->getRequest()->getMethod()) {
            $hashes = $this->getRequest()->get('hashes');
            if (isset($hashes[0])) {
                if (isset($hashes[1])) {
                    $url = $this->getRoute('page.compare2', array('name' => $name, 'hash1' => $hashes[1], 'hash2' => $hashes[0]));
                } else {
                    $url = $this->getRoute('page.compare1', array('name' => $name, 'hash1' => $hashes[0]));
                }
            } else {
                $url = $this->getRoute('page.history', array('name' => $name));
            }
        }

        // @todo Add flash message
        return new RedirectResponse($url);
    }

    /**
     * Send raw file content. This is usefull for binary files.
     *
     * @param string $name
     */
    public function rawAction($name)
    {
        $page = $this->getRepository()->getPage($name);

        if ($page->isNew() || $page->isDir()) {
            throw new NotFoundHttpException(sprintf('File "%s" does not exist.', $name));
        }

        return $this->createResponse($page->getContent());
    }
}

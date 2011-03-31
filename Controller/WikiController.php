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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Git\WikiBundle\Model\Edition;
use Git\WikiBundle\Form\EditForm;

/**
 * Wiki repository related controller.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class WikiController extends Controller
{

    /**
     * Redirect to homepage
     *
     * @route /
     */
    public function indexAction()
    {
        $name = $this->container->getParameter('git_wiki.page.index');
        $url = $this->getRoute('page.view', array('name' => $name));
        
        return new RedirectResponse($url);
    }

    /**
     * List all pages
     *
     * @route /_pages
     */
    public function pagesAction()
    {
        $pages = $this->getRepository()->getPages();
        
        return $this->renderView('Wiki:pages.html', array(
            'pages' => $pages,
        ));
    }

    /**
     * List last changes on the whole wiki
     *
     * @route /_history
     */
    public function historyAction()
    {
        $commits = $this->getRepository()->log(10);

        return $this->renderView('Wiki:history.html', array(
            'commits' => $commits
        ));
    }

    /**
     * Commit details
     *
     * @route /_commit/{hash}
     * @param string $hash SHA1 hash of the commit
     */
    public function commitAction($hash)
    {
        $commit = $this->getRepository()->getCommit($hash);
        $diff = $commit->getRawDiff();

        return $this->renderView('Wiki:commit.html', array(
            'commit' => $commit,
            'diff' => $diff
        ));
    }

    /**
     * Display diff of 1 commit or between 2 commits
     *
     * @route /_compare/{hash1}
     * @route /_compare/{hash1}...{hash2}
     * @param string $hash1 SHA hash
     * @param string $hash2 SHA hash
     */
    public function compareAction($hash1, $hash2 = null)
    {
        $diff = $this->getRepository()->diff($hash1, $hash2, 3);

        return $this->renderView('Wiki:compare.html', array(
            'diff' => $diff
        ));
    }

    /**
     * Get POST versions list and redirect to the compare page.
     *
     * @route /_compare
     */
    public function compareRedirectAction()
    {
        if ('POST' === $this->container->get('request')->getMethod()) {

            $hashes = $this->get('request')->get('hashes');

            if (isset($hashes[0])) {
                if (isset($hashes[1])) {
                    return $this->redirect($this->getRoute('wiki.compare2', array('hash1' => $hashes[1], 'hash2' => $hashes[0])));
                } else {
                    return $this->redirect($this->getRoute('wiki.compare1', array('hash1' => $hashes[0])));
                }
            }
        }

        // @TODO Add flash message
        
        return $this->redirect($this->getRoute('wiki.history'));
    }

    /**
     * Find occurences of the searched text
     *
     * @route /_search?q=...
     */
    public function searchAction()
    {
        // @TODO
        
        return $this->renderView('Wiki:search.html');
    }
}

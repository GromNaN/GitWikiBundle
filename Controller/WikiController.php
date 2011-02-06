<?php

namespace Bundle\GitWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\GitWikiBundle\Model\Edition;
use Bundle\GitWikiBundle\Form\EditForm;

class WikiController extends Controller
{

    /**
     * Redirect to homepage
     *
     * @Route(
     */
    public function indexAction()
    {
        $name = $this->container->getParameter('gitwiki.page.index');
        $uri = $this->getRoute('page.view', array('name' => $name));
        return $this->redirect($uri);
    }

    /**
     * List all pages
     *
     * @route /_pages
     */
    public function pagesAction()
    {
        $pages = $this->getRepository()->getPages();
        return $this->render($this->getView('pages'), array(
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

        return $this->render($this->getView('history'), array(
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

        return $this->render($this->getView('commit'), array(
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

        return $this->render($this->getView('compare'), array(
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
        if ('POST' === $this->get('request')->getMethod()) {

            $hashes = $this->get('request')->get('hashes');

            if (isset($hashes[0])) {
                if (isset($hashes[1])) {
                    return $this->redirect($this->getRoute('wiki.compare2',
                            array('hash1' => $hashes[1], 'hash2' => $hashes[0])));
                } else {
                    return $this->redirect($this->getRoute('wiki.compare1',
                            array('hash1' => $hashes[0])));
                }
            }
        }

        throw new NotFoundHttpException('Invalid versions in POST data');
    }

    /**
     * Find occurences of the searched text
     *
     * @route /_search?q=...
     */
    public function searchAction()
    {
        // @TODO
        return $this->render($this->getView('search'));
    }

    /**
     * Get the configured view.
     *
     * @param  string  $name The view name
     * @return  string  The view path name from DI parameters.
     */
    protected function getView($name)
    {
        return $this->container->getParameter('gitwiki.views.wiki.'.$name);
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
        return $this->get('router')->generate('gitwiki.'.$name, $parameters);
    }

    /**
     * @return Bundle\GitWikiBundle\Model\PageRepository
     */
    protected function getRepository()
    {
        return $this->container->get('gitwiki.repository');
    }
}

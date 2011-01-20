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
     * @route /
     */
    public function indexAction()
    {
        $name = $this->container->getParameter('gitwiki.page.index');
        $uri = $this->get('router')->generate('gitwiki.page.view', array('name' => $name));
        return $this->redirect($uri);
    }

    /**
     * List all pages
     * 
     * @route /_pages
     */
    public function pagesAction()
    {
        $pages = $this->container->get('gitwiki.repository')->getPages();
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
        $commits = $this->container->get('gitwiki.repository')->getCommits();

        return $this->render($this->getView('history'), array(
            'commits' => $commits,
        ));
    }

    /**
     * Display diff of 1 commit or between 2 commits
     * 
     * @route /_compare
     * @route /_compare/{commit1}
     * @route /_compare/{commit1}...{commit2}
     */
    public function compareAction($commit1 = null, $commit2 = null)
    {
        if ('POST' === $this->get('request')->getMethod()) {
            return $this->redirectToCompare();
        }

        $diff = $this->container->get('gitwiki.repository')->getDiff($commit1, $commit2);

        return $this->render($this->getView('compare'), array(
            'diff' => $diff,
        ));
    }

    /**
     * Get POST versions list and redirect to the compare page.
     */
    protected function redirectToCompare()
    {
        $versions = $this->get('request')->get('versions');

        if (isset($versions[0])) {
            if (isset($versions[1])) {
                return $this->redirect($this->get('router')->generate('gitwiki.wiki.compare2', array('commit1' => $versions[1], 'commit2' => $versions[0])));
            } else {
                return $this->redirect($this->get('router')->generate('gitwiki.wiki.compare1', array('commit1' => $versions[0])));
            }
        }
        throw new NotFoundHttpException('Invalid Git versions');
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

}

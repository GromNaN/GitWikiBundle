<?php

namespace Bundle\GitWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\GitWikiBundle\Model\Edition;
use Bundle\GitWikiBundle\Form\EditForm;

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
        $page = $this->container->get('gitwiki.repository')->getPage($name);

        if ($page->isNew()) {
            return $this->redirect($this->get('router')->generate('gitwiki.page.edit', array('name' => $name)));
        }

        return $this->render($this->getView('view'), array(
            'page' => $page,
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
        $page = $this->container->get('gitwiki.repository')->getPage($name);
        $form = new EditForm('gitwiki', new Edition($page), $this->get('validator'));

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get($form->getName()));

            if ($form->isValid()) {
                $page->save($form->getData()->getMessage());

                return $this->redirect($this->get('router')->generate('gitwiki.page.view', array('name' => $name)));
            }
        }

        return $this->render($this->getView('edit'), array(
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
        $page = $this->container->get('gitwiki.repository')->getPage($name);
        $commits = $page->getCommits();

        return $this->render($this->getView('history'), array(
            'page' => $page,
            'commits' => $commits,
        ));
    }

    /**
     * Display the diff of 1 commit or between 2 commits on a page.
     * 
     * @route /{name}/_compare/{commit1}
     * @route /{name}/_compare/{commit1}...{commit2}
     * @param string $name
     * @param string $commit1
     * @param string $commit2 (optional)
     */
    public function diffAction($name, $commit1, $commit2 = null)
    {
        $page = $this->container->get('gitwiki.repository')->getPage($name);
        $diff = $page->getDiff($commit1, $commit2);
        return $this->render($this->getView('diff'), array(
            'page' => $page,
            'diff' => $diff,
        ));
    }

    /**
     * Get the configured view.
     * 
     * @param string $name The view name
     * @return string The view path name from DI parameters.
     */
    protected function getView($name)
    {
        return $this->container->getParameter('gitwiki.views.page.'.$name);
    }

}

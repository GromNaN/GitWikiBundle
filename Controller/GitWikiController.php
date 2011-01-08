<?php

namespace Bundle\GromNaN\GitWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\GromNaN\GitWikiBundle\Model\Edition;
use Bundle\GromNaN\GitWikiBundle\Form\EditForm;

class GitWikiController extends Controller
{

    /**
     * @route /wiki/
     */
    public function indexAction()
    {
        $name = $this->container->getParameter('gitwiki.page.index');
        return $this->redirect($this->get('router')->generate('view', array('name' => $name)));
    }

    /**
     * @route /wiki/:name
     */
    public function viewAction($name)
    {
        $page = $this->container->get('gitwiki.repository')->getPage($name);

        if ($page->isNew()) {
            return $this->redirect($this->get('router')->generate('edit', array('name' => $name)));
        }

        return $this->render($this->getView('view'), array(
            'page' => $page,
        ));
    }

    /**
     * @route /wiki/:name/edit
     */
    public function editAction($name)
    {
        $page = $this->container->get('gitwiki.repository')->getPage($name);
        $form = new EditForm('gitwiki', new Edition($page), $this->get('validator'));

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get($form->getName()));

            if ($form->isValid()) {
                $page->save($form->getData()->getMessage());

                return $this->redirect($this->get('router')->generate('view', array('name' => $name)));
            }
        }

        return $this->render($this->getView('edit'), array(
            'page' => $page,
            'form' => $form,
        ));
    }

    /**
     * @route /wiki/:name/history
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
     * @route /wiki/search
     */
    public function searchAction()
    {
        return $this->render('GitWikiBundle:Default:search.php');
    }

    /**
     * Get the configured view.
     * 
     * @param  string  $name The view name
     * @return  string  The view path name from DI parameters.
     */
    protected function getView($name)
    {
        return $this->container->getParameter('gitwiki.views.'.$name);
    }
}

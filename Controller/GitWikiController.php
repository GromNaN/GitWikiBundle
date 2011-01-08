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
        return $this->viewAction($this->container->getParameter('gitwiki.page.index'));
    }

    /**
     * @route /wiki/:name
     */
    public function viewAction($name)
    {
        $page = $this->container->get('gitwiki.repository')->getPage($name);

        return $this->render('GromNaN\GitWikiBundle:Default:view.php', array(
            'page' => $page,
        ));
    }

    /**
     * @route /wiki/:name/edit
     */
    public function editAction($name)
    {
        $page = $this->container->get('gitwiki.repository')->getPage($name);
        $form = new EditForm('gitwiki', null, $this->get('validator'));
        $form->setData(new Edition($page));

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get($form->getName()));
            
            if ($form->isValid()) {
                $page->save($form->getData()->getMessage());
            }
        }

        return $this->render('GromNaN\GitWikiBundle:Default:edit.php', array(
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
        
        return $this->render('GromNaN\GitWikiBundle:Default:history.php', array(
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
    
}

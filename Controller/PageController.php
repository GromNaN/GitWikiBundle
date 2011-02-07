<?php

namespace Git\WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Git\WikiBundle\Model\Edition;
use Git\WikiBundle\Form\EditionForm;

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
            return $this->redirect(str_replace('%2F', '/', $this->get('router')->generate('gitwiki.page.edit', array('name' => $name))));
        }

        if ($page->isDir()) {
            throw new NotFoundHttpException(sprintf('"%s" is a directory.', $name));
        }

        if (!$page->isReadable()) {
            throw new NotFoundHttpException(sprintf('"%s" is not readable.', $name));
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
        $page = $this->getPage($name);

        if ($page->isDir()) {
            throw new NotFoundHttpException(sprintf('"%s" is a directory.', $name));
        }

//        if (!$page->isWritable()) {
//            var_dump($page->getPathname());
//            throw new NotFoundHttpException(sprintf('"%s" is not writable.', $name));
//        }

        $form = new EditionForm('gitwiki', new Edition($page), $this->get('validator'));

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get($form->getName()));
//            $form->get

            if ($form->isValid()) {
                $page->save();
                $page->commit($form->getData()->getMessage(), $form->getData()->getGitUser());

                return $this->redirect(str_replace('%2F', '/', $this->get('router')->generate('gitwiki.page.view', array('name' => $name))));
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
        $page = $this->getPage($name);
        $commits = $page->log(10);

        return $this->render($this->getView('history'), array(
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

        return $this->render($this->getView('compare'), array(
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
                    return $this->redirect($this->getRoute('page.compare2',
                            array('name' => $name, 'hash1' => $hashes[1], 'hash2' => $hashes[0])));
                } else {
                    return $this->redirect($this->getRoute('page.compare1',
                            array('name' => $name, 'hash1' => $hashes[0])));
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

        if($page->isNew() || $page->isDir()) {
            throw new NotFoundHttpException(sprintf('File "%s" does not exist.', $name));
        }

        return $this->createResponse($page->getContent());
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
     * @return Bundle\GitWikiBundle\Model\Page
     */
    protected function getPage($name)
    {
        return $this->container->get('gitwiki.repository')->getPage($name);
    }

}

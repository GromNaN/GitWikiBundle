<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Form;

use Git\WikiBundle\Model\Page;
use Git\WikiBundle\Model\Edition;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

/**
 * Page edition form.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class EditionForm extends Form
{

    public function configure()
    {
        $this->add(new PageForm('page'));
        $this->add(new TextField('message'));
        $this->add(new AuthorForm('author'));
    }

}

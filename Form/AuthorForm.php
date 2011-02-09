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

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

/**
 * Commit author form.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class AuthorForm extends Form
{

    public function configure()
    {
        $this->add(new TextField('name'));
        $this->add(new TextField('email'));
    }

}

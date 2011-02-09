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
use Symfony\Component\Form\TextareaField;

/**
 * Page contents edition form.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class PageForm extends Form
{

    public function configure()
    {
        $this->add(new TextareaField('contents'));
    }

}

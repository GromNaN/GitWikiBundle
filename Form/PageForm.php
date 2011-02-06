<?php

namespace Bundle\GitWikiBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextareaField;

class PageForm extends Form
{
    public function configure()
    {
        $this->add(new TextareaField('contents'));
    }
}

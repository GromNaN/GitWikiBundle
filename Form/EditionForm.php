<?php

namespace Git\WikiBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class EditionForm extends Form
{
    public function configure()
    {
        $this->add(new PageForm('page'));
        $this->add(new TextField('message'));
        $this->add(new GitUserForm('gitUser'));
    }
}

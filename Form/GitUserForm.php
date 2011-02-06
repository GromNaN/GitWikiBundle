<?php

namespace Bundle\GitWikiBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class GitUserForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('name'));
        $this->add(new TextField('email'));
    }
}

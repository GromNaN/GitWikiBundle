<?php

namespace Git\WikiBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class AuthorForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('name'));
        $this->add(new TextField('email'));
    }
}

<?php

namespace Bundle\GitWikiBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Bundle\GitWikiBundle\Model\Page;

class EditForm extends Form
{
    public function configure()
    {
        $this->add(new PageForm('page'));
        $this->add(new TextField('message'));
    }
}

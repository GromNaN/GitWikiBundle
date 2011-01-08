<?php

namespace Bundle\GromNaN\GitWikiBundle\Model;

class Edition
{

    /**
     * Message description of the commit
     * 
     * @var string
     */
    protected $message;
    /**
     * Edited page
     * 
     * @var Page
     */
    protected $page;

    function __construct($page)
    {
        $this->page = $page;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

}

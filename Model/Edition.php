<?php

namespace Bundle\GitWikiBundle\Model;

class Edition
{
    /**
     * Message description of the commit
     * 
     * @var string
     */
    protected $message;
    /**
     * Edited page (file)
     * 
     * @var Page
     */
    protected $page;
    /**
     *
     * @var Git\User
     */
    protected $gitUser;

    function __construct($page)
    {
        $this->page = $page;
        $this->gitUser = new \Git\User('', '');
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

    public function getGitUser()
    {
        return $this->gitUser;
    }

    public function setGitUser($gitUser)
    {
        $this->gitUser = $gitUser;
    }

}

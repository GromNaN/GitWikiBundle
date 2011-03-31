<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Model;

use Git\User;

/**
 * Page edition model.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
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
     * Modifications author
     *
     * @var Git\Core\User
     */
    protected $author;

    function __construct(Page $page, User $author = null)
    {
        $this->page = $page;
        $this->author = $author ? : new User('', ''); // Must be initialized to be bound.
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $user)
    {
        $this->author = $author;
    }

}

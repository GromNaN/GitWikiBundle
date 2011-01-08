<?php

namespace Bundle\GromNaN\GitWikiBundle\Model;

use Git\Repository;

class PageRepository extends Repository
{
    /**
     * Read or create a page file in the repository.
     * 
     * @param string $name
     * @return Page 
     */
    public function getPage($name)
    {
        return new Page($this, $name);
    }
}

?>

<?php

namespace Bundle\GromNaN\GitWikiBundle\Model;

use Git\File;

class Page extends File
{
    /**
     * Convert file content to HTML using the format parser.
     * 
     * @todo Implement rendering
     * @return string The rendered page content.
     */
    public function render()
    {
        return '<pre>'.\htmlentities($this->getContent()).'</pre>';
    }
    
    /**
     * Deduce the file format from its extension.
     * 
     * @return string File format
     */
    public function getFormat()
    {
        if(preg_match('#\.([:alnum:]+)$#', $this->getFilename(), $matches)) {
            return $matches[0];
        } else {
            return null;
        }
    }
}

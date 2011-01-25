<?php

namespace Bundle\GitWikiBundle\Helper;

/**
 * FinderHelper format 
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Finder\Finder;

class FinderHelper extends Helper
{

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'finder';
    }

    public function tree(Finder $finder, $base = '/')
    {
        $tree = array();
        foreach($finder as $file) {
            $path = explode('/', $file->getPathname());
            $current = $tree;
            while($path_step = next($path))
            {
                if(!isset($current[$path_step])) {
                    $current[$path_step] = array();
                }
            }
            $current[$path_step] = $file;
        }
        
        return $tree;
    }

    // --- PROTECTED ---
    
}

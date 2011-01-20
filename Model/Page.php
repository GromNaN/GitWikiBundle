<?php

namespace Bundle\GitWikiBundle\Model;

use Git\File;

class Page extends File
{

    /**
     * @var Git\Commit
     */
    protected $lastCommit;

    public function getTitle()
    {
        return \ucfirst(\basename($this->getFilename()));
    }

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
     * Deduct the file format from its extension.
     * If the file does not have any extension, null is returned.
     * 
     * @return string File format (markdown, rst ...)
     */
    public function getFormat()
    {
        if (preg_match('#\.([:alnum:]+)$#', $this->getFilename(), $matches)) {
            return $matches[0];
        } else {
            return null;
        }
    }

    /**
     * Get the last commit on the file.
     * 
     * @return Git\Commit
     */
    public function getLastCommit()
    {
        if (null === $this->lastCommit) {
            $commits = $this->getCommits(1);
            $this->lastCommit = isset($commits[0]) ? $commits[0] : null;
        }
        return $this->lastCommit;
    }

    /**
     * {@inheritDoc}
     */
    public function commit($message)
    {
        $this->lastCommit = null;
        parent::commit($message);
    }

}

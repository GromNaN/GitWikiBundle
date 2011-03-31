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

use Git\File;
use Symfony\Component\EventDispatcher\Event;

/**
 * Wiki page model.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class Page extends File
{

    /**
     * @var string
     */
    protected $format;

    /**
     * @var Git\Commit
     */
    protected $lastCommit;

    public function getTitle()
    {
        return \ucfirst(\basename($this->getFilename()));
    }

    /**
     * Deduct the file format from its extension.
     * If the file does not have any extension, null is returned.
     *
     * @return string File format (markdown, rst ...)
     */
    public function getFormat()
    {
        if (null === $this->format) {
            if (preg_match('/\.([:alnum:]+)$/', $this->getFilename(), $matches)) {
                $this->format = $matches[0];
            } else {
                $this->format = '';
            }
        }

        return $this->format;
    }

    /**
     * Get the last commit on the file.
     *
     * @return Git\Commit
     */
    public function getLastCommit()
    {
        if (null === $this->lastCommit) {
            $commits = $this->log(1);
            $this->lastCommit = current($commits);
        }
        return $this->lastCommit;
    }

    /**
     * {@inheritDoc}
     */
    public function commit($message, $author = null)
    {
        $this->lastCommit = null;
        parent::commit($message, $author);
    }

}

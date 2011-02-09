<?php

/*
 * This file is part of the GitWikiBundle.
 *
 * (c) Jérôme Tamarelle <jerome@tamarelle.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Git\WikiBundle\Helper;

/**
 * GitHelper
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
use Symfony\Component\Templating\Helper\Helper;

class GitHelper extends Helper
{

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'git';
    }

    public function diffLines($text)
    {
        $lines = explode("\n", $text);

        foreach ($lines as $id => $line) {
            $lines[$id] = array(
                'line' => $line,
                'class' => $this->getLineClass($line),
                'ldln' => $this->getLeftDiffLineNumber($line),
                'rdln' => $this->getRightDiffLineNumber($line),
            );
        }

        return $lines;
    }

    // --- PROTECTED ---

    /**
     * @param string $line
     * @return string CSS class name
     */
    protected function getLineClass($line)
    {
        if (\preg_match('/^diff/', $line)) {
            return 'git-diff-file';
        } elseif (\preg_match('/^index/', $line)) {
            return 'git-diff-index';
        } elseif (\preg_match('/^\+\+\+/', $line)) {
            return 'git-diff-insert';
        } elseif (\preg_match('/^\-\-\-/', $line)) {
            return 'git-diff-delete';
        } elseif (\preg_match('/^@@/', $line)) {
            return 'git-jump';
        } elseif (\preg_match('/^\+/', $line)) {
            return 'git-insert';
        } elseif (\preg_match('/^\-/', $line)) {
            return 'git-delete';
        } else {
            return '';
        }
    }

    protected $leftDiffLineNumber;

    protected function getLeftDiffLineNumber($line)
    {
        if (\preg_match('/^@@/', $line)) { // Jump
            \preg_match('/\-(\d+)/', $line, $matches);
            $this->leftDiffLineNumber = (int) $matches[1];
            return '...';
        } elseif (\preg_match('/^\+/', $line)) { // Added
            return ' ';
        } else { // Kept or removed
            $this->leftDiffLineNumber++;
            return (string) ($this->leftDiffLineNumber - 1);
        }
    }

    protected $rightDiffLineNumber;

    protected function getRightDiffLineNumber($line)
    {
        if (\preg_match('/^@@/', $line)) { // Jump
            \preg_match('/\+(\d+)/', $line, $matches);
            $this->rightDiffLineNumber = (int) $matches[1];
            return '...';
        } elseif (\preg_match('/^\-/', $line)) { // Removed
            return ' ';
        } else { // Kept or added
            $this->rightDiffLineNumber++;
            return (string) ($this->rightDiffLineNumber - 1);
        }
    }

}

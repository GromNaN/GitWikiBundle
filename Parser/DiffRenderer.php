<?php

namespace Bundle\GitWikiBundle\Parser;

/**
 * Inspired by GitHub Gollum.
 * https://github.com/github/gollum/blob/master/lib/gollum/frontend/views/compare.rb
 */
class DiffParser
{

    public function transform($text)
    {
        // HTML chararters must be visibles
        $text = \htmlentities($text);
    }

    // --- PROTECTED ---

    protected function getLines($text)
    {
        $lines = explode("\n", $text);

        foreach ($lines as $id => $line) {
            $lines[$id] = array(
                'line' => $line,
                'class' => $this->getLineClass($line),
                'ldln' => $this->getLeftDiffLineNumber(0, $line),
                'rdln' => $this->getRightDiffLineNumber(0, $line),
            );
        }

        return $lines;
    }

    /**
     * @param string $line 
     * @return string CSS class name
     */
    protected function getLineClass($line)
    {
        if (\preg_match('/^@@/', $line)) { // Jump
            return 'git-c';
        } elseif (\preg_match('/^\+/', $line)) {
            return 'git-insert';
        } elseif (\preg_match('/^\-/', $line)) {
            return 'git-delete';
        } else {
            return '';
        }
    }

    protected $_leftDiffLineNumber;

    protected function leftDiffLineNumber($line)
    {
        if (\preg_match('/^@@/', $line)) { // Jump
            \preg_match('/\-(\d+)/', $line, &$matches);
            $this->_leftDiffLineNumber = (int) $matches[0];
            return '...';
        } elseif ('+' == $line{0}) { // Added
            return ' ';
        } else { // Kept or removed
            $this->_leftDiffLineNumber++;
            return (string) ($this->_leftDiffLineNumber - 1);
        }
    }

    protected $_rightDiffLineNumber;

    protected function rightDiffLineNumber($line)
    {
        if (\preg_match('/^@@/', $line)) { // Jump
            \preg_match('/\+(\d+)/', $line, &$matches);
            $this->_rightDiffLineNumber = (int) $matches[0];
            return '...';
        } elseif ('-' == $line{0}) { // Removed
            return ' ';
        } else { // Kept or added
            $this->_rightDiffLineNumber++;
            return (string) ($this->_rightDiffLineNumber - 1);
        }
    }

}
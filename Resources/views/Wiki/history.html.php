<?php
/**
 * @var  array  $commits  List of commits to display
 */
$view->extend('GitWikiBundle::layout.html.php');
?>

<form id="versions-form" method="post" action="<?php echo $view['router']->generate('gitwiki.wiki.compare') ?>"> 
    <input class="action-compare-versions" type="submit" value="Compare Revisions" />
    <table>
        <tbody>
            <?php foreach ($commits as $commit): ?>
                <tr>
                    <td class="checkbox">
                        <input id="hashes_<?php echo $commit->getHash() ?>" name="hashes[]" type="checkbox" value="<?php echo $commit->getHash() ?>" />
                    </td>
                    <td class="author">
                        <a href="mailto:<?php echo $commit->getAuthor()->getEmail() ?>" title="Email">
                        <?php echo $commit->getAuthor()->getName() ?>
                        </a>
                    </td>
                    <td class="commit-name">
                        <em><?php echo $commit->getAuthoredDate()->format('Y-m-d H:i') ?>: </em>
                        <?php echo $commit->getMessage() ?> 
                    </td>
                    <td class="actions">
                        <a href="<?php echo $view['router']->generate('gitwiki.wiki.commit', array('hash' => $commit->getHash())) ?>">Details</a>
                        <a href="<?php echo $view['router']->generate('gitwiki.wiki.compare1', array('hash1' => $commit->getHash())) ?>" title="View diff">Compare to current</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <input class="action-compare-versions" type="submit" value="Compare Revisions" />
</form>

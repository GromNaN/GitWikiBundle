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
                        <input id="versions_<?php echo $commit->getId() ?>" name="versions[]" type="checkbox" value="<?php echo $commit->getId() ?>" />
                    </td>
                    <td class="author">
                        <a href="mailto:<?php echo $commit->getAuthorEmail() ?>" title="Email">
                        <?php echo $commit->getAuthorName() ?>
                        </a>
                    </td>
                    <td class="commit-name">
                        <em><?php echo $commit->getAuthoredDate()->format('Y-m-d H:i') ?>: </em>
                        <?php echo $commit->getMessage() ?> 
                        [<a href="<?php echo $view['router']->generate('gitwiki.wiki.compare1', array('commit1' => $commit->getId())) ?>" title="View diff"><?php echo $commit->getId() ?></a>]
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <input class="action-compare-versions" type="submit" value="Compare Revisions" />
    
</form>

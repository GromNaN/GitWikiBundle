<?php 
/**
 * @var  array  $commits  List of commits to display
 */
$view->extend('GitWikiBundle:Page:layout.html.php');
?>

<form id="versions-form" method="post" action="<?php echo $view['router']->generate('gitwiki.page.compare', array('name' => $page->getFilename())) ?>"> 
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
                        [<a href="<?php echo $view['router']->generate('gitwiki.page.compare1', array('name' => $page->getFilename(), 'hash1' => $commit->getHash())) ?>" title="View diff"><?php echo $commit->getHash() ?></a>]
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <input class="action-compare-versions" type="submit" value="Compare Revisions" />
</form>
<?php
/**
 * @var string $commit
 */
$view->extend('GitWiki::layout.html.php');
?>

<div class="git-commit-infos">
    <p class="git-message"><?php echo nl2br($commit->getMessage()) ?></p>
    <ul class="git-user">
        <li><?php echo $commit->getAuthor()->getName() ?></li>
        <li><?php echo $commit->getAuthoredDate()->format('Y-m-d H:i') ?></li>
    </ul>
</div>


<?php echo $view->render('GitWiki:Blocks:diff.html.php', array('diff' => $diff)) ?>
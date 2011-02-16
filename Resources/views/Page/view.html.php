<?php $view->extend('GitWikiBundle:Page:layout.html.php') ?>


<div id="wiki-body">
    <?php echo $contents ?>
</div>

<p id="last-edit">
    Last edited by
    <strong><?php echo $page->getLastCommit()->getAuthor()->getName() ?></strong>,
    on <?php echo $page->getLastCommit()->getAuthoredDate()->format('Y-m-d H:i:s') ?>
</p>
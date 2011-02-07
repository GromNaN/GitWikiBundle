<?php $view->extend('GitWikiBundle:Page:layout.html.php') ?>

<?php echo $view->render('GitWikiBundle:Blocks:diff.html.php', array('diff' => $diff)) ?>
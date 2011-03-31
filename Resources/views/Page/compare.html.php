<?php $view->extend('GitWiki:Page:layout.html.php') ?>

<?php echo $view->render('GitWiki:Blocks:diff.html.php', array('diff' => $diff)) ?>
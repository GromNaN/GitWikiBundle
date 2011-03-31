<?php
/**
 * @var string $diff
 */
$view->extend('GitWiki::layout.html.php');
?>

<?php echo $view->render('GitWiki:Blocks:diff.html.php', array('diff' => $diff)) ?>
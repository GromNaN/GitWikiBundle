<?php
/**
 * @var string $diff
 */
$view->extend('GitWikiBundle::layout.html.php');
?>

<?php echo $view->render('GitWikiBundle:Blocks:diff.html.php', array('diff' => $diff)) ?>
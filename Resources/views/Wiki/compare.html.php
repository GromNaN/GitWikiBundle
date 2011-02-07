<?php
/**
 * @var string $diff
 */
$view->extend('GitWikiBundle::layout.php.html');
?>

<?php echo $view->render('GitWikiBundle:Blocks:diff.html.php', array('diff' => $diff)) ?>
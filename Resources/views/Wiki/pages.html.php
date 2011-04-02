<?php
/**
 * @var  Finder  $pages  List of pages in the wiki
 */
$view->extend('GitWiki::layout.html.php');
?>


<?php echo $view->render('GitWiki:Blocks:filetree.html.php', array('pages' => $pages)) ?>



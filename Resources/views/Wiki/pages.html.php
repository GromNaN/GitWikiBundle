<?php
/**
 * @var  Finder  $pages  List of pages in the wiki
 */
$view->extend('GitWiki::layout.html.php');
?>


<?php echo $view->render('GitWiki:Blocks:filetree.html.php', array('path' => '/Users/jerometamarelle/Code/Symfony2/symfony-sandbox/app/symfony-docs')) ?>



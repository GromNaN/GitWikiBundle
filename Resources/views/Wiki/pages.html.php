<?php
/**
 * @var  Finder  $pages  List of pages in the wiki
 */
$view->extend('GitWikiBundle::layout.html.php');
?>


<ul>
    <?php foreach($pages as $page): ?>
    <li><a href="<?php echo $view['router']->generate('gitwiki.page.view', array('name' => $page->getFilename())) ?>" title="View this page">
            <?php echo $page->getFilename() ?></a></li>
    <?php endforeach ?>
</ul>
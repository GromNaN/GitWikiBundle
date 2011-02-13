<?php $view->extend('GitWikiBundle::layout.html.php') ?>

<div id="wiki-head">
    <h1><?php echo $page->getTitle() ?></h1>
    <ul id="gitwiki-nav">
        <li><a href="<?php echo $view['router']->generate('gitwiki.page.view', array('name' => $page->getFilename())) ?>" title="View">View</a></li>
        <li><a href="<?php echo $view['router']->generate('gitwiki.page.edit', array('name' => $page->getFilename())) ?>" title="Edit">Edit</a></li>
        <li><a href="<?php echo $view['router']->generate('gitwiki.page.history', array('name' => $page->getFilename())) ?>" title="History">History</a></li>
    </ul>
</div>

<?php $view['slots']->output('_content') ?>
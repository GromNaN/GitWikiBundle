<?php $view->extend('GitWikiBundle:Page:layout.html.php') ?>

<div id="wiki-head">
    <h1><?php echo $page->getTitle() ?></h1>
    <ul id="gitwiki-nav">
        <li><a href="<?php echo $view['router']->generate('edit', array('name' => $page->getFilename())) ?>" title="Edit">Edit</a></li>
        <li><a href="<?php echo $view['router']->generate('history', array('name' => $page->getFilename())) ?>" title="History">History</a></li>
    </ul>
</div>
<pre>
<?php echo ($diff) ?>
</pre>
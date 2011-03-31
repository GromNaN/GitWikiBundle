<?php $view->extend('GitWiki:Page:layout.html.php') ?>

<form action="#" method="post" id="wiki-edit">
    <?php echo $view['form']->render($form) ?>

    <a href="<?php echo $view['router']->generate('git_wiki.page.view', array('name' => $page->getFilename())) ?>" title="Back to the page">Cancel</a>
    <input type="submit" value="Save" />
</form>

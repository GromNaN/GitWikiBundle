<?php //$view->extend('GromNaN\GitWikiBundle::layout.php') ?>
Page: <?php echo $page->getFilename() ?>

<form action="#" method="post" id="gitwiki_edit">
    <?php echo $view['form']->render($form) ?>

    <a href="<?php echo $view['router']->generate('view', array('name' => $page->getFilename())) ?>" title="Back to the page">Cancel</a>
    <input type="submit" value="Save" />
</form>

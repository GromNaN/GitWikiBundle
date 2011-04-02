<?php
/**
 * @var string $path   The full pathname of the directory
 * @var string $parent The relative pathname of the directory
 */
?>
<ul>
    <?php if(count($pages)): ?>
        <?php foreach($pages as $page_name => $page): ?>
        <li>
            <?php if(is_array($page)): ?>
                <?php echo $page_name ?>
                <?php echo $view->render('GitWiki:Blocks:filetree.html.php', array('pages' => $page)) ?>
            <?php else: ?>
                <a href="<?php echo $view['router']->generate('git_wiki.page.view', array('name' => $page->getRelativePathname())) ?>" title="View this page"><?php echo $page_name ?></a>
            <?php endif ?>
        </li>
        <?php endforeach ?>
    <?php else: ?>
        <li><em>Empty</em></li>
    <?php endif ?>
</ul>
<?php
/**
 * @var string $path   The full pathname of the directory
 * @var string $parent The relative pathname of the directory
 */
if(!isset($parent)) {
    $parent = '';
}
$iterator = new RecursiveDirectoryIterator($path);
?>
<ul>
    <?php if(count($iterator)): ?>
    <?php foreach($iterator as $child): ?>
    <li>
        <?php if($child->isDir()): ?>
        <?php echo $child->getFilename() ?>
        <?php echo $view->render('GitWiki:Blocks:filetree.html.php', array('path' => $child->getPathname(), 'parent' => $parent.$child->getFilename().'/')) ?>
        <?php else: ?>
        <a href="<?php echo str_replace('%2F', '/', $view['router']->generate('git_wiki.page.view', array('name' => $parent.$child->getFilename()))) ?>" title="View this page"><?php echo $child->getFilename() ?></a>
        <?php endif ?>
    </li>
    <?php endforeach ?>
    <?php else: ?>
    <li><em>Empty</em></li>
    <?php endif ?>
</ul>
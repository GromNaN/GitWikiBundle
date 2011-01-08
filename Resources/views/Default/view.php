Page: <?php echo $page->getFilename() ?>
<ul>
    <li><a href="<?php echo $view['router']->generate('edit', array('name' => $page->getFilename())) ?>" title="Edit">Edit</a></li>
    <li><a href="<?php echo $view['router']->generate('history', array('name' => $page->getFilename())) ?>" title="History">History</a></li>
</ul>
<section id="gitwiki_page">
<?php echo $page->render() ?>
</section>

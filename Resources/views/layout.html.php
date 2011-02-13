<!DOCTYPE html>
<html>
<head>
    <title><?php $view['slots']->output('title', 'GitWiki') ?></title>
    <link href="<?php echo $view['assets']->getUrl('bundles/gitwiki/css/gitwiki.css') ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <ul>
        <li><a href="<?php echo $view['router']->generate('gitwiki.wiki.home') ?>" title="Home">Home</a></li>
        <li><a href="<?php echo $view['router']->generate('gitwiki.wiki.pages') ?>" title="Pages">Pages List</a></li>
        <li><a href="<?php echo $view['router']->generate('gitwiki.wiki.history') ?>" title="Wiki History">Wiki History</a></li>
    </ul>
<div id="gitwiki-content">
<?php $view['slots']->output('_content') ?>
</div>
</body>
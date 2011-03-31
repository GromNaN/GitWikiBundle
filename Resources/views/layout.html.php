<!DOCTYPE html>
<html>
    <head>
        <title><?php $view['slots']->output('title', 'GitWiki') ?></title>
        <link href="<?php echo $view['assets']->getUrl('bundles/gitwiki/css/wiki.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header>
            <h1><a href="/">GitWiki</a></h1>
            <p>Symfony2 Wiki bundle using Git for versioning pages. <a href="https://github.com/GromNaN/GitWikiBundle">Available on GitHub</a></p>
        </header>
        <section id="wiki">
            <h4>Your are here: <?php $view['slots']->output('breadcrumb', '') ?></h4>
            <nav>
                <ul>
                    <li><a href="<?php echo $view['router']->generate('git_wiki.wiki.home') ?>" title="Home">Home</a></li>
                    <li><a href="<?php echo $view['router']->generate('git_wiki.wiki.pages') ?>" title="Pages">Pages List</a></li>
                    <li><a href="<?php echo $view['router']->generate('git_wiki.wiki.history') ?>" title="Wiki History">Wiki History</a></li>
                </ul>
            </nav>
            <div id="wiki-contents">
                <?php $view['slots']->output('_content') ?>
            </div>
        </section>
    </body>
</html>
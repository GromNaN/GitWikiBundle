<?php $view->extend('GitWikiBundle:Page:layout.html.php') ?>


<div id="wiki-history">
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Author</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commits as $commit): ?>
                <tr>
                    <td><a href="<?php echo $view['router']->generate('gitwiki.page.compare1', array('name' => $page->getFilename(), 'commit1' => $commit->getId()))?>" title="View diff"><?php echo $commit->getId() ?></a></td>
                    <td><a href="mailto:<?php echo $commit->getAuthorEmail() ?>" title="Email"><?php echo $commit->getAuthorName() ?></a></td>
                    <td><?php echo $commit->getMessage() ?></td>
                    <td><?php echo $commit->getAuthoredDate()->format('r') ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

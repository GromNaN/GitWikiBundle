Page: <?php echo $page->getFilename() ?>
<ul>
    <li><a href="<?php echo $view['router']->generate('edit', array('name' => $page->getFilename())) ?>" title="Edit">Edit</a></li>
    <li><a href="<?php echo $view['router']->generate('history', array('name' => $page->getFilename())) ?>" title="History">History</a></li>
</ul>

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
        <?php foreach($commits as $commit): ?>
        <tr>
            <td><?php echo $commit->getId() ?></td>
            <td><a href="mailto:<?php echo $commit->getAuthorEmail() ?>" title="Email"><?php echo $commit->getAuthorName() ?></a></td>
            <td><?php echo $commit->getMessage() ?></td>
            <td><?php echo $commit->getAuthoredDate()->format('r') ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

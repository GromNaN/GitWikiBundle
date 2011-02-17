<?php
/**
 * Transforms the git-diff output into a colorful HTML table.
 *
 * @var string $diff Raw git-diff output
 */
?>
<div class="git-diff">
    <table cellpadding="0" cellspacing="0" width="100%">
        <?php foreach ($view['git']->diffLines(htmlentities($diff)) as $line): ?>
            <tr>
                <td class="line_numbers"><?php echo $line['ldln'] ?></td>
                <td class="line_numbers"><?php echo $line['rdln'] ?></td>
                <td width="100%"><pre><div class="<?php echo $line['class'] ?>"><?php echo $line['line'] ?></div></pre></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<li>
    <a style="text-decoration: <?= ($current_page == $item['title']) ? 'underline' : 'none' ?>"
       href="<?= $item['path']; ?>">
        <?= trimTo($item['title'], 15); ?>
    </a>
</li>
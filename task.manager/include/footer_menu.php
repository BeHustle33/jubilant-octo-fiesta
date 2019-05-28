<nav class="footer-menu">
    <ul class="vertical-menu">
        <?php
        arraySort($main_menu, SORT_DESC);
        menuList($main_menu, $current_page);
        ?>
    </ul>
</nav>
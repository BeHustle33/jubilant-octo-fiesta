<nav class="header-menu">
    <ul class="horizontal-menu">
        <?php
        arraySort($main_menu);
        menuList($main_menu, $current_page);
        ?>
    </ul>
</nav>
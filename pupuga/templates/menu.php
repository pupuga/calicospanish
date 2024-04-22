<nav class="<?php echo $params['class'] ?>">
    <ul>
        <?php
            Pupuga\Core\Load\Menu::app()
                ->menuStandard($params['slug'])
                ->spanReplace(array_map('trim', explode(',', $params['span'])))
                ->action()
        ?>
    </ul>
</nav>
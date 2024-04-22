<thead class="pupuga-admin-table__head">
    <tr class="pupuga-admin-table__head-tr">
        <?php foreach (array_column($params, 'name') as $key => $title) : ?>
            <th><?php if ($title === 'Check') : ?><!--<input title="" class="pupuga-input pupuga-input-table--checkbox-all" type="checkbox" checked="checked">--><?php else : ?><?php echo $title ?><?php endif ?></th>
        <?php endforeach ?>
    </tr>
</thead>
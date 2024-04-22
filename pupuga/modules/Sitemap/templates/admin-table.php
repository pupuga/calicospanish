<table class="wp-list-table widefat striped posts pupuga-admin-table">
    <?php Pupuga\Libs\Files\Files::getTemplate('admin-table-head', true, $params['columns'], __DIR__.'/') ?>
    <tbody id="pupuga-admin-table__body">
    <?php foreach($params['list'] as $keyObject => $list): ?>
        <tr class="pupuga-admin-table__tr pupuga-admin-table__tr--<?php echo $list->type ?> <?php if(is_array($params['options']['excluded']) && in_array($list->id, $params['options']['excluded'])): ?>pupuga-admin-table__tr--disable<?php endif ?>" data-id="<?php echo $list->id ?>">
            <?php foreach ($params['columns'] as $key => $td) : ?>
                    <td class="pupuga-admin-table__td pupuga-admin-table__td--<?php echo $key ?>" data-id="<?php echo $list->id ?>" data-changed="<?php echo $key ?>">
                        <?php if($key == 'check') : ?>
                            <input title="" class="pupuga-input-table pupuga-input-table--checkbox" type="checkbox" <?php if(!is_array($params['options']['excluded']) || !in_array($list->id, $params['options']['excluded'])): ?>checked="checked"<?php endif ?> data-id="<?php echo $list->id ?>">
                        <?php elseif($key == 'no') : ?>
                            <?php echo $keyObject + 1 ?>
                        <?php elseif(isset($td['link']) && $td['link'] === 1) : ?>
                            <a title="" href="<?php echo get_permalink($list->id) ?>" target="_blank"><?php echo $list->$key ?></a>
                        <?php elseif(isset($td['linkAdmin']) && $td['linkAdmin'] === 1) : ?>
                            <a title="" href="<?php echo get_edit_post_link($list->id) ?>"><?php echo $list->$key ?></a>
                        <?php elseif(isset($td['form'])) : ?>
                            <?php Pupuga\Libs\Files\Files::getTemplate('admin-form-'.$td['form'], true, array('list' => $list, 'td' => $td, 'key' => $key, 'changed' => $params['options']['changed']  ), __DIR__.'/') ?>
                        <?php elseif($key == 'type') : ?>
                            <span class="pupuga-admin-table__type-<?php echo $list->$key ?>"><?php echo $list->$key ?></span>
                        <?php else : ?>
                            <?php echo $list->$key ?>
                        <?php endif ?>
                    </td>
            <?php endforeach ?>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
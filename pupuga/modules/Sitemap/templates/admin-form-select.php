<select name="<?php echo $params['key'] ?>" class="pupuga-admin-table__form-element <?php if(isset($params['changed']->period->{$params['list']->id})) : ?>pupuga-admin-table__form-element--changed<?php endif ?>" data-default="<?php echo $params['td']['default'] ?>" data-id="<?php echo $params['list']->id ?>">
    <?php foreach ($params['td']['choice'] as $option) : ?>
        <option value="<?php echo $option ?>" <?php if(isset($params['changed']->period->{$params['list']->id}) && $params['changed']->period->{$params['list']->id} == $option) : ?>selected="selected<?php elseif($params['td']['default'] == $option) : ?>selected="selected"<?php endif ?>><?php echo $option ?></option>
    <?php endforeach ?>
</select>
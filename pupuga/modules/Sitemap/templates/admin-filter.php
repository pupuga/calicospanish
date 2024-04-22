<?php  foreach ($params['types'] as $type) : ?>
    <span class="group-checkbox group-checkbox--line">
        <label class="group-checkbox__line"><input title="" class="pupuga-input pupuga-input--checkbox pupuga-input--checkbox-type-filter" type="checkbox" checked="checked" data-slug="<?php echo $type ?>"><?php echo ucfirst($type) ?></label>
    </span>
<?php  endforeach ?>

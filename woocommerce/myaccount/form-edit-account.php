<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form'); ?>

<div class="pupuga-edit-account">
    <form class="woocommerce-EditAccountForm edit-account" action="" method="post">
        <?php do_action('woocommerce_edit_account_form_start'); ?>
        <div class="pupuga-edit-account__change-main">
            <div class="pupuga-edit-account__change-name">
                <h3 class="pupuga-edit-account__block-title">About Me</h3>
                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" placeholder="<?php esc_html_e('First name', 'woocommerce'); ?>&nbsp;*"/>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" placeholder="<?php esc_html_e('Last name', 'woocommerce'); ?>&nbsp;*"/>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" placeholder="<?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;*"/>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="account_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>"/>
                </p>
            </div>
            <div class="pupuga-edit-account__change-password">
                <h3 class="pupuga-edit-account__block-title">My Password</h3>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" placeholder="<?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?>"/>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" placeholder="<?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?>"/>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" placeholder="<?php esc_html_e('Confirm new password', 'woocommerce'); ?>"/>
                </p>
            </div>
            <div class="pupuga-edit-account__action">
                <?php do_action('woocommerce_edit_account_form'); ?>
                <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                <button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Save changes', 'woocommerce'); ?></button>
                <input type="hidden" name="action" value="save_account_details"/>
                <?php do_action('woocommerce_edit_account_form_end'); ?>
            </div>
        </div>
    </form>

    <?php do_action('woocommerce_after_edit_account_form'); ?>

    <?php
    $customer_id = get_current_user_id();

    if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
        $get_addresses = apply_filters('woocommerce_my_account_get_addresses', array(
            'billing' => __('Billing address', 'woocommerce'),
            'shipping' => __('Shipping address', 'woocommerce'),
        ), $customer_id);
    } else {
        $get_addresses = apply_filters('woocommerce_my_account_get_addresses', array(
            'billing' => __('Billing address', 'woocommerce'),
        ), $customer_id);
    }

    $oldcol = 1;
    $col = 1;
    ?>

    <div class="pupuga-edit-account__addresses">
        <?php foreach ($get_addresses as $name => $title) : ?>
            <div class="u-column<?php echo (($col = $col * -1) < 0) ? 1 : 2; ?> col-<?php echo (($oldcol = $oldcol * -1) < 0) ? 1 : 2; ?> woocommerce-Address">
                <header class="woocommerce-Address-title title">
                    <h3 class="pupuga-edit-account__block-title"><?php echo $title; ?></h3>
                    <div class="pupuga-edit-account__addresses-text"><strong>This will be used as your default shipping address at checkout.</strong> You can update the details, add a new address or manage your shipping addresses below.</div>
                    <div class="pupuga-edit-account__addresses-action">
                        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="edit button"><?php _e('Edit', 'woocommerce'); ?></a>
                    </div>
                </header>
                <address><?php
                    $address = wc_get_account_formatted_address($name);
                    echo $address ? wp_kses_post($address) : esc_html_e('You have not set up this type of address yet.', 'woocommerce');
                    ?>
                </address>
            </div>
        <?php endforeach; ?>
    </div>
</div>

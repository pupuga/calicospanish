<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;
?>

<div class="shop-form-page">
    <?php wc_print_notices(); ?>
    <div class="woocommerce-login-block background-body-blue">
        <div class="woocommerce-login-block__column woocommerce-login-block__column--center">
            <form method="post" class="woocommerce-login-block__action">
                <div class="woocommerce-login-block__title"><h3>Forgotton Your Password?</h3></div>
                <div class="woocommerce-login-block__title woocommerce-login-block__title--text"><h4>Enter your username or email address below.</h4><h4><strong>Please check your email.</strong> You will receive a link to create a new password via email.</h4></div>
                <div class="woocommerce-login-block__wrapper-inputs woocommerce-login-block__wrapper-inputs--after-text">
                    <div class="woocommerce-login-block__wrapper-input"><label class="pretty-input-mock pretty-input-mock--icon-login"><input class="pretty-input-hide woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="Your username or email address"/><input type="hidden" name="wc_reset_password" value="true"/></label></div>
                </div>
                <?php do_action('woocommerce_lostpassword_form'); ?>
                <div class="woocommerce-login-block__wrapper-buttons woocommerce-login-block__wrapper-buttons--near">
                    <button type="submit" class="woocommerce-Button button button--green" value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>">Reset Your Password</button>
                </div>
                <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
            </form>
        </div>
    </div>
</div>

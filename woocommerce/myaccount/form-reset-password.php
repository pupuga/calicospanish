<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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

defined( 'ABSPATH' ) || exit; ?>

<div class="shop-form-page">
    <?php wc_print_notices(); ?>
    <div class="woocommerce-login-block background-body-blue">
        <div class="woocommerce-login-block__column woocommerce-login-block__column--center">
            <form method="post" class="oocommerce-ResetPassword lost_reset_password woocommerce-login-block__action">
                <div class="woocommerce-login-block__title"><h3>Enter a new password below.</h3></div>
                <div class="woocommerce-login-block__title woocommerce-login-block__title--text"><h4>We suggest a password with <strong>8 characters and some numbers and symbols</strong>, but you can create any password you want.</h4></div>
                <div class="woocommerce-login-block__wrapper-inputs woocommerce-login-block__wrapper-inputs--after-text">
                    <div class="woocommerce-login-block__wrapper-input"><label class="pretty-input-mock pretty-input-mock--icon-password"><input type="password" class="pretty-input-hide woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" placeholder="New password *"/></label></div>
                    <div class="woocommerce-login-block__wrapper-input"><label class="pretty-input-mock pretty-input-mock--icon-password"><input type="password" class="pretty-input-hide woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" placeholder="Re-enter new password *"/></label></div>
                </div>
                <div class="display-none"><input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" /><input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" /></div>
                <?php do_action( 'woocommerce_resetpassword_form' ); ?>
                <div class="woocommerce-login-block__wrapper-buttons woocommerce-login-block__wrapper-buttons--near"><input type="hidden" name="wc_reset_password" value="true" /><button type="submit" class="woocommerce-Button button button--green" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Save', 'woocommerce' ); ?></button></div>
                <div class="display-none"><?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?></div>
            </form>
        </div>
    </div>
</div>
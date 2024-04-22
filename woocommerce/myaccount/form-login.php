<?php
/**
 * Login Form
 *
 * */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<div class="shop-form-page">
    <?php wc_print_notices(); ?>
    <?php do_action('woocommerce_before_customer_login_form'); ?>
    <div class="woocommerce-login-block background-body-blue" id="customer_login">
        <div class="woocommerce-login-block__column">
            <form class="woocommerce-login-block__action woocommerce-login-block__action--enter" method="post">
                <div class="woocommerce-login-block__title"><h2>Stories Online Login</h2></div>
                <?php do_action('woocommerce_login_form_start'); ?>
                <div class="woocommerce-login-block__wrapper-inputs">
                    <div class="woocommerce-login-block__wrapper-input"><label class="pretty-input-mock pretty-input-mock--icon-login"><input type="text" class="pretty-input-hide" name="username" id="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" placeholder="Enter your email address"/></label></div>
                    <div class="woocommerce-login-block__wrapper-input"><label class="pretty-input-mock pretty-input-mock--icon-password"><input type="password" class="pretty-input-hide" name="password" id="password" placeholder="Password"/></label></div>
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                </div>
                <?php do_action('woocommerce_login_form'); ?>
                <div class="woocommerce-login-block__wrapper-buttons woocommerce-login-block__wrapper-buttons--near">
                    <button type="submit" class="woocommerce-Button button button--green" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">Login</button>
                </div>
                <div class="woocommerce-login-block__lost-password">
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>">Forgotten your password?</a>
                </div>
                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
        </div>
        <div class="woocommerce-login-block__column">
            <div class="woocommerce-login-block__action woocommerce-login-block__action--free">
                <div class="woocommerce-login-block__start">
                    <?php $trial = Pupuga\Custom\Shop\SubscriptionData::getSubscriptionTrial() ?>
                    <div class="woocommerce-login-block__title"><h2>Not Tried Stories Online Yet?</h2><h4>Start your <strong><?php echo $trial['length']?> <?php echo $trial['period']?>s FREE trial</strong> today.</h4></div>
                    <div class="woocommerce-login-block__wrapper-buttons"><a class="button button--red trial-link" href="<?php echo $trial['addLink'] ?>">Start your FREE Stories Online Trial</a></div>
                </div>
                <div class="woocommerce-login-block__pricing">
                    <div class="woocommerce-login-block__title"><h3>Ready to buy your subscription?</h3></div>
                    <div class="woocommerce-login-block__wrapper-buttons"><a class="button button--purple button--trial-link" href="/pricing/">View Stories Online Pricing</a></div>
                </div>
            </div>
        </div>
    </div>
    <?php do_action('woocommerce_after_customer_login_form'); ?>
</div>

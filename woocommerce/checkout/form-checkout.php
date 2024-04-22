<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<?php $subscription = \Pupuga\Custom\Shop\SubscriptionData::getSubscriptionInCart() ?>
<div class="shop-checkout-page <?php if (WC_Subscriptions_Cart::cart_contains_subscription()) : ?>shop-checkout-page--subscription<?php endif ?> <?php if ($subscription['priceString'] == 'free') : ?>shop-checkout-page--free-trial<?php endif ?>">
    <?php wc_print_notices(); ?>
    <?php if (!WC_Subscriptions_Cart::cart_contains_subscription()) : ?>
        <div class="shop-icon-title shop-icon-title--cart"><h1><span class="shop-icon-title__icon shop-icon-title__icon--cart"></span><span class="shop-icon-title__text">Checkout</span></h1></div>
    <?php endif ?>
    <?php
    do_action('woocommerce_before_checkout_form', $checkout);
    // If checkout registration is disabled and not logged in, the user cannot checkout
    if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
        echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'));
        return;
    }
    ?>
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
        <?php if ($checkout->get_checkout_fields()) : ?>
            <?php do_action('woocommerce_checkout_before_customer_details'); ?>
            <div class="col2-set" id="customer_details">
                <div class="col-1 <?php if (WC_Subscriptions_Cart::cart_contains_subscription()) : ?>billing-block-subscription<?php endif ?>">
                    <?php if ($subscription['priceString'] == 'free') : ?>
                        <div class="pupuga-info-header">
                            <div class="pupuga-info-header__icon"><i class="fa fa-thumbs-up" aria-hidden="true"></i></div>
                            <div class="pupuga-info-header__text">Get Stories Online Free</div>
                            <?php $trial = Pupuga\Custom\Shop\SubscriptionData::getSubscriptionTrial() ?>
                            <div class="pupuga-info-header__description">Start your <strong><?php echo $trial['length']?>-<?php echo $trial['period']?> FREE trial</strong>.</div>
                        </div>
                    <?php endif ?>
                    <?php do_action('woocommerce_checkout_billing'); ?>
                </div>
                <?php if (!WC_Subscriptions_Cart::cart_contains_subscription()) : ?>
                    <div class="col-2">
                        <h3 class="color-title">Shipping Details</h3>
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                <?php endif ?>
            </div>
            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php endif; ?>
        <?php if (!WC_Subscriptions_Cart::cart_contains_subscription()) : ?>
            <h3 id="order_review_heading"><?php _e('Your order', 'woocommerce'); ?></h3>
        <?php endif ?>
        <?php do_action('woocommerce_checkout_before_order_review'); ?>
        <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>
        <?php if (WC_Subscriptions_Cart::cart_contains_subscription() && $subscription['priceString'] != 'free') : ?>
            <div class="secure-checkout">
                <p class="secure-checkout__row"><img src="<?php echo wp_get_attachment_url(150110) ?>"></p>
                <p class="secure-checkout__row">By signing up for this service, you agree to the <a href="<?php echo home_url('/terms-and-conditions/') ?>">terms of service.</a></p>
            </div>
        <?php endif ?>
        <?php do_action('woocommerce_checkout_after_order_review'); ?>
    </form>
    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
</div>

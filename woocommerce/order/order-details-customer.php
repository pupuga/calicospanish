<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if (!defined('ABSPATH')) {
    exit;
}
$show_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address();
global $wp;
$slugPoints = explode('/', $wp->request);
$slugPoint = $slugPoints[1];
if (strpos('view-subscription', $slugPoint) !== false || strpos('subscriptions', $slugPoint) !== false || empty($slugPoint)) {
    $visibleAddresses = false;
} elseif (strpos('view-order', $slugPoint) !== false) {
    $visibleAddresses = false;
} else {
    $visibleAddresses = true;
}

?>
<?php if($visibleAddresses && !wcs_order_contains_subscription($order)) :?>
<section class="woocommerce-customer-details pupuga-customer-details">
    <div class="pupuga-customer-details__billing woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
        <h2 class="woocommerce-column__title"><?php _e('Billing address', 'woocommerce'); ?></h2>
        <div class="pupuga-customer-details__data-block">
            <div class="pupuga-customer-details__data-rows"><?php echo wp_kses_post($order->get_formatted_billing_address(__('N/A', 'woocommerce'))); ?></div>
            <?php if ($order->get_billing_phone()) : ?>
                <div class="pupuga-customer-details__phone"><i class="fa fa-phone" aria-hidden="true"></i><?php echo esc_html($order->get_billing_phone()); ?></div>
            <?php endif; ?>
            <?php if ($order->get_billing_email()) : ?>
                <div class="pupuga-customer-details__email"><i class="fa fa-envelope-o" aria-hidden="true"></i><?php echo esc_html($order->get_billing_email()); ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($show_shipping) : ?>
        <div class="pupuga-customer-details__address woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
            <h2 class="woocommerce-column__title"><?php _e('Shipping address', 'woocommerce'); ?></h2>
            <div class="pupuga-customer-details__data-block">
                <?php echo wp_kses_post($order->get_formatted_shipping_address(__('N/A', 'woocommerce'))); ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php endif ?>
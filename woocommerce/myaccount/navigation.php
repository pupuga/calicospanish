<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<?php

$dashboard = Array(
    'dashboard' =>
        array('label' => 'My Membership', 'icon' => 'fa-key'),
    'edit-account' =>
        array('label' => 'My Details', 'icon' => 'fa-user'),
    'orders' =>
        array('label' => 'My Order History', 'icon' => 'fa-file-text-o')
);
global $wp;
$slugPoints = explode('/', $wp->request);
$slugPoint = $slugPoints[1];
if (isset($dashboard[$slugPoint]) && !empty($dashboard[$slugPoint])) {
    $title = $dashboard[$slugPoint]['label'];
    $icon = $dashboard[$slugPoint]['icon'];
} elseif (strpos('view-subscription', $slugPoint) !== false || strpos('subscriptions', $slugPoint) !== false || empty($slugPoint)) {
    $title = $dashboard['dashboard']['label'];
    $icon = $dashboard['dashboard']['icon'];
} elseif (strpos('view-order', $slugPoint) !== false) {
    $title = $dashboard['orders']['label'];
    $icon = $dashboard['orders']['icon'];
} else {
    $title = $dashboard['edit-account']['label'];
    $icon = $dashboard['edit-account']['icon'];
};
?>

<?php do_action('woocommerce_before_account_navigation') ?>

<div class="pupuga-account-header">
    <?php wc_print_notices(); ?>
    <div class="pupuga-account-hello">
        <?php $userInfo = get_currentuserinfo(); $userName = trim(ucfirst(isset($userInfo->user_firstname) ? $userInfo->user_firstname : ucfirst($userInfo->user_lastname))); ?>
        <div class="pupuga-account-hello__hi">Hi <?php echo $userName = empty($userName) ? $userInfo->display_name : $userName ?>!</div>
        <div class="pupuga-account-hello__bye">(not <?php echo $userName ?>? <a href="<?php echo wc_logout_url( wc_get_page_permalink( 'myaccount' )) ?>">Sign out</a>)</div>
    </div>
    <nav class="woocommerce-MyAccount-navigation pupuga-account-menu">
        <ul>
            <?php foreach ($dashboard as $endpoint => $value) : ?>
                <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                    <a href="<?php echo ($endpoint == 'subscriptions') ? home_url('/my-account/'. $endpoint . '/') : esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($value['label']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php do_action('woocommerce_after_account_navigation'); ?>
</div>

<?php if(!wc_memberships_get_user_active_memberships()) : ?>
<div class="pupuga-wrapper-message">
    <?php Pupuga\Libs\Message\Message::app()->getMessage('warning-subscription-expired') ?>
</div>
<?php endif ?>

<h2 class="pupuga-page-account-title"><i class="fa <?php echo $icon ?>" aria-hidden="true"></i><?php echo $title ?></h2>
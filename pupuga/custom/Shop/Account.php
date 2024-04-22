<?php

namespace Pupuga\Custom\Shop;

final class Account
{
    private $init;

    public function __construct(Init $init)
    {
        $this->init = $init;
        $this->hooks();
    }

    private function hooks()
    {
        add_action('woocommerce_thankyou', array($this, 'redirectAfterBuyPlanToThankYouPage'));
        add_filter('woocommerce_login_redirect', array($this, 'redirectToStartingAccountPage'), 10, 1);
        add_filter('woocommerce_min_password_strength', array($this, 'setPasswordStrength'));
        add_action('wp_print_scripts', array($this, 'removePasswordStrength'), 100);
        add_action('wc_memberships_user_membership_expiry', array($this, 'saveExUserIntoMailChimp'), 5, 1);
    }

    public function redirectAfterBuyPlanToThankYouPage($orderId)
    {
        $order = wc_get_order($orderId);
        foreach ($order->get_items() as $itemId => $item) {
            if ($item['quantity'] > 0) {
                $product = wc_get_product($item['product_id']);
                if (\WC_Subscriptions_Product::is_subscription($product)) {
                    if ($order->status != 'failed') {
                        $thanksUrlTrial = 'congratulations-free-trial-of-stories-online';
                        $thanksUrlMember = 'congratulations-subscription-to-stories-online';
                        if (\WC_Subscriptions_Product::get_price($product) == 0) {
                            $thanksUrl = $thanksUrlTrial;
                            $list = 'trial';
                        } else {
                            $thanksUrl = $thanksUrlMember;
                            $list = 'access';
                        };
                        $customerId = $order->get_customer_id();
                        $customer = get_userdata($customerId);
                        $customerMeta = get_user_meta($customerId);
                        $customer = array(
                            'email' => $customer->data->user_email,
                            'firstName' => $customerMeta['first_name'][0],
                            'lastName' => $customerMeta['last_name'][0]
                        );
                        new MailChimp($list, $customer);
                        $thanksUrl = home_url('/' . $thanksUrl . '/');
                        wp_redirect($thanksUrl);
                        exit;
                    }
                }
            }
        }

        return $orderId;
    }

    public function redirectToStartingAccountPage($redirectTo)
    {
        $redirectTo = home_url('/get-started/');

        return $redirectTo;
    }

    public function setPasswordStrength($strength)
    {
        $strength = 0;

        return $strength;
    }

    public function removePasswordStrength()
    {
        wp_dequeue_script('wc-password-strength-meter');
    }

    public function saveExUserIntoMailChimp($member)
    {
        $member = wc_memberships_get_user_membership($member);
        $user = get_userdata($member->user_id);
        $names = explode(' ', $user->data->display_name);
        switch($member->plan->slug) {
            case 'free-trial' :
                $list = 'trialfinished';
                break;
            default :
                $list = 'accesscanceled';
        }
        new MailChimp($list, array(
            'email' => $user->data->user_email,
            'firstName' => $names[0],
            'lastName' => empty($names[1]) ? $names[0] : $names[1]
        ));

        return $member;
    }
}
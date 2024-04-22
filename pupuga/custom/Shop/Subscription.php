<?php

namespace Pupuga\Custom\Shop;

use Pupuga\Core\Base\Common;
use Pupuga\Libs\Message\Message;

class Subscription
{
    protected $init;
    protected $freeTrialSlug = 'free-trial';

    public function __construct(Init $init)
    {
        $this->init = $init;
        $this->hooks();
    }

    private function hooks()
    {
        add_action('woocommerce_init', array($this, 'setJs'));
        add_filter('request', array($this, 'redirectSubscriptionFromCartPage'), 999, 1);
        add_action('woocommerce_add_to_cart',  array($this,'checkSubscriptionInCart'), 10, 6);
        add_filter('woocommerce_checkout_fields', array($this, 'setCheckoutPage'));
        add_filter('default_checkout_country', array($this, 'setDefaultCountry'));
        add_action('woocommerce_checkout_process', array($this, 'autoIn'));
        add_action('woocommerce_checkout_process', array($this, 'matchingEmailAddresses'));
        add_filter('wcs_view_subscription_actions', array($this, 'changeSubscriptionButtons'), 100, 2 );
        add_filter('woocommerce_email_recipient_customer_completed_order', array($this, 'removeSubscriptionFreeTrialOrderMail'), 10, 2);
        add_filter('woocommerce_email_recipient_customer_processing_order', array($this, 'removeSubscriptionFreeTrialOrderMail'), 10, 2);
        add_filter( 'woocommerce_add_error', array($this, 'removeBillingWordInError'));
        //add_action( 'woocommerce_customer_changed_subscription_to_cancelled', array($this, 'skipPendingCancellation'));
        add_filter( 'woocommerce_memberships_thank_you_message', '__return_empty_string' );
        add_filter( 'woocommerce_order_button_text', array($this, 'titleCheckoutTitle'));
    }

    public function setJs()
    {
        $subscription = SubscriptionData::getSubscriptionTrial();
        Common::app()->addJs(
            array('freeTrialProduct' => $subscription['id'])
        );
    }

    public function redirectSubscriptionFromCartPage($request)
    {
        if (\WC_Subscriptions_Cart::cart_contains_subscription()) {
            if($request['pagename'] == 'cart') {
                wp_redirect(get_permalink( wc_get_page_id( 'checkout' ) ));
                exit;
            }
        }

        return $request;
    }

    public function checkSubscriptionInCart($cartItemKey, $productId, $quantity, $variationId, $variation, $cartItemData)
    {
        if (\WC_Subscriptions_Product::is_subscription($productId)) {
            WC()->cart->set_quantity($cartItemKey, 1 );
        }
    }

    public function setCheckoutPage($fields)
    {
        if (\WC_Subscriptions_Cart::cart_contains_subscription()) {
            $this->setSubscriptionOne();
            $fields = $this->setFields($fields);
            $plans = wc_memberships_get_user_active_memberships();
            $activeMember = false;
            if (count($plans) > 0) {
                foreach ($plans as $plan) {
                    $activeMember = $plan->plan->post->post_name == $this->freeTrialSlug ? false : true;
                    break;
                };
            }
            if ($activeMember) {
                Message::app()->getMessage('warning-have-subscription');
            }
        }

        return $fields;
    }

    public function setDefaultCountry()
    {
        return 'US';
    }

    public function matchingEmailAddresses()
    {
        if (\WC_Subscriptions_Cart::cart_contains_subscription()) {
            $email = $_POST['billing_email'];
            $emailVerify = $_POST['billing_email_verify'];
            if ( $email !== $emailVerify ) {
                wc_add_notice( 'Your email addresses do not match', 'error' );
            }
            $this->correctCartSubscription();
        }
    }

    public function autoIn()
    {
        if (!is_user_logged_in() && !\WC_Subscriptions_Cart::cart_contains_product((SubscriptionData::getSubscriptionTrial())['id'])) {
            $user = wp_authenticate(trim($_POST['billing_email']), trim($_POST['account_password']));
            if (isset($user->id) && $user->id != '') {
                wp_set_current_user($user->id, $user->user_login);
                wp_set_auth_cookie( $user->id );
            }
        }
    }

    public function changeSubscriptionButtons( $actions, $subscription )
    {
        foreach ($actions as $key => $action) {
            switch ( $key ) {
                case 'change_payment_method':	// Hide "Change Payment Method" button?
                case 'change_address':		    // Hide "Change Address" button?
                case 'switch':			        // Hide "Switch Subscription" button?
                case 'resubscribe':		        // Hide "Resubscribe" button from an expired or cancelled subscription?
                case 'pay':			            // Hide "Pay" button on subscriptions that are "on-hold" as they require payment?
                case 'reactivate':		        // Hide "Reactive" button on subscriptions that are "on-hold"?
                //case 'cancel':			    // Hide "Cancel" button on subscriptions that are "active" or "on-hold"?
                    unset( $actions[ $key ] );
                    break;
            }
        }

        if (isset($actions['cancel'])) {
            $actions['change_payment_method'] = array(
                'name' => 'Payment Methods',
                'url' => home_url('/my-account/payment-methods/')
            );
        }

        return $actions;
    }

    public function removeSubscriptionFreeTrialOrderMail( $recipient, $order )
    {
        if(intval($order->get_total()) == 0 ) {
            $recipient = '';
        }
        return $recipient;
    }

    public function removeBillingWordInError($error)
    {
        if (\WC_Subscriptions_Cart::cart_contains_subscription() && intval(WC()->cart->total) == 0) {
            if (strpos($error, 'Billing ') !== false) {
                $error = str_replace("Billing ", "", $error);
            }
        }
        return $error;
    }

    /**
     * Change 'pending-cancel' status directly to 'cancelled'.
     */
    public function skipPendingCancellation($subscription)
    {
        if ( 'pending-cancel' === $subscription->get_status() ) {
            $subscription->update_status( 'cancelled', 'Your subscription has been cancelled.' );
        }
    }

    public function titleCheckoutTitle($title) {
        $total = WC()->cart->cart_contents_total;
        if (\WC_Subscriptions_Cart::cart_contains_subscription() && intval($total) !== 0) {
            $title = 'Pay ' . get_woocommerce_currency_symbol() . $total;
        }
        return $title;
    }

    private function setSubscriptionOne()
    {
        $cart = WC()->cart;
        $items = $cart->get_cart();
        $first = true;
        foreach($items as $item => $values) {
            if ($first) {
                $first = false;
            } else {
                $cart->remove_cart_item($item);
            }
        }

        $this->correctCartSubscription();
    }

    private function correctCartSubscription()
    {
        $cart = WC()->cart;
        $subscriptions = wcs_get_users_subscriptions();
        $memberships = wc_memberships_get_user_memberships();

        $plans = wc_memberships_get_user_active_memberships();
        $activeMemberTrial = false;
        if (count($plans) > 0) {
            foreach ($plans as $plan) {
                $activeMemberTrial = $plan->plan->post->post_name == $this->freeTrialSlug;
                break;
            };
        }

        if (intval($cart->total) == 0 && $activeMemberTrial) {
            $cart->empty_cart();
            wp_redirect('/pricing/?message=warning-is-trial-period');
        } elseif (intval($cart->total) == 0 && (count($subscriptions) > 0 || count($memberships) > 0)) {
            $cart->empty_cart();
            wp_redirect('/pricing/?message=warning-trial');
        }
    }

    private function setFields($fields)
    {
        //remove order comments, shipping, some billing fields
        unset($fields['order']['order_comments']);
        unset($fields['shipping']);
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_state']);
        unset($fields['billing']['billing_phone']);
        if (intval(WC()->cart->total) == 0) {
            unset($fields['billing']['billing_first_name']);
            unset($fields['billing']['billing_last_name']);
        } else {
            $fields['billing']['billing_first_name']['class'] = array('form-row-wide');
            $fields['billing']['billing_last_name']['class'] = array('form-row-wide');
        }
        //change billing parameters of fields
        $fields['billing']['billing_country'] = array('default' => 'US', 'class' => array('display-none'));
        //add Verify Email Address field
        $fields['billing']['billing_email_verify'] = array(
            'label'     => 'Verify email address',
            'required'  => true,
            'class'     => array('form-row-wide'),
            'clear'     => true
        );

        return $fields;
    }

}
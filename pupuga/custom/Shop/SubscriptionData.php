<?php

namespace Pupuga\Custom\Shop;

class SubscriptionData
{
    static public function getSubscriptionByProduct($product)
    {
        $currency = get_woocommerce_currency_symbol();
        $subscription = array(
            'id' => $product->get_id(),
            'name' => $product->get_name(),
            'currency' => $currency,
            'price' => \WC_Subscriptions_Product::get_price($product),
            'period' => \WC_Subscriptions_Product::get_period($product),
            'length' => \WC_Subscriptions_Product::get_length($product),
        );
        $subscription['priceString'] = intval($subscription['price']) === 0 ? 'free' : $subscription['currency'] . $subscription['price'];

        return $subscription;
    }

    static public function getSubscriptionInCart()
    {
        foreach (WC()->cart->get_cart() as $productData) {
            $product = $productData['data'];
            $subscription = self::getSubscriptionByProduct($product);
            break;
        }

        if (!isset($subscription)) {
            $subscription = false;
        }

        return $subscription;
    }

    static public function getSubscriptionTrial()
    {
        return (new \Pupuga\Modules\Plans\Init)->getPlans('free')[0];
    }

}
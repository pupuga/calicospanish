<?php

namespace Pupuga\Custom\Shop;

class Cart {

    protected $init;

    public function __construct(Init $init)
    {
        $this->init = $init;
        $this->hooks();
    }

    private function hooks()
    {
        add_filter('woocommerce_add_to_cart_fragments', array($this, 'addCartFragment'));
        add_filter('woocommerce_product_add_to_cart_text', array($this, 'changeGridCartButtonText'));
        add_filter('woocommerce_checkout_fields', array($this, 'changingCheckoutShippingFields'));
    }

    public function addCartFragment($fragments)
    {
        $fragments['a.cart-contents'] = $this->init->getTemplate('cart');

        return $fragments;
    }

    public function changeGridCartButtonText()
    {
        return __('Add to cart', 'woocommerce');
    }

    public function changingCheckoutShippingFields($fields)
    {
        unset($fields['billing']['billing_address_2']);
        unset($fields['shipping']['shipping_address_2']);

        return $fields;
    }
}
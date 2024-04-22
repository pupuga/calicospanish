<?php

namespace Pupuga\Custom\Shop;

use \Pupuga\Libs\Data;

final class Page
{
    private $init;
    private $excludeProductsIds = [/*19803, 19798, 16725, 15237, 15240*/];
    private $availableCategories = ['stories-online', 'classic-accelerate', 'music'];
    private $currentCategory;

    public function __construct(Init $init)
    {
        $this->init = $init;
        $this->hooks();
    }

    private function hooks()
    {
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
        remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );

        add_filter('request', array($this, 'redirectClosedProducts'), 999, 1);
        add_filter('pre_get_posts', array($this, 'productsGrid'), 999);
        add_filter('loop_shop_columns', array($this, 'productsLineNumber'), 999);
        add_filter('woocommerce_output_related_products_args', array($this, 'relatedProductsGrid'), 999, 1 );
        add_filter('the_content',  array($this, 'beforeContentShop'), 10 );
        add_filter('woocommerce_before_shop_loop',  array($this, 'beforeProductCategory'), 10 );

        add_action( 'woocommerce_before_single_product', array($this, 'singleProductBreadcrumbs'), 10 );
    }

    public function redirectClosedProducts($request)
    {
        $categories = [];
        if (isset($request['product_cat']) && !empty($request['product_cat'])) {
            $slug = $request['product_cat'];
            $categories[] = $slug;
        } elseif (isset($request['post_type']) && $request['post_type'] == 'product' && isset($request['product']) && !empty($request['product'])) {
            $slug = $request['product'];
            $product = get_page_by_path( $slug, OBJECT, 'product' );
            $terms = get_the_terms($product->ID, 'product_cat');
            if (is_array($terms) && count($terms) > 0) {
                foreach ($terms as $term) {
                    $categories[] = $term->slug;
                }
            } else {
                $categories[] = 'uncategorized';
            }
        }

        if (count($categories) > 0 ) {
            $closedProducts = true;
            foreach ($categories as $category) {
                if (in_array($category, $this->availableCategories)) {
                    $closedProducts = false;
                    break;
                };
            }

            if ($closedProducts) {
                wp_redirect(home_url('/404-page/'));
                exit();
            }

            $this->currentCategory = $slug;
        }

        return $request;
    }

    public function productsLineNumber()
    {
        $number = 5;

        return $number;
    }

    public function productsGrid($query)
    {
        if ((is_shop() || is_product_category()) && $query->query['post_type'] == 'product') {
            $query->set('orderby', 'date title');
            $query->set('order', 'DESC');
            $query->set('posts_per_page', 200);
            $query->set('post__not_in', $this->excludeProductsIds);
            if (is_shop()) {
                $query->set('tax_query',
                    array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => $this->availableCategories,
                        )
                    )
                );
            }
        }
    }

    public function relatedProductsGrid( $args )
    {
        $args['posts_per_page'] = 5;
        $args['columns'] = 5;

        return $args;
    }

    private function getAvailableCategories()
    {
        $terms = get_terms(array(
            'taxonomy' => array('product_cat'),
            'slug' => $this->availableCategories
        ));

        return $terms;
    }

    public function beforeContentShop ($content)
    {
        if (is_shop()) {
            $shopPageHeader = Data\Html::transformHtml($this->init->getTemplate('shop-header',
                ['title' => get_the_title(), 'categories' => $this->getAvailableCategories(), 'current-category' => '']
            ));
            $content = $shopPageHeader . $content;
        }

        return $content;
    }

    public function beforeProductCategory ()
    {
        if (is_product_category()) {
            $post = get_post(wc_get_page_id('shop'));
            $shopPageHeader = Data\Html::transformHtml($this->init->getTemplate('shop-header',
                ['title' => $post->post_title, 'categories' => $this->getAvailableCategories(), 'current-category' => $this->currentCategory]
            ));
            $content = Data\Html::transformHtml($post->post_content);
            $content = $shopPageHeader . $content;

            echo $content;
        }
    }

    public function singleProductBreadcrumbs()
    {
        global $post;
        $home = home_url();
        $shop = home_url('shop');
        echo
            "<ul class='breadcrumb breadcrumb--single-product'>
                <li class='breadcrumb__item'><a href='{$home}' class='breadcrumb__title breadcrumb__title--link'>Home</a></li>
                <li class='breadcrumb__item'><span class='breadcrumb__arrow'>></span><a href='{$shop}' class='breadcrumb__title breadcrumb__title--link'>Shop</a></li>
                <li class='breadcrumb__item'><span class='breadcrumb__arrow'>></span><span class='breadcrumb__title'>{$post->post_title}</span></li>
            </ul>";
    }

}
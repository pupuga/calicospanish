<?php

namespace Pupuga\Modules\Plans;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{
    private $ids = '153952, 153953, 153954';
    private $buttons = array(
        'buy' => array(
            'title' => 'Buy Now'
        ),
        'try' => array(
            'title' => 'Try now'
        )
    );
    private $excludes = array();

    protected function boot()
    {
        $this->setParameters();
        $plans = $this->getPlans();

        return $plans;
    }

    protected function setParameters()
    {
      if (isset($this->atts['buytitle'])) {
          $this->buttons['buy']['title'] = $this->atts['buytitle'];
      };
      if (isset($this->atts['trytitle'])) {
          $this->buttons['try']['title'] = $this->atts['trytitle'];
      };
      if (isset($this->atts['excludes'])) {
          $this->excludes = array_map('trim', explode(',', $this->atts['excludes']));
      }
    }

    public function getExclude()
    {
        global $wp_query;
        $categorySlug = $wp_query->get_queried_object()->slug;
        $result = (in_array($categorySlug, $this->excludes));

        return $result;
    }

    public function getPlans($return = 'all')
    {
        $plans = [];
        $currency = get_woocommerce_currency_symbol();
        if (isset($this->atts['ids']) && !empty($this->atts['ids'])) {
            $this->ids = $this->atts['ids'];
        }
        $best = (isset($this->atts['best']) && !empty($this->atts['best'])) ? $this->atts['best'] : '';
        foreach (explode(',', $this->ids) as $id) {
            $id = trim($id);
            $product = wc_get_product($id);
            $interval = \WC_Subscriptions_Product::get_interval($product);
            $plan = [
                'id' => $id,
                'currency' => $currency,
                'name' => $product->get_name(),
                'price' => \WC_Subscriptions_Product::get_price($product),
                'interval' => ($interval > 1) ? $interval : '',
                'period' => \WC_Subscriptions_Product::get_period($product),
                'length' => \WC_Subscriptions_Product::get_length($product),
                'class' => '',
                'buttonText' => $this->buttons['buy']['title']
            ];
            $plan['interval-period'] = (empty($plan['interval'])) ? $plan['period'] : $plan['interval'] . '&nbsp;' . $plan['period'];
            if ($plan['price'] == 0 || (isset($this->atts['red'])) && $this->atts['red'] == $plan['id']) {
                $plan['class'] = 'free';
                $plan['buttonText'] = $this->buttons['try']['title'];
            } elseif($id == $best) {
                $plan['class'] = 'best';
            }
            if ($return == 'free') {
                if ($plan['price'] == 0) {
                    $plan['addLink'] = get_permalink( wc_get_page_id( 'shop' ) ) . '?add-to-cart=' . $plan['id'];
                    $plans[] = $plan;
                }
            } else {
                $plans[] = $plan;
            }
        }

        return $plans;
    }

    protected function doc()
    {
        return (new Doc\TemplateProperty)
            ->setTitle('Plans')
            ->setDescription('Plans module')
            ->setDocumentation(__DIR__ . '/doc.html');
    }
}

<?php if (!$params->getExclude()) : ?>
    <div class="pupuga-plans <?php if (isset($params->atts['secure']) && !empty($params->atts['secure'])) : ?>pupuga-plans--with-secure<?php endif ?>">
        <?php foreach ($params->data as $plan) : ?>
            <div class="pupuga-plan <?php if ($plan['class'] != '') echo 'pupuga-plan--' . $plan['class'] ?>">
                <div class="pupuga-plan__top">
                    <?php if ($plan['class'] == 'best') : ?>
                        <div class="pupuga-plan__header">Best Seller</div><?php endif ?>
                    <div class="pupuga-plan__action">
                        <div class="pupuga-plan__action-before-text <?php if ($plan['class'] != '') echo 'pupuga-plan__action-before-text--' . $plan['class'] ?>">Stories Online</div>
                        <div class="pupuga-plan__action-period <?php if ($plan['class'] != '') echo 'pupuga-plan__action-period--' . $plan['class'] ?>"><?php echo $plan['name'] ?></div>
                        <div class="pupuga-plan__submit">
                            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?add-to-cart=<?php echo $plan['id'] ?>" class="pupuga-plan__button <?php if ($plan['class'] != '') echo 'pupuga-plan__button--' . $plan['class'] ?>"><?php echo $plan['buttonText'] ?></a>
                        </div>
                    </div>
                </div>
                <div class="pupuga-plan__bottom <?php if ($plan['class'] != '') echo 'pupuga-plan__bottom--' . $plan['class'] ?>">
                    <div class="pupuga-plan__price">
                        <div class="pupuga-plan__price-amount"><?php echo $plan['price'] == 0 ? 'free' : $plan['currency'] . $plan['price'] ?></div>
                        <div class="pupuga-plan__price-period"><?php echo $plan['price'] == 0 ? '' : '&nbsp;/&nbsp;' . $plan['interval-period'] ?></div>
                        <div class="pupuga-plan__price-after-text">per teacher</div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <p><?php echo $params->atts['text'] ?></p>
<?php endif ?>
<?php if (isset($params->atts['secure']) && !empty($params->atts['secure'])) : ?>
    <div class="secure-checkout">
        <p class="secure-checkout__row"><img src="<?php echo wp_get_attachment_url($params->atts['secure']) ?>"></p>
        <p class="secure-checkout__row">By signing up for this service, you agree to the <a href="<?php echo home_url('/terms-and-conditions/') ?>">terms of service.</a></p>
    </div>
<?php endif ?>

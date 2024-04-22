<div class="template template--sample-sources">
    <div class="sample-sources">
        <div class="sample-sources__media"><img src="<?php echo $params->getImage()[0] ?>" title=""></div>
        <div class="sample-sources__form">
            <div class="sample-sources__before-result">
                <div class="sample-sources__top-text"><?php echo $params->getHeader() ?></div>
                <div class="sample-sources__message display-none"><?php echo $params->getThx() ?></div>
                <div class="sample-sources__waiting display-none"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>
                <form method="post" action="/">
                    <input type="text" class="sample-sources__field" placeholder="Your Name" data-name="name" required="required">
                    <input type="email" class="sample-sources__field" placeholder="Email Address" data-name="email" required="required">
                    <button type="submit" class="sample-sources__submit button button--purple" data-link="%%data-link%%"><?php echo $params->getButtonText() ?></button>
                </form>
                <div class="sample-sources__bottom-text">
                    <p><i class="fa fa-lock" aria-hidden="true"></i> We hate SPAM and promise to keep your email address safe.</p>
                </div>
            </div>
        </div>
    </div>
</div>
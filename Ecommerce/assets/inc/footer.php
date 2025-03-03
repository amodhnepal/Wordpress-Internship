<footer class="footer">
    <div class="footer-top">
        <div class="footer-icons">
            <div class="footer-icon">
                <i class="fas fa-lock"></i>
                <span><?php echo get_theme_mod('secure_payment_text', 'Secure Payment'); ?></span>
            </div>
            <div class="footer-icon">
                <i class="fas fa-shipping-fast"></i>
                <span><?php echo get_theme_mod('express_shipping_text', 'Express Shipping'); ?></span>
            </div>
            <div class="footer-icon">
                <i class="fas fa-sync-alt"></i>
                <span><?php echo get_theme_mod('free_return_text', 'Free Return'); ?></span>
            </div>
        </div>
    </div>

    <div class="footer-main">
        <div class="footer-section">
            <h4 class="footer-logo"><?php echo get_theme_mod('footer_logo_text', 'PLASHOE'); ?></h4>
            <p><?php echo get_theme_mod('footer_description', 'Your store description here.'); ?></p>
            <div class="footer-social">
                <a href="<?php echo esc_url(get_theme_mod('instagram_link', '#')); ?>"><i class="fab fa-instagram"></i></a>
                <a href="<?php echo esc_url(get_theme_mod('pinterest_link', '#')); ?>"><i class="fab fa-pinterest"></i></a>
                <a href="<?php echo esc_url(get_theme_mod('facebook_link', '#')); ?>"><i class="fab fa-facebook"></i></a>
                <a href="<?php echo esc_url(get_theme_mod('twitter_link', '#')); ?>"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Shop</h4>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu_shop',
                'container' => 'ul',
                'menu_class' => 'footer-menu'
            ]);
            ?>
        </div>

        <div class="footer-section">
            <h4>About</h4>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu_about',
                'container' => 'ul',
                'menu_class' => 'footer-menu'
            ]);
            ?>
        </div>

        <div class="footer-section">
            <h4>Need Help?</h4>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu_help',
                'container' => 'ul',
                'menu_class' => 'footer-menu'
            ]);
            ?>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. Powered by <?php echo get_bloginfo('name'); ?>.</p>
        <div class="payment-icons">
            <img src="<?php echo esc_url(get_theme_mod('stripe_icon', get_template_directory_uri() . '/images/stripe.png')); ?>" alt="Stripe">
            <img src="<?php echo esc_url(get_theme_mod('paypal_icon', get_template_directory_uri() . '/images/paypal.png')); ?>" alt="PayPal">
            <img src="<?php echo esc_url(get_theme_mod('amex_icon', get_template_directory_uri() . '/images/amex.png')); ?>" alt="American Express">
            <img src="<?php echo esc_url(get_theme_mod('visa_icon', get_template_directory_uri() . '/images/visa.png')); ?>" alt="Visa">
            <img src="<?php echo esc_url(get_theme_mod('mastercard_icon', get_template_directory_uri() . '/images/mastercard.png')); ?>" alt="MasterCard">
        </div>
    </div>
</footer>


<?php wp_footer(); ?>
</body>
</html>

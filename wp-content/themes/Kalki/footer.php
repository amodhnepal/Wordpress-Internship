
<footer class="site-footer">
    <div class="footer-container">
        <!-- Footer Logo -->
        <div class="footer-logo">
            <?php $footer_logo = get_option('footer_logo'); ?>
            <?php if ($footer_logo): ?>
                <img src="<?php echo esc_url($footer_logo); ?>" alt="Footer Logo">
            <?php endif; ?>
        </div>

        <!-- Footer Menu -->
        <div class="footer-links">
            <h4>About</h4>
            <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_menu',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                ));
            ?>
        </div>

        <!-- Footer Contact Information -->
        <div class="footer-contact">
            <h4>Contact</h4>
            <p><?php echo esc_textarea(get_option('footer_address', 'No address specified.')); ?></p>

            <!-- Social Media Links -->
            <ul class="social-links">
                <?php if ($facebook = get_option('footer_facebook')): ?>
                    <li><a href="<?php echo esc_url($facebook); ?>" target="_blank">Facebook</a></li>
                <?php endif; ?>
                <?php if ($twitter = get_option('footer_twitter')): ?>
                    <li><a href="<?php echo esc_url($twitter); ?>" target="_blank">Twitter</a></li>
                <?php endif; ?>
                <?php if ($linkedin = get_option('footer_linkedin')): ?>
                    <li><a href="<?php echo esc_url($linkedin); ?>" target="_blank">LinkedIn</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>Copyright © <?php echo date("Y"); ?> Kalki Automations. All Rights Reserved.</p>
        <a href="<?php echo site_url('/terms-conditions'); ?>">Terms & Conditions</a> |
        <a href="<?php echo site_url('/privacy-policy'); ?>">Privacy Policy</a>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>


</body>
</html>
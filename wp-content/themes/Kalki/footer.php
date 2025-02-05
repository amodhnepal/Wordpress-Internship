<?php wp_footer(); ?>
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/white_logo_kalki.png" alt="Kalki Automation Logo">
        </div>
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
        <div class="footer-contact">
            <h4>Connect</h4>
            <p>Kathmandu, Nepal<br>44600</p>
            <ul class="social-links">
                <li><a href="https://facebook.com/" target="_blank">Facebook</a></li>
                <li><a href="https://twitter.com/" target="_blank">Twitter</a></li>
                <li><a href="https://linkedin.com/" target="_blank">LinkedIn</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>Copyright © <?php echo date("Y"); ?> Kalki Automations. All Rights Reserved.</p>
        <a href="<?php echo site_url('/terms-conditions'); ?>">Terms & Conditions</a> |
        <a href="<?php echo site_url('/privacy-policy'); ?>">Privacy Policy</a>
    </div>
</footer>

</body>
</html>
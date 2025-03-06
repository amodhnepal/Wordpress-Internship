<?php get_header();  ?>

<?php
/* Template Name: My Account */
defined('ABSPATH') || exit;

// Get current WooCommerce endpoint
$current_endpoint = WC()->query->get_current_endpoint();

?>

<div class="custom-my-account-container">
    <h2>My Account</h2>

    <div class="account-header">
        <p>Welcome, <?php echo esc_html(wp_get_current_user()->display_name); ?>!</p>
        <p>Email: <?php echo esc_html(wp_get_current_user()->user_email); ?></p>
    </div>

    <div class="account-dashboard">
        <div class="account-navigation">
            <ul>
                <li class="<?php echo ($current_endpoint == '') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>">Dashboard</a>
                </li>
                <li class="<?php echo ($current_endpoint == 'orders') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>">Orders</a>
                </li>
                <li class="<?php echo ($current_endpoint == 'downloads') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>">Downloads</a>
                </li>
                <li class="<?php echo ($current_endpoint == 'edit-address') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>">Addresses</a>
                </li>
                <li class="<?php echo ($current_endpoint == 'edit-account') ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>">Account Details</a>
                </li>
                <li>
                    <a href="<?php echo esc_url(wc_logout_url()); ?>">Logout</a>
                </li>
            </ul>
        </div>

        <div class="account-content">
            <?php
            // Display content for the selected endpoint
            do_action('woocommerce_account_content');
            ?>
        </div>
    </div>
</div>

<?php get_footer();  ?>
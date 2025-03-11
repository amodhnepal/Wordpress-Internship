<?php
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled, user must be logged in
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html__('You must be logged in to checkout.', 'woocommerce');
    return;
}
?>

<div class="checkout-form-container">
    <h2 class="checkout-title">Checkout</h2>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="checkout-content-wrapper">
            
            <!-- Billing Details Section -->
            <div class="checkout-left">
                <?php do_action('woocommerce_checkout_billing'); ?>
            </div>

            <!-- Shipping Details Section -->
            <div class="checkout-right">
                <h3>Shipping Details</h3>
                <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>

        </div>

        <!-- Order Summary Section -->
        <div class="checkout-summary">
            <h3>Order Summary</h3>
            <?php do_action('woocommerce_checkout_order_review'); ?>
            <!-- <button type="submit" class="place-order-button" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e('Place Order', domain: 'woocommerce'); ?>">
                <?php esc_html_e('Place Order', 'woocommerce'); ?>
            </button> -->
        </div>
        
    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

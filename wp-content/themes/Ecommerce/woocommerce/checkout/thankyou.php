<?php
defined('ABSPATH') || exit;

$order_id = isset($_GET['key']) ? wc_get_order_id_by_order_key($_GET['key']) : 0;
$order = wc_get_order($order_id);

if (!$order) {
    echo '<p class="error-message">Something went wrong. No order found.</p>';
    return;
}

// Load CSS
wp_enqueue_style('invoice-style', get_template_directory_uri() . '/css/invoice-style.css');
?>

<div class="invoice-container">
    <!-- Header Section -->
    <div class="invoice-header">
        <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Company Logo">
        <div class="invoice-title">Thank You for Your Order!</div>
        <div class="invoice-details">
            <p>Order Number: <strong>#<?php echo $order->get_order_number(); ?></strong></p>
            <p>Order Date: <strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong></p>
            <p>Payment Method: <strong><?php echo $order->get_payment_method_title(); ?></strong></p>
        </div>
    </div>

    <!-- Customer & Billing Details -->
    <div class="customer-details">
        <div>
            <h3>Customer Details</h3>
            <p><?php echo esc_html($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?></p>
            <p><?php echo esc_html($order->get_billing_email()); ?></p>
            <p><?php echo esc_html($order->get_billing_phone()); ?></p>
        </div>
        <div>
            <h3>Billing Address</h3>
            <p><?php echo esc_html($order->get_formatted_billing_address()); ?></p>
        </div>
        <div>
            <h3>Shipping Address</h3>
            <p><?php echo esc_html($order->get_formatted_shipping_address()); ?></p>
        </div>
    </div>

    <!-- Order Summary Table -->
    <table class="order-summary">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->get_items() as $item_id => $item) : 
                $product = $item->get_product();
            ?>
            <tr>
                <td><?php echo esc_html($item->get_name()); ?></td>
                <td><?php echo esc_html($item->get_quantity()); ?></td>
                <td><?php echo wc_price($product->get_price()); ?></td>
                <td><?php echo wc_price($item->get_total()); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Order Totals -->
    <div class="totals">
        <p>Subtotal: <?php echo wc_price($order->get_subtotal()); ?></p>
        <p>Taxes: <?php echo wc_price($order->get_total_tax()); ?></p>
        <p>Shipping Fee: <?php echo wc_price($order->get_shipping_total()); ?></p>
        <p class="final-total">Final Total: <?php echo wc_price($order->get_total()); ?></p>
    </div>

    <!-- Download Receipt Button -->
    <a href="<?php echo esc_url(add_query_arg(['download_invoice' => $order->get_id()], home_url('/download-receipt/'))); ?>" class="download-receipt-btn">
        Download Receipt (PDF)
    </a>

    <!-- Footer -->
    <div class="invoice-footer">
        <p>Thank you for shopping with us!</p>
        <p>Contact us at <a href="mailto:support@example.com">support@example.com</a> for any queries.</p>
        <p><a href="#">Terms & Conditions</a></p>
    </div>
</div>

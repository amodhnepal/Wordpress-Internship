<?php
defined( 'ABSPATH' ) || exit;
?>

<h2>🛒 Your Orders</h2>

<?php
do_action( 'woocommerce_before_account_orders', $has_orders );

if ( $has_orders ) : ?>

    <table class="woocommerce-orders-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f7f7f7; text-align: left; padding: 10px; border-bottom: 2px solid #F6AA28;">
                <th style="padding: 10px 20px;">Order ID</th>
                <th style="padding: 10px 20px;">Status</th>
                <th style="padding: 10px 20px;">Date</th>
                <th style="padding: 10px 20px;">Total</th>
                <th style="padding: 10px 20px;">Actions</th>
            </tr>
        </thead>
        <tbody >
            <?php foreach ( $customer_orders->orders as $customer_order ) :
                $order = wc_get_order( $customer_order ); ?>
                <tr style="border-bottom: 1px solid #ddd; text-align: left; padding: 10px 0;">
                    <td style="padding: 10px 20px;"><?php echo esc_html( $order->get_order_number() ); ?></td>
                    <td style="padding: 10px 20px;"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></td>
                    <td style="padding: 10px 20px;"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
                    <td style="padding: 10px 20px;"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
                    <td style="padding: 10px 20px; "><a style="background-color: black; color:white; padding: 4px 8px; border-radius:5px; text-decoration: none;" href="<?php echo esc_url( $order->get_view_order_url() ); ?>"> View</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>
    <p>You have no orders yet.</p>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>

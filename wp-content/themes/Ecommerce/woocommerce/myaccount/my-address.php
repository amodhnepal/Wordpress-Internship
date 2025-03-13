<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing'  => __( 'Billing address', 'woocommerce' ),
            'shipping' => __( 'Shipping address', 'woocommerce' ),
        ),
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing' => __( 'Billing address', 'woocommerce' ),
        ),
        $customer_id
    );
}

$oldcol = 1;
$col    = 1;
?>

<p style="font-size: 16px; color: #333; margin-bottom: 20px;">
    <?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
    <div class="u-columns woocommerce-Addresses col2-set addresses" style="display: flex; justify-content: space-between; gap: 20px;">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
    <?php
        $address = wc_get_account_formatted_address( $name );
        $col     = $col * -1;
        $oldcol  = $oldcol * -1;
    ?>

    <div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address" style="width: 48%; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <header class="woocommerce-Address-title title" style="font-size: 18px; margin-bottom: 15px; color: #333;">
            <h2><?php echo esc_html( $address_title ); ?></h2>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit" style="font-size: 14px; color: #0073e6; text-decoration: none;">
                <?php
                    printf(
                        $address ? esc_html__( 'Edit %s', 'woocommerce' ) : esc_html__( 'Add %s', 'woocommerce' ),
                        esc_html( $address_title )
                    );
                ?>
            </a>
        </header>
        <address style="font-size: 14px; color: #555;">
            <?php
                echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );

                /**
                 * Used to output content after core address fields.
                 *
                 * @param string $name Address type.
                 * @since 8.7.0
                 */
                do_action( 'woocommerce_my_account_after_my_address', $name );
            ?>
        </address>
    </div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
    </div>
<?php endif; ?>

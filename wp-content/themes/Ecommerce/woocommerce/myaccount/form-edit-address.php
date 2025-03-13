<style>
.form-row-first-full,
.form-row-last-full {
  width: 100% !important; /* Override other styles */
}

.form-row-first,.form-row-last{
    width: 100% !important;
}
</style>

<?php
/**
 * Edit address form
 *
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'woocommerce' ) : esc_html__( 'Shipping address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form method="post" novalidate style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">

		<h2 style="margin-bottom: 20px; text-align: center;"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h2>

		<div class="woocommerce-address-fields" style="display: flex; flex-wrap: wrap; gap: 15px;">
			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

			<?php
			$address_fields_layout = [
				['billing_first_name', 'billing_last_name'],
				['billing_country'],
				['billing_address_1', 'billing_address_2'],
				['billing_city', 'billing_state'],
				['billing_postcode', 'billing_phone'],
				['billing_email']
			];

			foreach ($address_fields_layout as $row) {
				echo '<div style="display: flex; width: 100%; align-items:end; gap: 15px; box-sizing: border-box;">';
				foreach ($row as $field_key) {
					$field = $address[$field_key] ?? null; // Use null coalescing operator
					if ($field) {
						$width = count($row) > 1 ? 'calc(50% - 7.5px)' : '100%'; // Adjust width based on number of fields in row
						$width_style = 'width: ' . $width . ';'; // Create a variable for the width style


						echo '<div style="' . $width_style . ' box-sizing: border-box;" class="' . (strpos($field['class'][0] ?? '', 'form-row-first') !== false ? 'form-row-first-full' : '') . ' ' . (strpos($field['class'][0] ?? '', 'form-row-last') !== false ? 'form-row-last-full' : '') . '">';
						woocommerce_form_field($field_key, $field, wc_get_post_data_by_key($field_key, $field['value']));
						echo '</div>';
					}
				}
				echo '</div>';
			}
			?>

			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

			<div style="width: 100%; text-align: right;">
				<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
					<?php esc_html_e( 'Save address', 'woocommerce' ); ?>
				</button>
				<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
				<input type="hidden" name="action" value="edit_address" />
			</div>
		</div>

	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>

<style>
.form-row-first-full,
.form-row-last-full {
  width: 100% !important; /* Override other styles */
}
</style>
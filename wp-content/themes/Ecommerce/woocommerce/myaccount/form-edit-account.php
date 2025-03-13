<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

    <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <!-- Left Column (Names and Email) -->
    <div class="form-left">
        <!-- First Name -->
        <div class="form-row">
            <label for="account_first_name" class="form-label"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-input" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" aria-required="true" />
        </div>

        <!-- Last Name -->
        <div class="form-row">
            <label for="account_last_name" class="form-label"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-input" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" aria-required="true" />
        </div>

        <!-- Display Name -->
        <div class="form-row">
            <label for="account_display_name" class="form-label"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-input" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr( $user->display_name ); ?>" aria-required="true" />
            <span id="account_display_name_description" class="form-description"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
        </div>

        <!-- Email -->
        <div class="form-row">
            <label for="account_email" class="form-label"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-input" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" aria-required="true" />
        </div>
    </div>

    <!-- Right Column (Password Change) -->
    <div class="form-right">
            <legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

            <!-- Current Password -->
            <div class="form-row">
                <label for="password_current" class="form-label"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-input" name="password_current" id="password_current" autocomplete="off" />
            </div>

            <!-- New Password -->
            <div class="form-row">
                <label for="password_1" class="form-label"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-input" name="password_1" id="password_1" autocomplete="off" />
            </div>

            <!-- Confirm New Password -->
            <div class="form-row">
                <label for="password_2" class="form-label"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-input" name="password_2" id="password_2" autocomplete="off" />
            </div>
    </div>

    <!-- Full-width Save Changes Button -->
    <div class="form-footer" style="grid-column: span 2; justify-content:end;">
        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
        <button type="submit" class="woocommerce-Button button form-button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
        <input type="hidden" name="action" value="save_account_details" />
    </div>

    <?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>


<?php
/**
 * Template Name: Cart Page
 */

 get_template_part('assets/inc/header');;
?>

<main class="cart-container">
    <h1>Your Shopping Cart</h1>

    <?php if (WC()->cart->is_empty()) : ?>
        <p class="empty-cart">Your cart is currently empty.</p>
    <?php else : ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $product = $cart_item['data'];
                    $product_id = $cart_item['product_id'];
                    ?>
                    <tr>
                        <td class="cart-product">
                            <a href="<?php echo get_permalink($product_id); ?>">
                                <?php echo get_the_post_thumbnail($product_id, 'thumbnail'); ?>
                                <?php echo $product->get_name(); ?>
                            </a>
                        </td>
                        <td class="cart-price"><?php echo wc_price($product->get_price()); ?></td>
                        <td class="cart-quantity">
                            <form method="post">
                                <input type="number" name="cart[<?php echo $cart_item_key; ?>][qty]" value="<?php echo $cart_item['quantity']; ?>" min="1">
                                <button type="submit" name="update_cart" class="update-button">Update</button>
                                <?php do_action('woocommerce_cart_actions'); ?>
                            </form>
                        </td>
                        <td class="cart-subtotal"><?php echo wc_price($cart_item['line_total']); ?></td>
                        <td class="cart-remove">
                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="remove">&times;</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="cart-totals">
            <h2>Cart Totals</h2>
            <p><strong>Total:</strong> <?php echo WC()->cart->get_total(); ?></p>
            <a href="<?php echo wc_get_checkout_url(); ?>" class="checkout-button">Proceed to Checkout</a>
        </div>

    <?php endif; ?>
</main>

<?php get_template_part('assets/inc/footer'); ?>

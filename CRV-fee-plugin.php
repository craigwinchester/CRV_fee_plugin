<?php
/**
 * Plugin Name: Lo-Fi Wines CRV Fee
 * Description: Adds a $0.10 CRV (California Redemption Value) fee per item shipped to California. Supports admin settings.
 * Version: 1.1
 * Author: Lo-Fi Wines
 */

if (!defined('ABSPATH')) exit;

// ---------------------------
// 1. Register Settings
// ---------------------------

function lfw_crv_register_settings() {
    add_option('lfw_crv_enabled', 'yes');
    add_option('lfw_crv_amount', 0.10);
    add_option('lfw_crv_categories', []); // NEW: category filter
    register_setting('lfw_crv_options_group', 'lfw_crv_enabled');
    register_setting('lfw_crv_options_group', 'lfw_crv_amount');
    register_setting('lfw_crv_options_group', 'lfw_crv_categories');
}
add_action('admin_init', 'lfw_crv_register_settings');

// ---------------------------
// 2. Add Settings Page
// ---------------------------

function lfw_crv_register_options_page() {
    add_submenu_page(
        'woocommerce',
        'CRV Fee Settings',
        'CRV Fee Settings',
        'manage_options',
        'lfw-crv-settings',
        'lfw_crv_options_page'
    );
}
add_action('admin_menu', 'lfw_crv_register_options_page');

function lfw_crv_options_page() {
    $selected_cats = (array) get_option('lfw_crv_categories', []);
    $all_cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
    ?>
    <div class="wrap">
        <h1>Lo-Fi Wines CRV Fee Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('lfw_crv_options_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enable CRV Fee</th>
                    <td>
                        <select name="lfw_crv_enabled">
                            <option value="yes" <?php selected(get_option('lfw_crv_enabled'), 'yes'); ?>>Yes</option>
                            <option value="no" <?php selected(get_option('lfw_crv_enabled'), 'no'); ?>>No</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">CRV Amount per Item ($)</th>
                    <td>
                        <input type="number" step="0.01" min="0" name="lfw_crv_amount" value="<?php echo esc_attr(get_option('lfw_crv_amount')); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Apply Only to Categories</th>
                    <td>
                        <select name="lfw_crv_categories[]" multiple size="6" style="min-width: 250px;">
                            <?php foreach ($all_cats as $cat): ?>
                                <option value="<?php echo $cat->term_id; ?>" <?php selected(in_array($cat->term_id, $selected_cats)); ?>>
                                    <?php echo esc_html($cat->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description">Hold Ctrl (Cmd on Mac) to select multiple categories.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// ---------------------------
// 3. Add CRV Fee at Checkout
// ---------------------------

add_action('woocommerce_cart_calculate_fees', 'lfw_calculate_and_add_crv', 20, 1);

function lfw_calculate_and_add_crv($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    if (get_option('lfw_crv_enabled') !== 'yes') return;

    $state = WC()->customer->get_shipping_state();
    if ($state !== 'CA') return;

    $crv_amount = floatval(get_option('lfw_crv_amount', 0.10));
    $selected_categories = (array) get_option('lfw_crv_categories', []);
    if ($crv_amount <= 0) return;

    $total_crv = 0;
    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        $terms = get_the_terms($product->get_id(), 'product_cat');
        if (!$terms || is_wp_error($terms)) continue;

        $product_cat_ids = wp_list_pluck($terms, 'term_id');
        $intersects = array_intersect($product_cat_ids, $selected_categories);
        if (!empty($intersects)) {
            $total_crv += $crv_amount * $cart_item['quantity'];
        }
    }

    if ($total_crv > 0) {
        $cart->add_fee('CRV - CalRecycle', $total_crv, true);
    }
}

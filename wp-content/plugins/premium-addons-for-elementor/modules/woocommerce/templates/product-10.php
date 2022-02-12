<?php
/**
 * PA WooCommerce Products - Template.
 *
 * @package PA
 */

use PremiumAddons\Includes\Premium_Template_Tags;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>

<?php

$product_id      = $product->get_id();
$class           = array();
$classes         = array();
$classes[]       = 'post-' . $product_id;
$wc_classes      = implode( ' ', wc_product_post_class( $classes, $class, $product_id ) );
$image_size      = $settings['featured_image_size'];
$sale_ribbon     = self::$settings['sale'];
$featured_ribbon = self::$settings['featured'];
$quick_view      = $this->get_option_value( 'quick_view' );

if ( 'yes' === $quick_view ) {
	$qv_type = $this->get_option_value( 'quick_view_type' );
}

$product_type = $product->get_type();

if ( $product->is_in_stock() ) {

	switch ( $product_type ) {
		case 'simple':
			$cta_string = __( 'Add To Cart', 'elementor' );
			break;

		case 'grouped':
			$cta_string = __( 'View Products', 'elementor' );
			break;

		case 'external':
			$cta_string = __( 'Purchase', 'elementor' );
			break;

		case 'variable':
			$cta_string = __( 'Select Options', 'elementor' );
			break;
	}
} else {
	$cta_string = __( 'Read More', 'elementor' );
}

$out_of_stock = 'outofstock' === get_post_meta( $product_id, '_stock_status', true ) && 'yes' === self::$settings['sold_out'];

?>
<li class="<?php echo esc_attr( $wc_classes ); ?>">
	<div class="premium-woo-product-wrapper">
		<?php

		echo '<div class="premium-woo-product-thumbnail">';
		if ( $out_of_stock ) {
			echo '<span class="pa-out-of-stock">' . esc_html( self::$settings['sold_out_string'] ) . '</span>';
		} else {
			if ( 'yes' === $sale_ribbon || 'yes' === $featured_ribbon ) {

				echo '<div class="premium-woo-ribbon-container">';

				if ( 'yes' === $sale_ribbon ) {
					include PREMIUM_ADDONS_PATH . 'modules/woocommerce/templates/loop/sale-ribbon.php';
				}

				if ( 'yes' === $featured_ribbon ) {
					include PREMIUM_ADDONS_PATH . 'modules/woocommerce/templates/loop/featured-ribbon.php';
				}

				echo '</div>';
			}
		}

			woocommerce_template_loop_product_link_open();

		if ( 'yes' === $this->get_option_value( 'product_image' ) ) {
			echo '<img src="' . esc_url( get_the_post_thumbnail_url( $product_id, $image_size ) ) . '">';
		}

		if ( 'swap' === $settings['hover_style'] ) {
			Premium_Template_Tags::get_current_product_swap_image( $image_size );
		}

		woocommerce_template_loop_product_link_close();

		if ( 'yes' === $quick_view ) {
			echo '<div class="premium-woo-qv-btn" data-product-id="' . esc_attr( $product_id ) . '"><i class="fas fa-search"></i></div>';
		}

		echo '</div>';

		do_action( 'pa_woo_product_before_details_wrap_start', $product_id, $settings );
		echo '<div class="premium-woo-products-details-wrap">';
		do_action( 'pa_woo_product_after_details_wrap_start', $product_id, $settings );

		if ( 'yes' === $this->get_option_value( 'product_title' ) ) {
			do_action( 'pa_woo_product_before_title', $product_id, $settings );
			echo '<a href="' . esc_url( apply_filters( 'premium_woo_product_title_link', get_the_permalink() ) ) . '" class="premium-woo-product__link">';
				woocommerce_template_loop_product_title();
			echo '</a>';
			do_action( 'pa_woo_product_after_title', $product_id, $settings );
		}

		if ( 'yes' === $this->get_option_value( 'product_category' ) ) {
			do_action( 'pa_woo_product_before_cat', $product_id, $settings );
			Premium_Template_Tags::get_current_product_category();
			do_action( 'pa_woo_product_after_cat', $product_id, $settings );
		}

		if ( 'yes' === $this->get_option_value( 'product_rating' ) ) {
			do_action( 'pa_woo_product_before_rating', $product_id, $settings );
			woocommerce_template_loop_rating();
			do_action( 'pa_woo_product_after_rating', $product_id, $settings );
		}

		// if ( 'yes' === $this->get_option_value( 'product_excerpt' ) ) {
		// Premium_Template_Tags::get_product_excerpt();
		// }

			echo '<div class="premium-woo-product-info">';
		if ( 'yes' === $this->get_option_value( 'product_price' ) ) {
			do_action( 'pa_woo_product_before_price', $product_id, $settings );
			woocommerce_template_loop_price();
			do_action( 'pa_woo_product_after_price', $product_id, $settings );
		}

		if ( 'yes' === $this->get_option_value( 'product_cta' ) ) {
			do_action( 'pa_woo_product_before_cta', $product_id, $settings );
			echo '<div class="premium-woo-atc-button">';
				$cart_class = $product->is_purchasable() && $product->is_in_stock() ? 'premium-woo-product-cta-btn' : '';
				echo '<a href=' . esc_url( $product->add_to_cart_url() ) . ' class="premium-woo-cart-btn ' . esc_attr( $cart_class ) . ' product_type_' . esc_html( $product_type ) . '" data-product_id="' . esc_attr( $product_id ) . '">';
				echo '<span class="premium-woo-add-cart-icon fas fa-plus"></span>';
				echo '<span class="premium-woo-add-cart-icon-text">' . esc_html( $cta_string ) . '</span>';
				echo '</a>';
			echo '</div>';
			do_action( 'pa_woo_product_after_cta', $product_id, $settings );
		}

		echo '</div>';
		do_action( 'pa_woo_product_before_details_wrap_end', $product_id, $settings );
		echo '</div>';
		do_action( 'pa_woo_product_after_details_wrap_end', $product_id, $settings );

		?>
	</div>
</li>

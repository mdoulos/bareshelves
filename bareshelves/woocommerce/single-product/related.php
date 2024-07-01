<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products product-page-related-products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<ul class="product-page-related-products-list">
		

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					global $product;

					// Ensure visibility.
					if ( empty( $related_product ) || ! $related_product->is_visible() ) {
						return;
					}

					?>

					<li class="product-page-related-product">
						<?php
						$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $related_product );
						$product_type = $related_product->get_type();

						wc_get_template( 'loop/sale-flash.php' );

						echo '<a href="' . esc_url( $link ) . '" class="product-page-related-product-link">';

							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo woocommerce_get_product_thumbnail();

							echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

							wc_get_template( 'loop/price.php' );

						echo '</a>';
						?>
					</li>

			<?php endforeach; ?>

		</ul>

	</section>
	<?php
endif;

wp_reset_postdata();

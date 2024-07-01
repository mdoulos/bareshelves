<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_template_part('head');
$categories_to_display = 0;
?>

<main id="primary" class="site-main main-product main-normal main-wc-archive">
	<div class="site-width-centered main-wc-archive__inner">
		<?php woocommerce_breadcrumb(); ?>

		<div class="shop-page flex-row">

			<div class="shop-sidebar-wrapper">
				<section class="shop-sidebar">
					<?php

					$get_toplevel_cats = get_categories(array( 
						//'posts_per_page' => -1,  
						'hierarchical' => 100,  
						'show_option_none' => '',  
						'hide_empty' => 0,  
						'parent' => 0,  
						'taxonomy' => 'product_cat' 
					));

					
					if(is_product_category()) { 
						global $wp_query;

						/** Grabs the current open product category and all ancestors of it. **/ 
						$this_cat = $wp_query->get_queried_object();
						$ancestor_cats = get_ancestors( $this_cat->term_id, 'product_cat' );

						echo '<h2>All Categories</h2>';
						echo '<nav class="shop-page-categories-nav">';

							// Top Level Categories
							echo '<ul class="toplevel_catlist" id="all-cat-list">';
								foreach ($get_toplevel_cats as $toplevel_cat) {
									if ($toplevel_cat->category_count != 0 && $toplevel_cat->name != "Products") {
										$get_link = get_term_link( $toplevel_cat->slug, $toplevel_cat->taxonomy );

										// If this cat is the current cat, add a class to it.
										$this_cat_class = ($toplevel_cat->term_id == $this_cat->term_id) ? " class='this-cat' " : "";
										
										echo '<li'. $this_cat_class .'><a href="'. $get_link .'">'.$toplevel_cat->name.'</a>';

											// If toplevel_cat is in the ancestor_cats array of this_cat, display the sub categories.
											if (in_array($toplevel_cat->term_id, $ancestor_cats) || $toplevel_cat->term_id == $this_cat->term_id) {
												echo '<ul class="sub_catlist secondlevel_catlist">';

													$get_secondlevel_cats = get_categories(array( 
														//'posts_per_page' => -1,  
														'hierarchical' => 100,  
														'show_option_none' => '',  
														'hide_empty' => 0,  
														'parent' => $toplevel_cat->term_id,  
														'taxonomy' => 'product_cat' 
													));

													foreach ($get_secondlevel_cats as $secondlevel_cat) {
														if ($secondlevel_cat->category_count != 0) {
															$get_link = get_term_link( $secondlevel_cat->slug, $secondlevel_cat->taxonomy );

															// If this cat is the current cat, add a class to it.
															$this_cat_class = ($secondlevel_cat->term_id == $this_cat->term_id) ? " class='this-cat' " : "";

															echo '<li'. $this_cat_class .'><a href="'. $get_link .'">'.$secondlevel_cat->name.' <span>('.$secondlevel_cat->category_count.')</span></a>';

																// If secondlevel_cat is in the ancestor_cats array of this_cat, display the sub categories.
																if (in_array($secondlevel_cat->term_id, $ancestor_cats) || $secondlevel_cat->term_id == $this_cat->term_id) {
																	echo '<ul class="sub_catlist thirdlevel_catlist">';
																		$get_thirdlevel_cats = get_categories(array( 
																			//'posts_per_page' => -1,  
																			'hierarchical' => 100,  
																			'show_option_none' => '',  
																			'hide_empty' => 0,  
																			'parent' => $secondlevel_cat->term_id,  
																			'taxonomy' => 'product_cat' 
																		));

																		foreach ($get_thirdlevel_cats as $thirdlevel_cat) {
																			if ($thirdlevel_cat->category_count != 0) {
																				$get_link = get_term_link( $thirdlevel_cat->slug, $thirdlevel_cat->taxonomy );

																				// If this cat is the current cat, add a class to it.
																				$this_cat_class = ($thirdlevel_cat->term_id == $this_cat->term_id) ? " class='this-cat' " : "";

																				echo '<li'. $this_cat_class .'><a href="'. $get_link .'">'.$thirdlevel_cat->name.' <span>('.$thirdlevel_cat->category_count.')</span></a>';

																					// If thirdlevel_cat is in the ancestor_cats array of this_cat, display the sub categories.
																					if (in_array($thirdlevel_cat->term_id, $ancestor_cats) || $thirdlevel_cat->term_id == $this_cat->term_id) {
																						echo '<ul class="sub_catlist fourthlevel_catlist">';
																							$get_fourthlevel_cats = get_categories(array( 
																								//'posts_per_page' => -1,  
																								'hierarchical' => 100,  
																								'show_option_none' => '',  
																								'hide_empty' => 0,  
																								'parent' => $thirdlevel_cat->term_id,  
																								'taxonomy' => 'product_cat' 
																							));
																							foreach ($get_fourthlevel_cats as $fourthlevel_cat) {
																								if ($fourthlevel_cat->category_count != 0) {
																									$get_link = get_term_link( $fourthlevel_cat->slug, $fourthlevel_cat->taxonomy );

																									// If this cat is the current cat, add a class to it.
																									$this_cat_class = ($fourthlevel_cat->term_id == $this_cat->term_id) ? " class='this-cat' " : "";
							
																									echo '<li'. $this_cat_class .'><a href="'. $get_link .'">'.$fourthlevel_cat->name.' <span>('.$fourthlevel_cat->category_count.')</span></a></li>';
																								}
																							}
																						echo '</ul>';
																					}
																				echo '</li>';
																			}
																		}
																	echo '</ul>';
																}
															echo '</li>';
														}
													}
												echo '</ul>';
											}
										echo '</li>';
									}
								}
							echo '</ul>';
						echo '</nav>';

					} else {

						echo '<h2>All Categories</h2>';
						echo '<nav class="shop-page-categories-nav">';

							echo '<ul class="toplevel_catlist" id="all-cat-list">';
								foreach ($get_toplevel_cats as $toplevel_cat)
								{
									if ($toplevel_cat->category_count != 0) {
										if ($toplevel_cat->name != "Products") {
											$get_link = get_term_link( $toplevel_cat->slug, $toplevel_cat->taxonomy );
											echo '<li><a href="'. $get_link .'">'.$toplevel_cat->name.'</a></li>';
										}
									}
								}
							echo '</ul>';
						echo '</nav>';
								
					}

					dynamic_sidebar( 'sidebar-1' );
					?>
					
				</section>
			</div>

			<section class="shop-content">
				<div class="mobile-shop-sidebar hidden">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div>

				<header class="woocommerce-products-header">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
					<?php endif; ?>
				</header>

				<?php

				if ( woocommerce_product_loop() ) {

					echo '<div class="shop-archive-pre flex-row">';
						woocommerce_result_count();
						woocommerce_catalog_ordering();
					echo '</div>';

					echo '<ul class="products shop-page-loop">';

					if ( wc_get_loop_prop( 'total' ) ) {

						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action( 'woocommerce_shop_loop' );

							global $product;

							// Ensure visibility.
							if ( empty( $product ) || ! $product->is_visible() ) {
								return;
							}

							?>
								<li class="shop-product-li">
									<?php
										$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
										$product_type = $product->get_type();
										$product_id = $product->get_id();

										wc_get_template( 'loop/sale-flash.php' );

										echo '<a href="' . esc_url( $link ) . '" class="shop-product-link shop-product-link-img">';

											echo woocommerce_get_product_thumbnail();

											echo '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>';
											wc_get_template( 'loop/rating.php' );
											wc_get_template( 'loop/price.php' );
											echo '<div class="shop-product-sku"><span>SKU: </span><span>' . $product->get_sku() . '</span></div>';

											// if product is single, show the stock
											if ($product_type == 'simple') {
												$stock_count = $product->get_stock_quantity();
												$manage_stock_option = $product->get_manage_stock();
												$stock_status = $product->get_stock_status();

												if ($manage_stock_option) {
													if ($stock_count == 0 || $stock_count < 0) {
														echo '<div class="shop-product-stock shop-product-out-of-stock"><span>Out of stock.</span></div>';
													} elseif ($stock_count != null) {
														echo '<div class="shop-product-stock"><span>Stock: </span><span>' . $stock_count . '</span></div>';
													}
												} elseif ($stock_status === 'instock') {
													echo '<div class="shop-product-stock"><span>In stock.</span></div>';
												}
											} else {
												echo '<div class="shop-product-stock"><span>Click to see stock.</span></div>';
											}

										echo '</a>';

										do_action('pmw_print_product_data_layer_script_by_product_id', $product_id);
									?>
								</li>

							<?php
						}
					}

					echo '</ul>';

					echo '<div class="shop-archive-post flex-row">';
						woocommerce_result_count();
						woocommerce_pagination();
					echo '</div>';
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				}

				if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
					$term = get_queried_object();

					if ( $term && ! empty( $term->description ) ) {
						echo '<div class="term-description">' . get_term_field( 'description', $term ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				}
				
				?>

			</section> <!-- shop-content -->
		</div> <!-- shop-page -->
	</div> <!-- main-wc-archive__inner -->
</main>

<?php
get_footer( 'shop' );

<?php

/**
 * @package woocomerce_plugIn
 *
 * plugin name: Single Product Navigation by Category
 * Description: "Single Product Navigation by Category" plug in is developed so when a user/customer visits a single product page/post can navigate to next or previous products which belongs to tha same product-category.
 */

add_action ('woocommerce_before_single_product', 'single_product_navigation', 15);
function single_product_navigation() {

	if ( is_singular('product') ) {

		global $product;

		$id = $product->get_id();
		$categories = get_the_terms( get_the_ID(), 'product_cat' );

		if ( $categories && ! is_wp_error( $category ) ) {

			foreach ( $categories as $category ) {
				$children = get_categories(array('taxonomy' => 'product_cat', 'parent' => $category->term_id ));

				if ( count($children) == 0 ) {
					$cat_id = $category->term_id;
				}
			}
		}

		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'product',
			'stock_status' => array('instock','onbackorder'),
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'terms' => $cat_id,
				),
			),
		);

		$products = wc_get_products($args);
		$count = -1;
		$total_prods = -1;

		foreach ( $products as $product ) {
			$count++;
			if ($product->get_id() == $id) {
				break;
			}
		}

		$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];

		if ( get_the_permalink($products[$count-1]->id) == $url && get_the_permalink($products[$count+1]->id) != $url ){
			echo ' <span class="prev_btn"> <a href="#"> - </a> </span> ';
			echo ' <span class="next_btn"> <a href=" ' . get_the_permalink($products[$count+1]->id) . ' "> >> </a> </span> ';
		}

		if ( get_the_permalink($products[$count-1]->id) != $url && get_the_permalink($products[$count+1]->id) == $url ){
			echo ' <span class="prev_btn"> <a href=" ' . get_the_permalink($products[$count-1]->id) . ' "> << </a> </span> ';
			echo ' <span class="next_btn"> <a href="#"> - </a> </span> ';
		}

		if ( get_the_permalink($products[$count-1]->id) != $url && get_the_permalink($products[$count+1]->id) != $url ){
			echo ' <span class="prev_btn"> <a href=" ' . get_the_permalink($products[$count-1]->id) . ' "> << </a> </span> ';
			echo ' <span class="next_btn"> <a href=" ' . get_the_permalink($products[$count+1]->id) . ' "> >> </a> </span> ';
		}

		if ( get_the_permalink($products[$count-1]->id) == $url && get_the_permalink($products[$count+1]->id) == $url ){
			echo ' <span class="prev_btn"> <a href="#"> - </a> </span> ';
			echo ' <span class="next_btn"> <a href="#"> - </a> </span> ';
		}

		wp_reset_postdata();
		wp_reset_query();
	}

}


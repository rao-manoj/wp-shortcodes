<?php

function lp_products_render( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
            'sku'=>'',
            'tag'=>'',
            'category'=>''
		),
		$atts,
		'lp_products'
	);

    $tags=explode(',',$atts['tag']);
    $skus=explode(',',$atts['sku']);
    $categories=explode(',',$atts['category']);

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 12
    );
    if(!empty($skus)){
        $args['meta_key'] = '_sku';
        $args['meta_value']= $skus;
    }
	$loop = new \WP_Query( $args );



	add_action( 'woocommerce_before_shop_loop_item_title', 'lp_products_origin');

	if (!function_exists('lp_products_origin')){

		function lp_products_origin(){

			global $product;

			$origin= get_post_meta($product->get_id(), 'origin', true);

			if(!empty($origin) && strtolower($origin)!='india'){

				echo '<span class="onsale" style="font-size:0.7em; left:2px;right:auto; background-color:#0ba38f">'.'IMPORTED'. '</span>';
			}else{
				echo '<span class="onsale" style="font-size:0.7em; left:2px;right:auto; background-color:#0F4C81">'.'MADE IN INDIA'. '</span>';
			}
		}
	}

	add_action( 'woocommerce_after_shop_loop_item','lp_after_product_title' );
	if (!function_exists('lp_after_product_title')){
		function lp_after_product_title(){
            global $product;
            echo '<p style="text-align:center;padding:0 10px;font-size:14px">'.get_post_meta($product->get_id(), 'product_excerpt', true).'</p>';
        }
	}

	ob_start();
	?>


	<div class="woocommerce columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
		<ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
			<?php
				if ( $loop->have_posts() ) {
					while ( $loop->have_posts() ) : $loop->the_post();
					wc_get_template_part( 'content', 'product' );
					endwhile;
				} else {
					echo __( 'No products found' );
				}
				wp_reset_postdata();
			?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
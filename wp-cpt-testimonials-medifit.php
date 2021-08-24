<?php

add_shortcode( 'testimonials', 'testimonials_render' );

function testimonials_render($atts) {

	// Attributes
	$atts = shortcode_atts(
		array(

		),
		$atts,
		'testimonials'
	);


    $args = array(
        'post_type' => 'testimonials',
        'post_status' => 'publish',
        'orderby'=>'ID',
        'order'=>'ASC'
    );

    $loop = new \WP_Query( $args );

    ob_start();
    ?>

    <?php

    if ( $loop->have_posts()){
    ?>
        <div id="testimonials">
            <div class="rc_carousel">
                <button class="rc_carousel_button rc_carousel_button--prev"></button>
                <div class="rc_carousel_wrap">
                    <ul class="rc_carousel_list">
                        <?php
                        $rc_carousel_count=1;
                        while ( $loop->have_posts()) : $loop->the_post();
                        if($rc_carousel_count==1){
                            ?>
                            <li class="rc_carousel_item  current-slide">
                            <?php
                        } else{
                            ?>
                            <li class="rc_carousel_item">
                            <?php
                        }
                        ?>
                                <div class="rc_carousel_item_inner">
                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                                <p><?php the_title(); ?></p>
                                </div>

                            </li>
                        <?php

                        ++$rc_carousel_count;
                        endwhile;
                        ?>
                    </ul>
                </div>
                <button class="rc_carousel_button rc_carousel_button--next"></button>
            </div>
        </div>

    <?php
    }
    wp_reset_postdata();

    wp_enqueue_script('carousel-js');

    return ob_get_clean();
}
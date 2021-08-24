<?php

add_shortcode( 'team', 'team_render' );

function team_render($atts) {

	// Attributes
	$attributes = shortcode_atts(
		array(
            'type'=>''
		),
		$atts);


    $args = array(
        'post_type' => 'team',
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
        <div id="team">
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
                                    <div>
                                        <h6><strong><?php the_title(); ?></strong></h6>
                                        <?php $speciality = get_post_meta( get_the_ID(), 'titles', true );?>
                                        <p><?php echo $speciality  ?></p>
                                    </div>
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
            <?php

            if ($attributes['type']=='details'){

            ?>
                <div id="team_details" class="team_details_wrap">
                    <ul class="team_details_list">
                        <?php
                        $team_details_count=1;
                        while ( $loop->have_posts()) : $loop->the_post();
                        if($team_details_count==1){
                        ?>
                        <li class="team_details_item current-slide">
                        <?php
                        } else{
                        ?>
                        <li class="team_details_item">
                        <?php
                        }
                        ?>
                            <div class="team_details_item_inner">
                                <?php
                                $speciality = get_post_meta( get_the_ID(), 'titles', true );
                                ?>
                                <div class="team_details_item_header">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                    <div class="team_details_item_header_text">
                                        <h3><strong><?php the_title(); ?></strong></h3>
                                        <h5><?php echo $speciality ?></h5>
                                    </div>
                                </div>
                                <?php the_content();?>
                            </div>
                        </li>
                        <?php
                        ++$team_details_count;
                        endwhile;
                        ?>
                    </ul>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
    wp_reset_postdata();
    wp_enqueue_script('carousel-js');
    return ob_get_clean();
}
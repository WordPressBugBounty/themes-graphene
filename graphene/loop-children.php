<?php
/**
 * This file lists the child pages of the page currently being displayed,
 * if it has any.
*/
global $post, $graphene_settings;

if ( $graphene_settings['child_page_listing'] == 'show_always' ||
     ( $graphene_settings['child_page_listing'] == 'show_if_parent_empty' && $post->post_content == '' )) :

	/* 	Don't list the child pages if the global $post variable is empty, which usually
		indicates it's not the standard WordPress pages */
    if ( ! $post || ( function_exists( 'is_bbpress' ) && is_bbpress() ) )
		return;

    /* Display only for 'page' post type */
    if ( get_post_type( $post->ID ) != 'page' ) return;

    /* WooCommerce archive pages identify itself as page post type. Do further check and skip. */
    if ( function_exists( 'is_woocommerce' ) ) {
        if ( is_woocommerce() ) return;
    }
    
    /* Get the child pages */
    $args = array(
        'post_parent' 		=> $post->ID,
        'orderby' 			=> 'menu_order title',
		'order' 			=> 'ASC',
        'post_type' 		=> 'page',
		'posts_per_page' 	=> -1
    );
    $pages = new WP_Query( apply_filters('graphene_child_pages_args', $args ) );

    if ( $pages->have_posts() ) :
    ?>
    <div class="child-pages-wrap">
        <?php while ( $pages->have_posts() ) : $pages->the_post(); ?>
        <div class="post child-page page" id="page-<?php the_ID(); ?>">
            <div class="entry">
                    <div class="entry-content clearfix">
                    <?php /* The post thumbnail */
                        if ( has_post_thumbnail( get_the_ID() ) ) {
                            echo '<div class="excerpt-thumb"><a href="' . get_permalink( get_the_ID() ) . '">';
                            echo get_the_post_thumbnail( get_the_ID(), apply_filters( 'graphene_excerpt_thumbnail_size', 'medium' ) );
                            echo '</a></div>';
                        } else {
                            echo graphene_get_post_image( get_the_ID(), apply_filters( 'graphene_excerpt_thumbnail_size', 'medium' ), 'excerpt' );	
                        }
                    ?>

                    <?php /* The title */ ?>
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', 'graphene' ), get_the_title() ); ?>"><?php if ( get_the_title() == '' ) { _e( '(No title)','graphene' ); } else { the_title(); } ?></a>
                    </h2>

                    <?php /* The excerpt */ 
	                    the_excerpt();
						do_action( 'graphene_child_page_content' );
                    ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
<?php 
        endif; wp_reset_postdata(); 
    endif;
?>

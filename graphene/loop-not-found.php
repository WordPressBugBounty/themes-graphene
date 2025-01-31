<div <?php graphene_grid( 'post page', 12 ); ?>>
	<div class="entry clearfix">
        <h2 class="post-title entry-title"><?php _e('Not found','graphene'); ?></h2>
        <div class="entry-content">
            <p>
            <?php 
                if ( ! is_search() )
                    _e( "Sorry, but you are looking for something that isn't here. Would you like to try a search?", "graphene" ); 
                else
                    _e( "Sorry, but no results were found for that keyword. Would you like to try an alternative keyword search?", "graphene" ); 
            ?>
                
            </p>
            <?php get_search_form(); ?>
        </div>
    </div>
</div>

<?php do_action('graphene_not_found'); ?>
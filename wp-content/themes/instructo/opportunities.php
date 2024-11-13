<?php
/* Template Name: Opportunities List */
get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <h1>Learning for All | Join our Community!</h1>
        <div class="homepage-tile">
            <h2 class="h2home">Let's collaborate to develop people</h2>
            <div style="height: 10px; display: block; clear: both;"></div>
            <a href="#" style="cursor: not-allowed;" class="button">Sign up</a>
        </div>

        <?php
        // Define the WP_Query to get all 'pathway' post types
        $args = array(
            'post_type'      => 'opportunities',  // Custom post type
            'posts_per_page' => -1,         // Get all posts
            'post_status'    => 'publish'   // Only published posts
        );

        // Run the query
        $query = new WP_Query( $args );

        // Check if there are any posts
        if ( $query->have_posts() ) :
            // Loop through the posts
            while ( $query->have_posts() ) : $query->the_post();
                // Get the post title, permalink, and thumbnail URL
                $post_title = get_the_title();
                $post_permalink = get_permalink();
                $post_thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); // Get the full size thumbnail

                // If there's no thumbnail, you can use a default image
                if ( !$post_thumbnail_url ) {
                    $post_thumbnail_url = 'path/to/default-image.jpg'; // Replace with your default image path
                }
                ?>
                <div class="homepage-tile homepage-thirds">
                    <img src="<?php echo esc_url( $post_thumbnail_url ); ?>" width="400" alt="<?php echo esc_attr( $post_title ); ?>">
                    <h2 class="h2home"><?php echo esc_html( $post_title ); ?></h2>
                    <div style="height: 10px; display: block; clear: both;"></div>
                    <a href="<?php echo esc_url( $post_permalink ); ?>" class="button">Find out more</a>
                </div>
                <?php
            endwhile;
            // Reset post data after the loop
            wp_reset_postdata();
        else :
            echo 'No pathways found.';
        endif;
        ?>

    </div>

    <?php get_sidebar(); ?>

</main>


<?php // get_sidebar(); ?> 
<?php //get_footer(); ?> 
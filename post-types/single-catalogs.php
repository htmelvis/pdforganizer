<?php
 /*Template Name: Single Catalog
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    <?php
     global $post;
    ?>
    <?php 
        if(have_posts()) : while (have_posts()) : the_post();
    ?>
        <article id="post-<?php the_ID(); ?>">
            <header class="entry-header">
                <p>Woops</p>
                <!-- Display featured image in right-aligned floating div -->
                <a href="<?php echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true));  ?>" class="embedded">
                <div>
                    <?php //echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true)); ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
 
                <!-- Display Title and Author Name -->
                <h3><?php the_title(); ?></h3>
                </a>
 
            </header>
 
            <!-- Display movie review contents -->
            <div class="entry-content"> <?php echo esc_html( get_post_meta( get_the_ID(), 'meta_desc', true ) ); ?></div>
        </article>
 
    <?php endwhile; 
            endif;
    ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
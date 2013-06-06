<?php
 /*Template Name: Single Catalog
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'catalogs', );
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <!-- Display featured image in right-aligned floating div -->
                <a href="<?php echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true)); ?>">
                <div>
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
 
                <!-- Display Title and Author Name -->
                <h3><?php the_title(); ?></h3>
                </a>
 
            </header>
 
            <!-- Display movie review contents -->
            <div class="entry-content"> <?php echo esc_html( get_post_meta( get_the_ID(), 'meta_desc', true ) ); ?></div>
        </article>
 
    <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
<?php
 /*Template Name: Single Catalog
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" class="main-content-single-catalog" role="main">
    <?php
     global $post;
    ?>
    <?php 
        if(have_posts()) : while (have_posts()) : the_post();
    ?>
        <article id="post-<?php the_ID(); ?>">
            <header class="entry-header">
                 <div>
                    <?php //echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true)); ?>
                    <?php the_post_thumbnail('thumbnail'); ?>
                    <div class="side-catalog-info">
                    <h3><?php the_title(); ?></h3>
                    <div class="cat-desc"> <?php echo esc_html( get_post_meta( get_the_ID(), 'meta_desc', true ) ); ?>
                    </div>
                </div>
 
                <!-- Display Title and Author Name -->
                
                <!-- Display featured image in right-aligned floating div -->
                <!-- <a href="" class="embedded"> -->
                    
               
                </a>
 
            </header>
 
            <!-- Display movie review contents -->

                <object data="<?php echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true));  ?>" type="application/pdf" width="100%" height="700">
                        <p>It appears you dont have a PDF plugin for this browser. Click here to Download the file directly: 
                            <a href="<?php echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true));  ?>" class="embedded">
                                <?php the_title(); ?>
                            </a>
                    </object>

            </div>
        </article>
 
    <?php endwhile; 
            endif;
    ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
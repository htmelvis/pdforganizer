<?php
 /*Template Name: Taxonomy Page Catalogs
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" class="full-catalog-categories" role="main">

        <?php 
            
            $taxonomy = 'catalog-categories';
            // $currTax = $_SERVER['REQUEST_URI'];
            $currTax = get_queried_object();
            //$slug = basename($currTax);
            $slug = $currTax->slug;
            

            if($currTax->parent == 0){

                $tax_term_curr = get_term_by('slug', $slug, $taxonomy );

                $tax_terms = get_terms($taxonomy, array(
                    'parent' =>  $tax_term_curr->term_id,
                    'hide_empty' => false
                ));
                
                echo "<ul class=\"catalog-listings\">";

                foreach($tax_terms as $tax_term){
            
                    $t_ID = $tax_term->term_id;
                    $term_data = get_option("taxonomy_$t_ID");

                    echo '<li class="cat-section">';
                    echo '<a href="'. esc_attr(get_term_link($tax_term, $taxonomy)) .'" title="'.$tax_term->name. '">';
                    if(isset($term_data[custom_term_meta])){
                      echo '<img src="'. $term_data[custom_term_meta].'" width="200" height="259" />';
                    } else {
                        echo '<img src="'. plugin_dir_url(__FILE__) .'../assets/img/default.jpg" />';
                    } 
                    echo "<h3>" . $tax_term->name . "</h3>";
                    echo '</a></li>'; 
                }
                echo "</ul>";
            } else { 
                //Need WP Loop to output the Catalogs from current Category
           
                $mypost = array( 
                    'post_type' => 'catalogs',
                    'catalog-categories' => $slug, 
                    'posts_per_page'=>9,
                    'paged'=> $paged );
                $loop = new WP_Query( $mypost );
            
                 while ( $loop->have_posts() ) : $loop->the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class();?>>
                    <header class="entry-header">
                        <!-- Display featured image in right-aligned floating div -->
                        <a href="<?php the_permalink(); ?>" class="embed">
                        <div class="cat-thumb">
                            <?php 

                            if(has_post_thumbnail()){
                                the_post_thumbnail('catalog-cover'); 
                            } else  {
                                echo '<img src="'. plugin_dir_url(__FILE__) .'../assets/img/default.jpg" />'; 
                            }

                            ?>
                        </div>
         
                        <!-- Display Title and Author Name -->
                        <h3><?php the_title(); ?></h3>
                        </a>
         
                    </header>
         
                    <!-- Display movie review contents -->
                    <div class="entry-desc">
                    <h4>Catalog Description: </h4>
                    <p>
                     <?php echo esc_html( get_post_meta( get_the_ID(), 'meta_desc', true ) ); ?>
                    </p>
                 </div>
                </article>
                
     <?php endwhile;
            }
        ?>
        <div class="navigation">
            <div class="alignleft"><?php previous_posts_link('&laquo; Previous') ?></div>
            <div class="alignright"><?php next_posts_link('More &raquo;') ?></div>
        </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
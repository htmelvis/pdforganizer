<?php
 /*Template Name: Taxonomy Page Catalogs
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">

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
                
                echo "<ul>";

                foreach($tax_terms as $tax_term){
            
                    $t_ID = $tax_term->term_id;
                    $term_data = get_option("taxonomy_$t_ID");

                    echo '<li>';
                    echo '<a href="'. esc_attr(get_term_link($tax_term, $taxonomy)) .'" title="'.$tax_term->name. '">';
                    if(isset($term_data[custom_term_meta])){
                      echo '<img src="'. $term_data[custom_term_meta].'"/>';
                    } // else create default catalog pic 
                    echo $tax_term->name;
                    echo '</a></li>'; 
                }
                echo "</ul>";
            } else { 
                //Need WP Loop to output the Catalogs from current Category
           
                $mypost = array( 
                    'post_type' => 'catalogs',
                    'catalog-categories' => $slug );
                $loop = new WP_Query( $mypost );
            
                 while ( $loop->have_posts() ) : $loop->the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class();?>>
                    <header class="entry-header">
                        <!-- Display featured image in right-aligned floating div -->
                        <a href="<?php echo esc_html(get_post_meta(get_the_ID(), 'upload_pdf', true)); ?>" class="embed thickbox">
                        <div style="float: right; margin: 10px">
                            <?php the_post_thumbnail( array( 250, 300 ) ); ?>
                        </div>
         
                        <!-- Display Title and Author Name -->
                        <strong>Title: </strong>Fuck: <?php the_title(); ?><br />
                        </a>
         
                    </header>
         
                    <!-- Display movie review contents -->
                    <div class="entry-content"> <?php echo esc_html( get_post_meta( get_the_ID(), 'meta_desc', true ) ); ?></div>
                </article>
         
     <?php endwhile;
            }
        ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
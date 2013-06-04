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
                    echo '<li><a href="'. esc_attr(get_term_link($tax_term, $taxonomy)) .'" title="' . sprintf( __('View Catalogs In %s'), $tax_term->name) . '" ' . '>' . $tax_term->name . '</a></li>'; 
                }
                echo "</ul>";
            } else { 
                echo "Holy Shit"; 
            }
        ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
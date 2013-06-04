<?php
 /*Template Name: Archive Catalogs
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
        <?php 
            $taxonomy = 'catalog-categories';
            $tax_terms = get_terms($taxonomy, array(
                'parent' => 0
            ));

            echo "<ul>";
            foreach($tax_terms as $tax_term){
                echo '<li><a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) .
                '" title="' . sprintf( __('View Posts In %s'), $tax_term->name) . '" ' . '>' . $tax_term->name . '</a></li>'; 
            }
            echo "</ul>"
        ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
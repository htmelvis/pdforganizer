<?php
 /*Template Name: Archive Catalogs
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
        <?php 
            $taxonomy = 'catalog-categories';
            $tax_terms = get_terms($taxonomy, array(
                'parent' => 0,
                'hide_empty'=> false
            ));

            echo "<ul>";
            foreach($tax_terms as $tax_term){
                $t_ID = $tax_term->term_id;
                $term_data = get_option("taxonomy_$t_ID");

                echo '<li class="archive-cats"><a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) .
                '" title="' . sprintf( __('View Posts In %s'), $tax_term->name) . '" ' . '>';
                if(isset($term_data[custom_term_meta])){
                      echo '<img src="'. $term_data[custom_term_meta].'" width="200" height="250" />';
                } else {
                    echo '<img src="'. plugin_dir_url(__FILE__) .'../assets/img/default.jpg" />';
                } 
                echo '<h3>' . $tax_term->name . '</h3></a></li>'; 
            }
            echo "</ul>"
        ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
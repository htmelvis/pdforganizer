<?php
 /*Template Name: Catalog Manufacturers Template
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
        <?php $terms = get_terms('Catalog Info');

        $count = count($terms);
        if($count > 0){
            echo "<ul>";
            foreach($terms as $term){
                echo "<li>" . $term->name . "</li>";
            }
            echo "</ul>";
        }


        ?>
    </div>
</div>

<?php get_footer(); ?>
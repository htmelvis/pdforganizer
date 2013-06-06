<?php 

if(!class_exists('Catalogs'))
{
	/**
	Provides Meta Fields
	**/

	class Catalogs
	{
		const POST_TYPE = "catalogs";
		private $_meta = array(
			'meta_desc',
			'upload_pdf'
		);	
		public function __construct()
		{
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));

			
		}
		public function init()
		{
			$this->create_post_type();
			add_action('save_post', array(&$this, 'save_catalog'));
			
		}
		public function create_post_type()
		{
			register_post_type(self::POST_TYPE,
				array(
					'labels' => array(
						'name' => __(sprintf('%s', ucwords(str_replace("_", " ", self::POST_TYPE)))),
						'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE))),
						'all_items' => 'All Catalogs',
						'add_new' => 'Add Catalog',
						'add_new_item' => 'Add New Catalog',
						'edit_item' => 'Edit Catalog Listing',
						'new_item' => 'New Catalog',
						'view_item' => 'View Catalog',
						'search_items' => 'Search Catalogs',
						'not_found' => 'No Catalog Found',
						'not_found_in_trash' => 'No Catalogs in Trash'

						),
					'public'=> true,
					'has_archive'=>true,
					'description' => __("This post type is for catalogs"),
					'supports' => array('title', 'thumbnail'),


				)
			);
			register_taxonomy('catalog-categories', 'catalogs', array(
				'hierarchical' => true, 
				'label' => 'Catalog Categories',
				'show_ui' => true, 
				'query_var' => true, 
				'singular_label'=> 'Catalog Category',
				'show_tagcloud' => false,
				'rewrite' => array('hierarchical'=> true)
			));
			// register_taxonomy( 'Catalog Manufacturers', 'catalogs', array(
			// 	'hierarchical' => true, 
			// 	'label' => 'Catalog Manufacturers',
			// 	'show_ui' => true, 
			// 	'query_var' => true, 
			// 	'singular_label'=> 'Catalog Manufacturer',
			// 	'show_tagcloud' => false
			// ) );
		}
		public function save_catalog($post_id)
		{
			//verify if it is an autosave first
			//If it is our form has not been submitted so dont do anything
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			{
				return;
			}
			if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
			{
				foreach($this->_meta as $field_name)
				{
					//update the post meta
					update_post_meta($post_id, $field_name, $_POST[$field_name]);

				}
			} else {

				return;
			}
		} // End save post function

		public function admin_init()
		{
			add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
		}//end admin init

		public function add_meta_boxes()
		{
			add_meta_box(
				sprintf('pdf_organizer_%s_section', self::POST_TYPE),
				sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
				array(&$this, 'add_inner_meta_boxes'),
				self::POST_TYPE
			);
		}//end of meta boxes funciton
		public function add_inner_meta_boxes($post)
		{
			 $description = esc_html( get_post_meta($post->ID, 'meta_desc', true ));
			 $filename = esc_html( get_post_meta($post->ID, 'upload_pdf', true ));

			include(sprintf("%s/../templates/%s-inner-metabox.php", dirname(__FILE__), self::POST_TYPE));

		}
		
	} // END OF CATALOGS CLASS
	add_action('admin_enqueue_scripts', 'my_admin_scripts');

	function my_admin_scripts() {
		//if (isset($_GET['post_type']) && $_GET['post_type'] == 'catalogs') {
			wp_enqueue_media();
			//Get the plugin directory with plugin name
			wp_register_script('catalog-upload', plugin_dir_url(__FILE__) . '../assets/js/admin-script.js', array('jquery', 'tax-scripts'));
			wp_enqueue_script('catalog-upload');
		//}
	}		

	add_filter('template_include', 'default_template_function');
	function default_template_function( $template_path ){

		if(get_post_type() == 'catalogs'){
			if(is_single()){
				if($theme_file = locate_template(array('single-catalogs.php'))){
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . 'single-catalogs.php';
				}
			}
			if(is_archive()){
				if($theme_file = locate_template(array('archive-catalogs.php'))){
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . 'archive-catalogs.php';
				}
			}
			if(is_tax()){
				if($theme_file = locate_template(array('taxonomy-catalogs.php'))){
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . 'taxonomy-catalogs.php';
				}
			}
		}
		return $template_path;

	}

	function taxonomy_add_new_meta_field(){
?>
	<div class="form-field">
		<label for="term_meta[custom_term_meta]">Add Category Image</label>
		<input type="submit"  id="upload_image_button_tax" value="Upload image" name="upload_image_button_tax" />
		<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" class="term_tax_input" value="">
		<p class="description">Add an Image to your Category for Show on the Archive Pages</p>
	</div>

<?php
	}
	add_action('catalog-categories_add_form_fields', 'taxonomy_add_new_meta_field');

	function taxonomy_edit_meta_field($term){
		$t_id = $term->term_id;
		$term_meta = get_option("taxonomy_$t_id");
?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[custom_term_meta]">Upload Category Image</label></th>
		<td>
			<input type="submit" id="upload_image_button_tax" value="Upload image" name="upload_image_button_tax" style="width: 180px; padding: 5px; border-radius: 10px; margin-bottom: 10px; border: 1px solid #ddd;"/>
			<input type="text" class="term_tax_input" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>">
			<p class="description">Image Upload Description</p>
		</td>
	</tr>
<?php
	
	}
	add_action( 'catalog-categories_edit_form_fields', 'taxonomy_edit_meta_field', 10, 2 );	

	function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];

					
			}
		}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	}  
	add_action( 'edited_catalog-categories', 'save_taxonomy_custom_meta', 10, 2 );  
	add_action( 'create_catalog-categories', 'save_taxonomy_custom_meta', 10, 2 );

	function load_tax_page_scripts(){
		//if(is_tax()){
			wp_register_style('tax-css', plugin_dir_url(__FILE__) . '../assets/css/pdforganizer-style.css');
			wp_enqueue_style('tax-css');
			wp_register_script('tax-scripts', plugin_dir_url(__FILE__) . '../assets/js/jquery.gdocsviewer.min.js', array('jquery'));
			wp_enqueue_script('tax-scripts');
			wp_register_script('tax-jquery', plugin_dir_url(__FILE__) . '../assets/js/script.js', array('jquery'));
			wp_enqueue_script('tax-jquery');
		//}	
	}
	add_action('init', 'load_tax_page_scripts');

	class filterWidget extends WP_Widget{
		function filterWidget(){
			parent::WP_Widget(false, $name = "Catalog Filters");
		}
		function widget($args, $instance){
			//enqueue scripts needed
			extract($args);
			$title = apply_filters( 'widget_title', $instance['title'] );
	
			echo $before_widget;
			
		?>
		<div class="my_textbox">
			<?php 
				 if($title){
					echo $before_title . $title . $after_title;
				}	
	            $taxonomy = 'catalog-categories';
	            $tax_terms = get_terms($taxonomy, array(
	                'parent' => 0
	            ));

	            echo "<ul>";
	            foreach($tax_terms as $tax_term){
	                $t_ID = $tax_term->term_id;
	                $term_data = get_option("taxonomy_$t_ID");

	                echo '<li><a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) .
	                '" title="' . sprintf( __('View Posts In %s'), $tax_term->name) . '" ' . '>';
	      
	                echo '<h5>' . $tax_term->name . '</h5></a></li>'; 
	            }
	            echo "</ul>"
        	?>

		</div>
	<?php
		echo $after_widget;
				//over methods
	}//end of function
		function update($new_instance, $old_instance){
			return $new_instance;
		}
		function form($instance){
			$title = esc_attr($instance['title']);
	?>
		<p>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
	<?php
		}
	}
	add_action('widgets_init', 'filterWidgetInit');
	function filterWidgetInit(){
		register_widget( 'filterWidget' );

	}
	add_image_size('catalog-cover', 200, 259, true);
}
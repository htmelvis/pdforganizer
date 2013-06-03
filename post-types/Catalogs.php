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
			wp_register_script('catalog-upload', plugin_dir_url(__FILE__) . '../assets/js/script.js', array('jquery'));
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
}
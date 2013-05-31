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
			'meta_a',
			'meta_b',
			'meta_c',
		);	
		public function __contruct()
		{
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));

		}
		public function create_post_type()
		{
			register_post_type(self::POST_TYPE,
				array(
					'labels' => array(
						'name' => __(sprintf('%ss', ucwords(str_replace("_", " ", self::POST_TYPE)))),
						'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))
						),
					'public'=> true,
					'has_archive'=>true,
					'description' => __("This post type is for catalogs"),
					'supports' => 'title', 'editor', 'thumbnail',

				),
			);
		}
		public function save_post($post_id)
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
			include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));
			
		}
	}
}
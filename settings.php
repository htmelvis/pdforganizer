<?php
if(!class_exists('Catalogs_Settings'))
{
	class Catalogs_Settings
	{
		public function __construct()
		{
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('admin_menu', array(&$this, 'add_menu'));
		}
		public function admin_init()
			{
				//setup the settings for this plugin
				register_setting('pdf_organizer-group', 'setting_a');
				register_setting('pdf_organizer-group', 'setting_b');
				//add more init tasks
				add_settings_section( 'pdf_organizer-group', 'PDF Organizer Settings', array(&$this, 'settings_section_pdf_organizer'), 'pdf_organizer' );
				add_settings_field(
                'pdf_organizer-setting_a', 
                'Setting A', 
                array(&$this, 'settings_field_input_text'), 
                'pdf_organizer', 
                'pdf_organizer-section',
                array(
                    'field' => 'setting_a'
                )
            );
            add_settings_field(
                'pdf_organizer-setting_b', 
                'Setting B', 
                array(&$this, 'settings_field_input_text'), 
                'pdf_organizer', 
                'pdf_organizer-section',
                array(
                    'field' => 'setting_b'
                )
            );
			}
			public function settings_section_pdf_organizer()
	        {
	            // Think of this as help text for the section.
	            echo 'These settings do things for the PDF Organizer.';
	        }
	        
	        /**
	         * This function provides text inputs for settings fields
	         */
	        public function settings_field_input_text($args)
	        {
	            // Get the field name from the $args array
	            $field = $args['field'];
	            // Get the value of this setting
	            $value = get_option($field);
	            // echo a proper input type="text"
	            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
	        } // END public function settings_field_input_text($args)
	        
			public function add_menu()
			{
				add_options_page(
        	    'PDF Organizer Settings', 
        	    'PDF Organizer', 
        	    'manage_options', 
        	    'pdf_organizer', 
        	    array(&$this, 'plugin_settings_page')
        	);
			}
			public function plugin_settings_page()
			{
				if(!current_user_can( 'manage_options' ))
				{
					wp_die(__('You do not have current permissions'));
				}
				include(sprintf("%s/templates/settings.php", dirname(__FILE__)));

			}
	}
}
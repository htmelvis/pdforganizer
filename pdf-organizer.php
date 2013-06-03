<?php 
/*
	Plugin Name: PDF Organizer
	Plugin URI: http://myriadcore.com
	Description: PDF Organizer Plugin for Organizing Media Attachments
	Version: 1.0
	Author: Edward Wieczorek
	Author URI: http://myriadcore.com
	License: GPL2

*/

/*
 Copyright 2013  Edward Wieczorek  (email :ed@myriadcore.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('PDF_Organizer'))
{
	class PDF_Organizer
	{
		/** Construct the Plugin Object **/
		public function __construct()
		{
			//register actions
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$Catalogs_Settings = new Catalogs_Settings(); 

			require_once(sprintf("%s/post-types/Catalogs.php", dirname(__FILE__)));
			$Catalogs = new Catalogs(); 
			//require_once(sprintf("%s/post-types/Catalogs.php", dirname(__FILE__)));
			//$Catalog = new Catalogs();

		}//end public constuctor
		
		/**Activate the Plugin **/
		public static function activate()
		{
			
		}//End Activation
		/**Deactivation of Plugin**/
		public static function deactivate()
		{
			//Do Nothing
		}//End Deactivation
		
	}	
	if(class_exists('PDF_Organizer'))
		{
			register_activation_hook( __FILE__, array('PDF_Organizer', 'activate'));
			register_deactivation_hook( __FILE__, array('PDF_Organizer', 'deactivate'));

			$pdf_organizer = new PDF_Organizer();
			if(isset($pdf_organizer))
			{
				function plugin_settings_link($links)
				{
					$settings_link = '<a href="options-general.php?page=pdf_organizer">Settings</a>';
					array_unshift($links, $settings_link);
					return $links;
				}
				$plugin = plugin_basename(__FILE__);
				add_filter("plugin_action_links_$plugin", 'plugin_settings_link');

			}
		}
}
?>
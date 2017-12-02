<?php 
/*
* Plugin Name: Messenger Customer Chat
* Plugin URI: https://ninjateam.org/facebook-messenger-wordpress/
* Description: Display Messenger chatbox on your website, help your customers easy to contact with your business
* Version: 1.0
* Author: Ninja Team
* Author URI: https://ninjateam.org
* License: License GNU General Public License version 2 or later;
* Copyright 2017  Ninja_Team
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!class_exists('NJT_CUSTOMER_CHAT_PLUGIN_SETUP')):
	/**
	* 
	*/
class NJT_CUSTOMER_CHAT_PLUGIN_SETUP
{
	function __construct()
	{		
			$this->define_constants();
			add_action('init',array(&$this,'check_plugin_defaults'));
			register_activation_hook(__FILE__, array($this, 'njt_add_option_plugin_customer_chat'));
			
			$this->_includes_file();
			if(!function_exists('is_plugin_active'))
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	public function define_constants(){
		if(!defined('NJT_CUSTOMER_CHAT')){
				define('NJT_CUSTOMER_CHAT', 'njt-customer-chat-plugin');
		}
		if ( ! defined( 'NJT_CUSTOMER_CHAT_VERSION' ) ){
				define( 'NJT_CUSTOMER_CHAT_VERSION', '1.0.0' );
		}
		if ( ! defined( 'NJT_CUSTOMER_CHAT_FOLDER' ) ) {
				define( 'NJT_CUSTOMER_CHAT_FOLDER', plugin_basename( __FILE__ ) ); 
		}
		if ( ! defined( 'NJT_CUSTOMER_CHAT_DIR' ) ) {
				define( 'NJT_CUSTOMER_CHAT_DIR', plugin_dir_path( __FILE__ )  );
		}
		if ( ! defined( 'NJT_CUSTOMER_CHAT_FILE' ) ) {
				define( 'NJT_CUSTOMER_CHAT_FILE', __FILE__ );
		}
		if ( ! defined( 'NJT_CUSTOMER_CHAT_INC' ) ) {
				define( 'NJT_CUSTOMER_CHAT_INC', NJT_CUSTOMER_CHAT_DIR.'includes'.'/' );
		}
		if ( ! defined( 'NJT_CUSTOMER_CHAT_URL' ) ) {
				define( 'NJT_CUSTOMER_CHAT_URL', plugin_dir_url( __FILE__ ) ); 
		}
		// languages
		load_plugin_textdomain("njt-customer-chat-plugin", "", NJT_CUSTOMER_CHAT_URL.'languages');
	}
	public function check_plugin_defaults(){
	
	}

	
	public function njt_add_option_plugin_customer_chat(){


		if(!get_option('njt_customer_chat_list_page')){
			update_option('njt_customer_chat_list_page',"1526684747623433");
		}

		if(!get_option('njt_customer_chat_enable')){
			update_option('njt_customer_chat_enable',"on");
		}

		if(!get_option('njt_customer_chat_languages')){
			update_option('njt_customer_chat_languages',"en_US");
		}


	}
	
	
		
	public function _includes_file(){
		require(plugin_dir_path(__FILE__).'vendor/autoload.php');
		require(plugin_dir_path(__FILE__).'includes/facebook-api/api.php');
		// call calback url (subscriber webhook)
		require(plugin_dir_path(__FILE__).'includes/facebook-api/rule.php');
		// https://preview.ninjateam.org/abandoned-cart-fb/callback?callback=webhook (callback url)
		
		// settings
		require NJT_CUSTOMER_CHAT_INC.'settings.php';
		require NJT_CUSTOMER_CHAT_INC.'functions.php';
		
		require NJT_CUSTOMER_CHAT_INC.'plugins.php';
		require NJT_CUSTOMER_CHAT_INC.'ajax_cart.php';

	}
}

endif;
new NJT_CUSTOMER_CHAT_PLUGIN_SETUP;
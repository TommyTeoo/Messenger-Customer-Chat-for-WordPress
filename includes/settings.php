<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;
if(!class_exists('NJT_CUSTOMER_CHAT_ADMIN_SETTINGS')){
  class NJT_CUSTOMER_CHAT_ADMIN_SETTINGS{
    public function __construct() {
      add_action('admin_menu', array($this, 'admin_menu_settings'));
      add_action('admin_enqueue_scripts', array( $this, 'admin_styles' ) );
      add_action('admin_init',array($this,'njt_api_customer_chat_settings'));
      add_action( 'current_screen',array( $this,'njt_current_screen' ));
    } 
    public function njt_api_customer_chat_settings(){
      if (!session_id()) {
          session_start();
      }
      ob_start(); // fixed : Warning: Cannot modify header information - headers already sent by (output started at (2)
      register_setting( 'njt_customer_chat','njt_customer_chat_app_id');
      register_setting( 'njt_customer_chat','njt_customer_chat_app_serect');
      register_setting('njt_customer_chat','njt_customer_chat_list_page');
      register_setting('njt_customer_chat','njt_customer_chat_enable');
      register_setting('njt_customer_chat','njt_customer_chat_languages');
      
    }
    public function admin_menu_settings() {
      $user_token=get_option('njt_customer_chat_app_token');
      add_menu_page(__('Customer Chat',NJT_CUSTOMER_CHAT), __('Messenger Chat', NJT_CUSTOMER_CHAT),'manage_options', 'njt-customer-chat-settings', array($this, 'call_fb_api_setup'), NJT_CUSTOMER_CHAT_URL.'assets/images/icon.svg','56');
      add_submenu_page( 'njt-customer-chat-settings', 'General Settings', 'General Settings', 'manage_options', 'njt-customer-chat-settings', array($this,'call_fb_api_setup') );
      /*
      if($user_token && !empty($user_token)){
      
      }
      */

    }
    public function admin_styles(){
      wp_enqueue_style('njt_customer_chat_admin_style',NJT_CUSTOMER_CHAT_URL.'assets/css/admin.css');
      
    }
     
    public function call_fb_api_setup(){
        require_once(NJT_CUSTOMER_CHAT_INC.'setup.php');
    }

  

    public function njt_current_screen(){
      
      $currentScreen = get_current_screen();
      /*
        if($currentScreen->id=="abandoned-cart_page_njt-abandoned-cart-setup"){
            add_action('admin_footer',array($this,'njt_admin_footer_js'));
        }
      */
    }
      
      
    /**/
    /*
    public function njt_admin_footer_js(){
        ?>
          <style type="text/css">
        
          .notice.notice-warning{display: none;}
        </style>
        <script src="<?php echo NJT_CUSTOMER_CHAT_URL.'assets/js/dd.js' ?>" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo NJT_CUSTOMER_CHAT_URL.'assets/css/dd.css' ?>" />
        <script src="<?php echo NJT_CUSTOMER_CHAT_URL.'assets/js/njt_select_image.js' ?>" type="text/javascript"></script>
        <?php
      }
    */
      
  }
}
new NJT_CUSTOMER_CHAT_ADMIN_SETTINGS();

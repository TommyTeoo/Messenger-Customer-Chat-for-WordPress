<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;
if(!class_exists('NJT_CUSTOMER_CHAT_PLUGINS')){
	class NJT_CUSTOMER_CHAT_PLUGINS{
		public function __construct() {
			add_action('init', array($this,'njt_advoid_do_output_buffer')); //(1)
			add_action('wp_head',array($this,'njt_customer_chat_wp_head'));
			add_action('wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
			
		}
		
		public function njt_advoid_do_output_buffer(){
			ob_start(); // fixed : Warning: Cannot modify header information - headers already 

		}
		
		public function njt_customer_chat_wp_head(){
			?>	
			
			<script type="text/javascript">
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";	
			</script>
			<?php 
				$enable_plugin=get_option('njt_customer_chat_enable');
				if(!empty($enable_plugin)){
			?>
				
				<script>      
					<?php $app_languages=get_option('njt_customer_chat_languages'); $app_page=get_option('njt_customer_chat_list_page');?>
						
						window.fbMessengerPlugins = window.fbMessengerPlugins || { 
							init: function () { 
								FB.init({ 
										appId:'983715691729450',
										autoLogAppEvents : true,
										xfbml : true,
										version: 'v2.11'});
								}, 
								callable: []      
						};

						window.fbAsyncInit = window.fbAsyncInit || function () { 
						    window.fbMessengerPlugins.callable.forEach(function (item) { item(); });        window.fbMessengerPlugins.init(); 
						};

						setTimeout(function () {  
							(function (d, s, id) {  
									var js, fjs = d.getElementsByTagName(s)[0]; 
									if (d.getElementById(id)) { return; } 
									js = d.createElement(s);
									js.id = id;
									js.src = "//connect.facebook.net/<?php echo $app_languages; ?>/sdk/xfbml.customerchat.js"; 
									fjs.parentNode.insertBefore(js, fjs);        
							}(document, 'script', 'facebook-jssdk')); }, 0);      
				</script> 
				<div class="fb-customerchat" page_id="<?php echo $app_page; ?>" ref=""> </div>

			<?php } ?>
				
			<?php
		} 
		public function frontend_styles(){
		
		}
		
	
	    /**/
	    
	}
}
new NJT_CUSTOMER_CHAT_PLUGINS();
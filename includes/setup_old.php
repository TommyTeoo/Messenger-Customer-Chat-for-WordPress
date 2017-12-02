<style type="text/css">
	/*#wpwrap{background: #fff;}*/
	.notice.notice-warning{display: none;}
</style>
<?php

$check=-1;
//if(get_option('njt_customer_chat_app_id') && get_option('njt_customer_chat_app_id')!="" && get_option('njt_customer_chat_app_serect') && get_option('njt_customer_chat_app_serect')!=""){
		
		$link_call_back=add_query_arg(array('page'=>'njt-customer-chat-settings'),admin_url('admin.php'));
		$fb_api = new NJT_CUSTOMER_CHAT_API();
		$link_login= $fb_api->GetLinkLogin($link_call_back,array('manage_pages','email','public_profile','pages_messaging'));
		if(isset($_GET['code'])){
			$token = $fb_api->get_Token();
			$user_token= $fb_api->extoken($token);
			if($user_token=="error"){
				$link_call_back=$link_call_back."&njt_abd_error=error";
				wp_redirect($link_call_back);
			}else{
				update_option('njt_customer_chat_app_token',$user_token);
				wp_redirect($link_call_back);
			}
			exit();
		}
		$user_token=get_option('njt_customer_chat_app_token');
		$check=$fb_api->check_token_live($user_token);
//	}
?>
<?php 
/*
	if(!get_option('njt_customer_chat_app_id') && !get_option('njt_customer_chat_app_serect')){
		echo '
				  <div class="error" style="margin-left:0px"> <!-- calss default wordpress-->
				    <p>' . sprintf(__('Please enter App ID and App Secret to use the app.', NJT_CUSTOMER_CHAT)) . '</p>
				  </div>';
	}
*/
	if(isset($_GET['njt_abd_error'])){
		echo '
				  <div class="error" style="margin-left:0px"> <!-- calss default wordpress-->
				    <p>' . sprintf(__('App secret does not match the application id of the app.', NJT_CUSTOMER_CHAT)) . '</p>
				  </div>';
	}
?>
<div class="wrap">
<h1 class="wp-heading-inline"> <?php _e("General Settings",NJT_CUSTOMER_CHAT);?></h1>
</div>
<?php if( isset($_GET['settings-updated']) ): ?>
<div style="margin-left: 0px;margin-top: 15px;" class="notice notice-success is-dismissible">
                            <p><?php _e('Save changed!',NJT_CUSTOMER_CHAT); ?></p>
</div>

<?php endif;?>
<form action="options.php" method="post">
<?php 
	settings_fields('njt_customer_chat');
	$app_id=get_option('njt_customer_chat_app_id');
	$app_serect=get_option('njt_customer_chat_app_serect');
	$app_page=get_option('njt_customer_chat_list_page');
	$enable_plugin=get_option('njt_customer_chat_enable');
	$app_languages=get_option('njt_customer_chat_languages');


    print_r($app_page);print_r($enable_plugin);print_r($app_languages);
 ?>

	<table class="form-table">
		<tbody>
		<!-- ID SECRECT
			<tr class="">
				<th scope="row">
					<label for="">App ID</label>
				</th>
				<td>
						<input type="text" class="regular-text" id="njt_customer_chat_app_id" name="njt_customer_chat_app_id" value="<?php echo empty($app_id) ? '' : $app_id; ?>" required>
						<p class="description">App ID and App Secret at <a href="https://developers.facebook.com" class="new-window" target="_blank">Facebook Developers</a> are needed for using the Facebook APIs. Please check our <a href="http://ninjateam.org/cartback-woocommerce-abandoned-cart-remarketing-facebook-messenger-tutorial/" class="new-window" target="_blank">the tutorial</a> or <a href="https://m.me/ninjateam.org" class="new-window" target="_blank">chat with our support</a> if you need any help</p>
				</td>
			</tr>
			<tr class="">
				<th scope="row">
					<label for="">App Secret</label>
				</th>
				<td>
					<input type="text" class="regular-text" id="njt_customer_chat_app_serect" name="njt_customer_chat_app_serect" value="<?php echo empty($app_serect) ? '' : $app_serect; ?>" required>
				</td>
			</tr>
		-->
	<?php // 	if(get_option('njt_customer_chat_app_id') && get_option('njt_customer_chat_app_id')!="" && get_option('njt_customer_chat_app_serect') && get_option('njt_customer_chat_app_serect')!=""): ?>
			<style type="text/css">
						.njt_abd_webhooks{
							background-color: none !important;
						    border: none !important;
						    box-shadow: none !important;
						    font-size:16px;
						}
			</style>
			<tr class="">
				<th scope="row">
					<label for="">Callback URL Webhooks</label>
				</th>
				<td>
					<?php $url_webhooks=home_url('/')."callback?callback_customer_chat=webhook"; 
						  $url_webhooks=str_replace ("http://","https://", $url_webhooks);
					?>
						<input style="width: 80%;" type="text" readonly="readonly" class="njt_abd_webhooks" onclick="select();" value="<?php echo $url_webhooks;?>">
				</td>
			</tr>
			<tr class="">
				<th scope="row">
					<label for="">Verify Token</label>
				</th>
				<td>
						<input style="width: 25em;" type="text" readonly="readonly" class="njt_abd_webhooks" onclick="select();" value="123456789">
				</td>
			</tr>
			<tr class="">
					<th scope="row">
						<label for="">Enable Plugin</label>
					</th>
					<td>
						<label class="njt-switch-button">
							<!-- checked=""-->
							<input <?php if($enable_plugin=="on") echo "checked='checked'"; ?>  name="njt_customer_chat_enable" class="njt-switch-button-input njt_customer_chat_enable" type="checkbox" />
							<span class="njt-switch-button-label" data-on="On" data-off="Off"></span> 
							<span class="njt-switch-button-handle"></span> 
						</label>
						<p class="description">Enable if you want to display plugin </p>
					</td>
			</tr>

			<tr class="">
					<th scope="row">
						<label for="">Languages</label>
					</th>
					<td>
					<?php 
							$language=njt_customer_chat_languages();
							
					?>
						<select name="njt_customer_chat_languages" id="" class="njt_customer_chat_languages">
	  							<?php foreach ($language as $key => $value) { ?>
	  								<option <?php if($app_languages==$key) echo "selected='selected'"; ?> value="<?php echo $key; ?>" ><?php echo $value; ?></option>
	  							<?php } ?>
  						</select>
						<p class="description">Select the language using the plugin</p>
					</td>
			</tr>
		<?php if($check==1) {

				$list_page=$fb_api->Get_List_Page($user_token);
	    ?>
			<tr class="">
					<th scope="row">
						<label for="">Select a page</label>
					</th>
					<td>
						<!-- njt_abandoned_cart_page  webmenu-->
	 					<select style="width: 99% !important;margin-top: 40px;" name="njt_customer_chat_languages" id="" class="njt_customer_chat_languages">
	
	 						<?php foreach ($list_page['accounts'] as $key => $list): $id=$list['id'];$page_name=$list['name']?>
		    						<option <?php if($app_page==$id) echo "selected='selected'"; ?> value="<?php echo $id; ?>" data-image="<?php echo $list['picture']['url'];?>" ><?php echo $page_name; ?></option>
							<?php endforeach; ?>   
  						</select>
						
					</td>
			</tr>
		<?php } ?>
		
			<tr class="">
				<?php if($check==0) :?>
					<th scope="row">
						<label for="">Login</label>
					</th>
					<td>
						<a class="button button-primary" href="<?php echo $link_login; ?>">Login Facebook</a>
					</td>
				<?php elseif($check==1): ?>
					<th scope="row">
						<label for="">Connect Facebook</label>
					</th>
					<td>
						<p class="description"></p>
						<p>Connected to <b><?php echo $fb_api->Me($user_token)['name']; ?></b> successfully! <a href="<?php echo $link_login;?>" id="njt-reconnet">Reconnect</a>
						</p>
						<p></p>
					</td>
				<?php endif; ?>
			</tr>
		<?php // endif; ?>
		</tbody>
	</table>
	<?php submit_button(); ?>
</form>

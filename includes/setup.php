<style type="text/css">
	/*#wpwrap{background: #fff;}*/
	.notice.notice-warning{display: none;}
</style>

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
	
	$app_page=get_option('njt_customer_chat_list_page');
	$enable_plugin=get_option('njt_customer_chat_enable');
	$app_languages=get_option('njt_customer_chat_languages');


   // print_r($app_page);print_r($enable_plugin);print_r($app_languages);
 ?>

	<table class="form-table">
	
	
			
			<tr class="">
					<th scope="row">
						<label for="">Enable Messenger Chatbox</label>
					</th>
					<td>
						<label class="njt-switch-button">
							<!-- checked=""-->
							<input <?php if($enable_plugin=="on") echo "checked='checked'"; ?>  name="njt_customer_chat_enable" class="njt-switch-button-input njt_customer_chat_enable" type="checkbox" />
							<span class="njt-switch-button-label" data-on="On" data-off="Off"></span> 
							<span class="njt-switch-button-handle"></span> 
						</label>
						<p class="description">Enable if you want to display Messenger Customer Chatbox on your website </p>
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
						<p class="description">Select the language using for Messenger Chatbox</p>
					</td>
			</tr>
		
			<tr class="">
					<th scope="row">
						<label for="">Step 1: Enter your Page ID</label>
					</th>
					<td>
						
						<input type="text" class="regular-text" id="njt_customer_chat_list_page" name="njt_customer_chat_list_page" value="<?php echo empty($app_page) ? '' : $app_page; ?>" required>
						<p class="description">You can find your Page ID from menu <strong>Settings > About</strong> from your fan page. <a href="http://take.ms/nobo5" target="_blank">See this screenshot</a></p>
					</td>
			</tr>

			<tr class="">
					<th scope="row">
						<label for="">Step 2: Add your domain in Whitelist</label>
					</th>
					<td>
						<p><a href="http://take.ms/DPB1C" target="_blank">How to do it?</a></p>
					</td>
			</tr>

			<tr class="">
					<th scope="row">
						<label for="">Need help? <p><a href="https://m.me/ninjateam.org" target="_blank">Chat with us</a></p></label>
					</th>
					<td>
						
					</td>
			</tr>
		
			
		<?php // endif; ?>
		</tbody>
	</table>
	<?php submit_button(); ?>
</form>
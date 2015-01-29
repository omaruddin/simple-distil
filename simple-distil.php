<?php
/*
Plugin Name: Simple Distil Cache Plugin for Wordpress
Plugin URI:  http://uvision.co/

Description: A simple plugin to add Distil auth token and uuid and clear cache of domain and subdomain . You simply enter your API key and uuid and apply.
Version: 1.0
Author: Omar Uddin
Author URI: http://uvision.co/
*/
?>
<?php

	add_action('admin_menu', 'distil_menu') ;	

	function distil_menu() {
		
		add_options_page('Simple Distil', 'Simple Distil Cache Settings', 'administrator', __FILE__, 'distil_settings') ;

		
		add_action( 'admin_init', 'distil_register_mysettings') ;
	}	

	function distil_register_mysettings() {
		register_setting('distil-settings-group', 'distil_api') ;
		register_setting('distil-settings-group', 'UUID') ;
	}
	

	function distil_settings() {

			$post_arr = array();
			$post_arr = $_POST;
			if (!empty($post_arr)) {
				$service_url = "https://api.distilnetworks.com:443/api/v1/domains/".get_option('UUID')."/cache.json?auth_token=".get_option('distil_api');
				
				$ch = curl_init($service_url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$json = curl_exec ($ch);
				curl_close ($ch);
				$msg = '';
		 		$json_decode = json_decode($json);
		 		if(isset($json_decode->error)){
		 			$msg = $json_decode->error;
		 		}
		 		if(isset($json_decode->message)){
		 			$msg = $json_decode->message;
		 		}
		 		
			}
		?>

		<div class="wrap">
			
			<h2><?php _e('Simple Distil', 'simple_distil') ; ?></h2>
			<p>
				<?php
					_e('Simple Distil allows you to easilly add your Distil API key and clear cache of domain and subdomain.', 'simple_distil') ;
					echo '<br/>' ;
					_e('Just go to your Distil <a href="http://www.distilnetworks.com/">management console</a>, find your auth token, add domain UUID and hit save.', 'simple_distil') ;
					echo '<br/>' ;
					_e('If you want to clear cache click on clear cache button, be sure to clear the cache across the entire site!', 'simple_distil') ;
					echo '<br/><br/>' ;
					_e('That\'s all, you\'re ready to go.', 'simple_distil') ;
				?>
			</p>
	
			<form method="post" action="options.php" id="distil_form">
				<?php settings_fields('distil-settings-group'); ?>
				
				<table class="form-table">
					<tr valign="top">
						<th scope="row" style="width: 300px; text-align:right;"><?php _e('Distil Auth Token', 'simple_distil') ; ?></th>
						<td>
							<input type="text" size="80" name="distil_api" value="<?php echo get_option('distil_api'); ?>">
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width: 300px; text-align:right;"><?php _e('UUID', 'UUID') ; ?></th>
						<td>
							<input type="text" size="80" name="UUID" value="<?php echo get_option('UUID'); ?>">
						</td>
					</tr>
				
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
					
				</p>
			</form>
			<form method="post" action="" >
				
				<h2><?php echo $msg;?><h2>
				<p class="submit">
					
					<input type="submit" class="button-primary" value="<?php _e('Clear Cache') ?>" name="clear_cache"/>
				</p>
			</form>
		
			<p>
				<?php
				_e('Get your own Distil account now - <a href="https://portal.distilnetworks.com">https://portal.distilnetworks.com/</a>', 'simple_distil') ;
					 
					
					
				?>
			</p>
		</div>

	<?php
	}
?>
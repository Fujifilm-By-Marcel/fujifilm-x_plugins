<?php
/**
 * Plugin Name: Fujifilm Newsletter Pop-up
 * Plugin URI: 
 * Description: Adds a newsletter pop-up to the site.
 * Version: 1.0
 * Author: Marcel Munevar
 * Author URI: 
 */

$currentBlogID = get_current_blog_id();

// create custom plugin settings menu
add_action('admin_menu', 'newsletter_popup_plugin_create_menu');

function newsletter_popup_plugin_create_menu() {

	if ( empty ( $GLOBALS['admin_page_hooks']['fujifilm-usa'] ) ){
		add_menu_page('Fujifilm USA', 'Fujifilm USA', 'administrator', 'fujifilm-usa' );
	}
	add_submenu_page( 'fujifilm-usa', 'Newsletter Pop-up Settings', 'Newsletter Pop-up Settings', 'administrator', 'fujifilm-newsletter-popup-plugin', 'newsletter_popup_plugin_settings_page' );
	remove_submenu_page('fujifilm-usa','fujifilm-usa');

	//call register settings function
	add_action( 'admin_init', 'register_newsletter_popup_plugin_settings' );
}


function register_newsletter_popup_plugin_settings() {
	//register our settings
	register_setting( 'newsletter-popup-plugin-settings-group', 'activate' );
	register_setting( 'newsletter-popup-plugin-settings-group', 'button_text' );
	register_setting( 'newsletter-popup-plugin-settings-group', 'form_url' );
	register_setting( 'newsletter-popup-plugin-settings-group', 'bg_img' );
}

function newsletter_popup_plugin_settings_page() {
?>
<div class="wrap">
<h1>Newsletter Pop-up</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'newsletter-popup-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'newsletter-popup-plugin-settings-group' ); ?>
    <table class="form-table">
		<tr valign="top">
			<th scope="row">Avtivate:</th>
			<td><input type="checkbox"  name="activate" value="activate" <?php checked( get_option('activate'), 'activate' ); ?> /></td>
        </tr>
        <tr valign="top">
			<th scope="row">Button Text:</th>
			<td><input type="text"  size="60" name="button_text" value="<?php echo esc_attr( get_option('button_text') ); ?>" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Form URL:</th>
			<td><input type="text"  size="100" name="form_url" value="<?php echo esc_attr( get_option('form_url') ); ?>" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Background Image:</th>
			<td><input type="text"  size="100" name="bg_img" value="<?php echo esc_attr( get_option('bg_img') ); ?>" /></td>
        </tr>
		
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 




class Newsletter {
  function addModal($post_ID)  {
	  
	//if ( is_front_page() ) {
		//switch_to_blog('11');
	?>
		<div id="newsletter-modal" class="newsletter-modal" style="display:none;">
			<div class="newsletter-modal-content">
				<span class="newsletter-close">&times;</span>
				<div class="newsletter-modal-body" style="background:url('<?php echo get_option( 'bg_img'); ?>');">
					<div class="newsletter-modal-iframe-container" >
						<iframe src="<?php echo get_option( 'form_url'); ?>" frameborder="0" scrolling="no" ></iframe>
					</div>
				</div>				
			</div>
		</div>
	<?php
		//restore_current_blog();
	//}
	  
  }
  function addCSS(){
	//if ( is_front_page() ) {
		wp_enqueue_style( 'modal', plugin_dir_url( __FILE__ ).'modal.css', array(), '1.0.8' );
		wp_enqueue_script( 'modal', plugin_dir_url( __FILE__ ).'modal.js', array(), '1.0.5', true );
	//}
  }
  function addButton(){
	//if ( is_front_page() ) { 
		//switch_to_blog('11');
	?>
	  <div id="newsletter-myBtn-container"><div id="newsletter-myBtn" style="display:none;"><?php echo get_option( 'button_text'); ?><div class="close">&#10006;</div></div></div>
	<?php
		//restore_current_blog();
	//}
  }
}

$myNewsletterClass = new Newsletter();

//switch_to_blog('11');
if( get_option('activate') ) {
	add_action('get_footer', array($myNewsletterClass, 'addModal'));
	add_action('get_footer', array($myNewsletterClass, 'addCSS'));
	add_action('get_footer', array($myNewsletterClass, 'addButton'));
}
//restore_current_blog();
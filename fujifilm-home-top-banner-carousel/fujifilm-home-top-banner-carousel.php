<?php
/**
 * Plugin Name: Fujifilm Home Top Banner
 * Plugin URI: 
 * Description: Adds a newsletter pop-up to the site.
 * Version: 1.0
 * Author: Marcel Munevar
 * Author URI: 
 */

// create custom plugin settings menu
add_action('admin_menu', 'home_top_banner_plugin_create_menu');

function home_top_banner_plugin_create_menu() {

	//create new top-level menu
	if ( empty ( $GLOBALS['admin_page_hooks']['fujifilm-usa'] ) ){
		add_menu_page('Fujifilm USA', 'Fujifilm USA', 'administrator', 'fujifilm-usa' );
	}
	add_submenu_page( 'fujifilm-usa', 'Homepage Top Banner Settings', 'Homepage Top Banner', 'administrator', 'fujifilm-home-top-banner-plugin', 'home_top_banner_plugin_settings_page' );
	remove_submenu_page('fujifilm-usa','fujifilm-usa');
	
	//call register settings function
	add_action( 'admin_init', 'register_home_top_banner_plugin_settings' );
}



function register_home_top_banner_plugin_settings() {
	//register our settings
	register_setting( 'home-top-banner-plugin-settings-group', 'num_banners' );	
	register_setting( 'home-top-banner-plugin-settings-group', 'bannerstitle' );
	register_setting( 'home-top-banner-plugin-settings-group', 'bannerscontent' );
	
	$numBanners = 1;
	if( get_option('num_banners') ){
		$numBanners = get_option('num_banners');
	}
	for ($i=0;$i<$numBanners;$i++) {
		register_setting( 'home-top-banner-plugin-settings-group', 'banner'.($i+1).'link' );
		register_setting( 'home-top-banner-plugin-settings-group', 'banner'.($i+1).'imageDesktop' );
		register_setting( 'home-top-banner-plugin-settings-group', 'banner'.($i+1).'imageTablet' );
		register_setting( 'home-top-banner-plugin-settings-group', 'banner'.($i+1).'imageMobile' );
		
	}
}




function home_top_banner_plugin_settings_page() {
?>
<div class="wrap">
<h1>Your Plugin Name</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'home-top-banner-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'home-top-banner-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
			<th scope="row">Number of Banners:</th>
			<td><input type="text"  size="4" name="num_banners" value="<?php echo esc_attr( get_option('num_banners') ); ?>" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Title:</th>
			<td><input type="text"  size="60" name="<?php echo 'bannerstitle'?>" value="<?php echo esc_attr( get_option('bannerstitle') ); ?>" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Content:</th>
			<td><?php wp_editor( esc_attr( get_option('bannerscontent') ), 'bannerscontent', array('textarea_rows'=>10) ) ?> </td>
		</tr>
    </table>
	<?php submit_button(); ?>
	
	<table class="form-table">
	<?php
	$numBanners = 0;
	if( get_option('num_banners') ){
		$numBanners = get_option('num_banners');
	}
	
	
	$devices = array("Desktop" => '1024',	"Tablet" => '768', "Mobile" => '500');
	
	for ($i=0;$i<$numBanners;$i++) {
	?>
		<tr valign="top">
			<th scope="row" colspan="2"><h2>Banner <?php echo ($i+1) ?></h2></th>
		</tr>
		
		<tr valign="top">
			<th scope="row">Link:</th>
			<td><input type="text"  size="60" name="<?php echo 'banner' .($i+1). 'link'?>" value="<?php echo esc_attr( get_option('banner' .($i+1). 'link') ); ?>" /></td>
		</tr>
		<?php 
		
		foreach ( $devices as $screenType => $resolution) {
		?>
		<tr valign="top">
			<th><?php echo $screenType ?> Image:</th>
			<td>
				<?php 
					$options = get_option( 'banner' .($i+1).  'image'.$screenType );
					$default_image = plugins_url('img/no-image.png', __FILE__);
					$myImg = getImg($options, $screenType);
				?>
				<div class="upload">
					<img data-src="<?php echo $default_image ?>" src="<?php echo $myImg->src ?>" width="<?php echo $myImg->width ?>px" height="<?php echo $myImg->height ?>px" />
					<div>
						<input type="hidden" name="<?php echo 'banner'.($i+1).'image'.$screenType ?>" id="<?php echo 'banner'.($i+1).'image'.$screenType ?>" value="<?php echo $myImg->value ?>" />
						<button type="submit" class="upload_image_button button" data-device="<?php echo $resolution ?>">Upload</button>
						<button type="submit" class="remove_image_button button">&times;</button>
					</div>
				</div>			
			</td>
		</tr>
		<?php } ?>
	<?php
	}
	?>
    </table>
    <?php submit_button(); ?>

</form>
</div>
<?php } 

function getImg( $options, $screenType ){
	$default_image = plugins_url('img/no-image.png', __FILE__);
	if ( !empty( $options ) ) {						
		if($screenType == "Desktop"){
			$image_attributes = wp_get_attachment_image_src( $options , array('1024') );						
		}
		else if($screenType == "Tablet"){
			$image_attributes = wp_get_attachment_image_src( $options , array('768') );						
		} 
		else if ($screenType == "Mobile"){
			$image_attributes = wp_get_attachment_image_src( $options , array('500') );						
		}
		
		$src = $image_attributes[0];
		$value = $options;
		$width = $image_attributes[1];
		$height = $image_attributes[2];
	} else {
		$src = $default_image;
		$value = '';
		$width = '';
		$height = '';
	}
	
	$object = (object) [
		'src' => $src,
		'value' => $value,
		'width' => $width,
		'height' => $height
    ];
	
	return $object;
}

class homeBanner {
	function addBanner($post_ID)  {
		switch_to_blog(11);
		$devices = array("Desktop" => '1024',	"Tablet" => '768', "Mobile" => '500');
		if(get_option('num_banners')) {	
			?>
			<div style="min-height: 100vh;" >
				<div class="homepage-banner-carousel-container">
					<div id="homepage-banner-carousel" class="homepage-banner-carousel">
						<?php for ($i=0;$i<get_option('num_banners');$i++) { ?>
						<div class="homepage-banner-mySlides homepage-banner-fade" slideindex="<?php echo $i+1 ?>">
							<a href="<?php echo get_option( 'banner'.($i+1).'link' ) ?>">
								<?php 			
								foreach ( $devices as $screenType => $resolution) {
									$bannerImg = get_option( 'banner'.($i+1).'image'.$screenType );
								?>
								<img src="<?php echo wp_get_attachment_image_url( $bannerImg, 'full' ) ?>" srcset="<?php echo wp_get_attachment_image_srcset( $bannerImg, 'full' ); ?>" class="banner-<?php echo $screenType ?>" >
								<?php } ?>

							</a>
						</div>
						<?php } ?>
						<!-- Next and previous buttons -->
						<a class="homepage-banner-prev" onclick="plusSlides(-1)">&#10094;</a>
						<a class="homepage-banner-next" onclick="plusSlides(1)">&#10095;</a>
					</div>

					<!-- The dots/circles -->
					<div class="homepage-banner-dots">
						<?php for ($i=0;$i<get_option( 'num_banners');$i++) { ?>
						<span class="homepage-banner-dot" onclick="currentSlide(<?php echo ($i+1) ?>)"></span> 
						<?php } ?>
					</div>
				</div>
				<div class="wp-content">
					<div class="xstoriespost__titles">
						<h1><?php echo get_option('bannerstitle') ?></h1>
						<p><?php echo get_option('bannerscontent') ?></p>
					</div>
				</div>
			</div>
			<?php
		}
		restore_current_blog();
	}
	function addCSS(){
		wp_enqueue_style( 'topBanner', plugin_dir_url( __FILE__ ).'style.css', array(), '1.0.3' );
	}
	function addJS(){
		wp_enqueue_script( 'hammer', plugin_dir_url( __FILE__ ).'hammer.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'topBanner', plugin_dir_url( __FILE__ ).'script.js', array(), '1.0.1', true );
	}
	function addAdminJS(){
		wp_enqueue_script( 'topBanner', plugin_dir_url( __FILE__ ).'admin.js', array(), '1.0.0', true );
	}
}

$myHomeBannerClass = new homeBanner();

add_action('get_header', array($myHomeBannerClass, 'addCSS'));
add_action('home-top-banner-carousel', array($myHomeBannerClass, 'addBanner'));
add_action('get_footer', array($myHomeBannerClass, 'addJS'));
add_action( 'admin_enqueue_scripts', array($myHomeBannerClass, 'addAdminJS') );

function homeBanner_load_scripts_admin() {
    wp_enqueue_media();	
}




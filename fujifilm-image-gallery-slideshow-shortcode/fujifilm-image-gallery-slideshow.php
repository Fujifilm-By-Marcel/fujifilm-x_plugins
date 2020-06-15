<?php
/**
 * Plugin Name: Fujifilm Image Gallery Slideshow Shortcode
 * Plugin URI: 
 * Description: Use shortcode [img-gallery id="1,2,3,4"] to display an image gallery.
 * Version: 1.0
 * Author: Marcel Munevar
 * Author URI: 
 */
 
 
wp_register_style( 'simpleimagegallery', plugin_dir_url( __FILE__ ).'style.css', array(), '1.0.3' );
wp_register_script( 'simpleimagegallery_hammer', plugin_dir_url( __FILE__ ).'hammer.min.js', array(), '1.0.0', true );
wp_register_script( 'simpleimagegallery', plugin_dir_url( __FILE__ ).'script.js', array(), '1.0.1', true );
 
 class simpleImageGallery {
	 
	 function hello(){
		 echo "<script>console.log('hello')</script>";
	 }
	 
	function addImageGallery($ids)  {	
		wp_enqueue_style( 'simpleimagegallery' );
		wp_enqueue_script( 'simpleimagegallery_hammer' );
		wp_enqueue_script( 'simpleimagegallery' );

		$ids = explode(",", $ids);
	?>
		<div class="simple-image-gallery-carousel-container">
			<div id="simple-image-gallery-carousel" class="simple-image-gallery-carousel">
				<?php for ($i=0;$i<count($ids);$i++) { ?>
				<div class="simple-image-gallery-mySlides" slideindex="<?php echo $i+1 ?>">						
					<img src="<?php echo wp_get_attachment_image_url( $ids[$i], 'full' ) ?>" srcset="<?php echo wp_get_attachment_image_srcset( $ids[$i], 'full' ); ?>" >
				</div>
				<?php } ?>
				<!-- Next and previous buttons -->
				<a class="simple-image-gallery-prev" onclick="simpleimagegallery_plusSlides(-1)">&#10094;</a>
				<a class="simple-image-gallery-next" onclick="simpleimagegallery_plusSlides(1)">&#10095;</a>
			</div>

			<!-- The dots/circles -->
			<div class="simple-image-gallery-dots">
				<?php for ($i=0;$i<count($ids);$i++) { ?>
				<span class="simple-image-gallery-dot" onclick="simpleimagegallery_currentSlide(<?php echo ($i+1) ?>)"></span> 
				<?php } ?>
			</div>
		</div>
	<?php
	}
}

$mySimpleGalleryClass = new simpleImageGallery();

function imageGallery_func( $atts ) {	
	$mySimpleGalleryClass = new simpleImageGallery();
	return $mySimpleGalleryClass->addImageGallery($atts['id']);
}

add_shortcode( 'img-gallery', 'imageGallery_func' );
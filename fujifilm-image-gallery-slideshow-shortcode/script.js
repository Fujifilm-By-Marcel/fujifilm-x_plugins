var simpleimagegallery_slideIndex = 1;
simpleimagegallery_showSlides(simpleimagegallery_slideIndex);

// Next/previous controls
function simpleimagegallery_plusSlides(n) {
  simpleimagegallery_showSlides(simpleimagegallery_slideIndex += n);
}

// Thumbnail image controls
function simpleimagegallery_currentSlide(n) {
  simpleimagegallery_showSlides(simpleimagegallery_slideIndex = n);
}

function simpleimagegallery_showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("simple-image-gallery-mySlides");
  var dots = document.getElementsByClassName("simple-image-gallery-dot");
  if (n > slides.length) {simpleimagegallery_slideIndex = 1} 
  if (n < 1) {simpleimagegallery_slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[simpleimagegallery_slideIndex-1].style.display = "block"; 
  dots[simpleimagegallery_slideIndex-1].className += " active";
}

var simpleimagegallery_hammertime = new Hammer( document.getElementById("simple-image-gallery-carousel") );

simpleimagegallery_hammertime.on('swipeleft', function(ev){
	simpleimagegallery_plusSlides(-1);
});
simpleimagegallery_hammertime.on('swiperight', function(ev){
	simpleimagegallery_plusSlides(1);
});


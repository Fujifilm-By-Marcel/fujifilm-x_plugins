jQuery(document).ready(function(){});



var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("homepage-banner-mySlides");
  var dots = document.getElementsByClassName("homepage-banner-dot");
  if (n > slides.length) {slideIndex = 1} 
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block"; 
  dots[slideIndex-1].className += " active";
}


var slideIndex = 0;
var timer = setTimeout(startSlides, 4000);


function startSlides() {
  var i;
  var slides = document.getElementsByClassName("homepage-banner-mySlides");
  var dots = document.getElementsByClassName("homepage-banner-dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none"; 
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block"; 
  dots[slideIndex-1].className += " active";
  clearTimeout(timer);
  timer = setTimeout(startSlides, 4000); 
}

jQuery( ".homepage-banner-mySlides" ).hover(
  function() {
    clearTimeout(timer);
  }, function() {
	clearTimeout(timer);
    timer = setTimeout(startSlides, 4000);
  }
);

var hammertime = new Hammer( document.getElementById("homepage-banner-carousel") );
hammertime.on('swipeleft', function(ev){
	plusSlides(-1);
	clearTimeout(timer);
    timer = setTimeout(startSlides, 4000);
});
hammertime.on('swiperight', function(ev){
	plusSlides(1);
	clearTimeout(timer);
    timer = setTimeout(startSlides, 4000);
});


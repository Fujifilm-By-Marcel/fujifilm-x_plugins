jQuery( document ).ready(function() {
	// Get the modal
	var modal = document.getElementById("newsletter-modal");

	// Get the button that opens the modal
	var btn = document.getElementById("newsletter-myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("newsletter-close")[0];

	// When the user clicks on the button, open the modal 
	jQuery(btn).click(function(event) {
	  if( jQuery(event.target).is(".close") || jQuery(event.target).is(".emoji") ){
          jQuery( "#newsletter-myBtn" ).animate({
				top: "60px",
			}, 500, function() {
				// Animation complete.
			});
	  }
	  else{
	      modal.style.display = "block";
	  }
	});

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}

	jQuery( "#newsletter-myBtn .close" ).hover(function (){
		jQuery(this).parent().css("border-color","#aaa");
	}, function(){
		jQuery(this).parent().css("border-color","");
	});

	jQuery( "#newsletter-myBtn" ).css("top", "60px");
	jQuery( "#newsletter-myBtn" ).show();
	jQuery( "#newsletter-myBtn" ).delay( 3000 ).animate({
		top: 0,
	}, 500, function() {
		// Animation complete.
	});

	  
});




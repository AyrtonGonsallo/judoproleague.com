const searchField = document.querySelector('.search-field');
searchField.placeholder = ' ';

        // Select the button using its class name
        const button = document.querySelector('.ays-survey-section-button.ays-survey-finish-button');
        // Change the text of the button
        button.value = 'Voter';



// $(document).ready(function() {
//   var maxHeight = 0;
//   // Find the maximum height
//   $('.thumb-article').each(function() {
//     if ($(this).height() > maxHeight) {
//       maxHeight = $(this).height();
//     }
//   });
//   // Apply the maximum height to each element
//   $('.thumb-article').height(maxHeight);
// });

$(document).ready(function() {
  var maxHeight = 0;

  // Find the maximum height
  $('.thumb-article, .nv-title-news-3-col, .titile-stat').each(function() {
    if ($(this).height() > maxHeight) {
      maxHeight = $(this).height();
    }
  });

  // Apply the maximum height
  $('.thumb-article, .nv-title-news-3-col, .titile-stat').height(maxHeight);
});

/*******************************************/
(function ($) {
	$("#navbar .navbar-toggler").on("click", () => {
		$("div#navbar-menu").toggleClass("active");
	});
})(jQuery);


var cb = document.querySelectorAll(".close");
for (i = 0; i < cb.length; i++) {
   cb[i].addEventListener("click", function () {
      var dia = this.parentNode
         .parentNode; /* You need to update this part if you change level of close button */
      dia.style.opacity = 0;
      dia.style.zIndex = -1;
   });
}

var mt = document.querySelectorAll(".modal-toggle");
for (i = 0; i < mt.length; i++) {
   mt[i].addEventListener("click", function () {
      var targetId = this.getAttribute("data-target");
      var target = document.getElementById(targetId);
      target.style.opacity = 1;
      target.style.zIndex = 9999;
   });
}


( function( $ ) {
	$(window).load(function() {
		$('.flexslider').flexslider({
		  animation: "slide",
		  animationLoop: false,
		  itemWidth: 210,
		  itemMargin: 20,
		  minItems: 2,
		  maxItems: 6,
		});
		$('.nv-btns').show();
	  });
}( jQuery ) );
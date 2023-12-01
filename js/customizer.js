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
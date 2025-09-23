
jQuery(document).ready(function(jQuery) { 




/******************************** tab bar mob-promos *********************************/

  var currentUrl = window.location.pathname.replace(/\/$/, "");

  $(".footer-menu-mobile-paris .sub-menu-element a").each(function () {
    var linkUrl = $(this).attr("href").replace(/\/$/, "");
    if (currentUrl === linkUrl) {
      $(this).addClass("active");
    }
  });




});

/**


 * Template Name: FlexStart - v1.4.0


 * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/


 * Author: BootstrapMade.com


 * License: https://bootstrapmade.com/license/


 */


/*****************slide-rencontre-marge*********************/
document.addEventListener("DOMContentLoaded", function() {
    var splideSlides = document.querySelectorAll("#splide01-list .splide__slide");

    function applyMargins() {
        if (window.innerWidth >= 1283) {
            splideSlides.forEach(function(slide) {
                slide.style.marginLeft = "10px";
                slide.style.marginRight = "10px";
                slide.style.marginBottom = "0px";
            });
        } else {
            splideSlides.forEach(function(slide) {
                slide.style.marginLeft = "3px";
                slide.style.marginRight = "3px";
                slide.style.marginBottom = "0px";
            });
        }
    }

    // Apply margins on load
    applyMargins();

    // Re-apply margins when the window is resized
    window.addEventListener('resize', applyMargins);
});
/*********************************changement du message de vote **********************************************/
document.addEventListener("DOMContentLoaded", function() {
    var intervalId = setInterval(function() {
        var thankYouMessage = document.querySelector(".ays-survey-thank-you-page p");
        if (thankYouMessage) {
            thankYouMessage.textContent = "Merci, votre vote a bien été enregistré !";
            clearInterval(intervalId); // Stop checking once the message is found and updated
        }
    }, 100); // Check every 100ms
});


/****** Equal (min-height) for textes,titles, exc in inline blocs *****/
        var max_heightTxt =(classes)=>{
            var max_height_txt = jQuery(classes).map(function (){return jQuery(this).height();}).get();
            minHeightTxt = Math.max.apply(null, max_height_txt);
            jQuery(classes).css( "min-height",minHeightTxt );
        }
   setTimeout(() => {
        //dupliquer le code suivant ou cas de besoin d'autres element de méme hauteur !
        max_heightTxt('.div-eq.premier .div-num-conf');
        max_heightTxt('.nom-premier');
}, "100");


/*************************************************/

$(document).ready(function() {
    // Obtenez l'URL actuelle
    var currentUrl = window.location.href;

    // Sélectionnez l'élément <li> du lien Classement
    var classementLink = $('#menu-item-2890');

    // Vérifiez si l'URL contient "/classement"
    if (currentUrl.includes("/quarts") || currentUrl.includes("/poules") || currentUrl.includes("/final4")) {
        // Ajoutez la classe 'active' pour ajouter le border-bottom
        classementLink.addClass('active');
    }
    
});
$(document).ready(function() {
    // Obtenez l'URL actuelle
    var currentUrl = window.location.href;

    // Sélectionnez l'élément <li> du lien Classement
    var classementLink = $('#menu-item-2891');

    // Vérifiez si l'URL contient "/classement"
    if (currentUrl.includes("/classement-judo-pro-league-2023") || currentUrl.includes("/tableau-principal-judo-pro-league-2023")) {
        // Ajoutez la classe 'active' pour ajouter le border-bottom
        classementLink.addClass('active');
    }
    
});










function getCurrentURL () {


 var bandeau = document.getElementsByClassName("section-event-live");


    var bandeau_existe = bandeau.length>0


    if(bandeau_existe){


        console.log("bandeau actif")


        document.getElementById("primary").style="margin-top: 0px; !important"


    }


    return window.location.href.split(".fr/")


  }


  








function load_functions_of_page() {


   const regex_resultats = new RegExp(/judo_pro_league\/.*/);
   const regex_anglais = new RegExp(/en\/.*/);


	const regex_resultats2 = new RegExp(/en\/.*/);


    //urlparts = getCurrentURL(), console.log(urlparts), (urlparts.length < 1 || "#" == urlparts[1]  || "" == urlparts[1]) && (load_french_counter())


	//urlparts = getCurrentURL(), console.log(urlparts), ("en/" == urlparts[1]) && (load_english_counter())

    urlparts = getCurrentURL()
    if("admin-videos/" == urlparts[1]){


        loadClient().then(execute)

    }
    if(regex_anglais.test(urlparts[1])){
        elem=document.querySelector("#langues-menu .menu-item-1678 > a")
        console.log("page en anglais",elem)
		elem.style.color = "blue";
    }else{
        elem2=document.querySelector("#langues-menu .menu-item-1679 > a")
        console.log("page en francais",elem2)
		elem2.classList.add("souligne")
    }

    if(regex_resultats.test(urlparts[1])){


        console.log("page resultats")


        document.getElementById("primary-menu").style="margin:17px 0px;"


		document.getElementsByClassName("container")[0].style="padding:0px;max-width:75% !important;"


		document.querySelector("#menu-item-759 a").classList.add("souligne")


    }


	


}








function load_french_counter() {


    var e = document.getElementById("next-event-date").innerHTML,


        t = new Date(e).getTime(),


        o = setInterval(function() {


            var e = new Date().getTime(),


                i = t - e;


            document.getElementById("demo").innerHTML = "<div class='count-down'><span class='count-down-txt'>jours</span><span class='count-down-number'>" + Math.floor(i / 864e5) + "</span></div> <div class='count-down'><span class='count-down-txt'>heures</span><span class='count-down-number'>" + Math.floor(i % 864e5 / 36e5) + "</span></div>  <div class='count-down'><span class='count-down-txt'>minutes</span><span class='count-down-number'>" + Math.floor(i % 36e5 / 6e4) + "</span></div>  <div class='count-down'><span class='count-down-txt'>secondes</span><span class='count-down-number'>" + Math.floor(i % 6e4 / 1e3) + "</span></div>", i < 0 && (clearInterval(o),document.getElementById("demo").classList.remove("count-down-container"),


document.getElementById("demo").innerHTML = "<div class='infos-envet'><p>Vainqueur de la Judo Pro League 2022 : Paris Saclay Judo</p></div>")


        }, 1e3)


}





function load_english_counter() {


    var e = document.getElementById("next-event-date").innerHTML,


        t = new Date(e).getTime(),


        o = setInterval(function() {


            var e = new Date().getTime(),


                i = t - e;


            document.getElementById("demo").innerHTML = "<div class='count-down'><span class='count-down-txt'>days</span><span class='count-down-number'>" + Math.floor(i / 864e5) + "</span></div> <div class='count-down'><span class='count-down-txt'>hours</span><span class='count-down-number'>" + Math.floor(i % 864e5 / 36e5) + "</span></div>  <div class='count-down'><span class='count-down-txt'>minutes</span><span class='count-down-number'>" + Math.floor(i % 36e5 / 6e4) + "</span></div>  <div class='count-down'><span class='count-down-txt'>seconds</span><span class='count-down-number'>" + Math.floor(i % 6e4 / 1e3) + "</span></div>", i < 0 && (clearInterval(o),document.getElementById("demo").classList.remove("count-down-container"),


document.getElementById("demo").innerHTML = "<div class='infos-envet'><p>Judo Pro League 2022's winner : Paris Saclay Judo</p></div>")}, 1e3)


}


function loadClient() {


    return gapi.client.setApiKey("AIzaSyDIz30Qql_U2f31MnckTEhp9XWxqte2ENg"), gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest").then(function() {


        console.log("GAPI client loaded for API")


    }, function(e) {


        console.error("Error loading GAPI client for API", e)


    })


}





function execute() {


    return gapi.client.youtube.search.list({


        part: ["snippet"],


        channelId: "UC1f3LEmw3KiLiLmejqt2I2g",


        maxResults: 4,


        order: "date",


        q: "judo pro league",


        type: ["video"]


    }).then(function(e) {


        contenu = JSON.parse(e.body), console.log("elements de la playlist", contenu.items), contenu.items.forEach(e => {


            var t = e.id.videoId;


            console.log("videos", t)


        }), document.getElementById("titre-video1").innerHTML = contenu.items[0].snippet.title,document.getElementById("date-video1").innerHTML = contenu.items[0].snippet.publishedAt, document.getElementById("titre-video2").innerHTML = contenu.items[1].snippet.title,document.getElementById("date-video2").innerHTML = contenu.items[1].snippet.publishedAt, document.getElementById("titre-video3").innerHTML = contenu.items[2].snippet.title,document.getElementById("date-video3").innerHTML = contenu.items[2].snippet.publishedAt, document.getElementById("titre-video4").innerHTML = contenu.items[3].snippet.title,document.getElementById("date-video4").innerHTML = contenu.items[3].snippet.publishedAt, document.getElementById("video-image-1").style.backgroundImage = "url('https://i.ytimg.com/vi/" + contenu.items[0].id.videoId + "/hqdefault.jpg')", document.getElementById("video-image-2").style.backgroundImage = "url('https://i.ytimg.com/vi/" + contenu.items[1].id.videoId + "/hqdefault.jpg')", document.getElementById("video-image-3").style.backgroundImage = "url('https://i.ytimg.com/vi/" + contenu.items[2].id.videoId + "/hqdefault.jpg')", document.getElementById("video-image-4").style.backgroundImage = "url('https://i.ytimg.com/vi/" + contenu.items[3].id.videoId + "/hqdefault.jpg')", document.querySelector("#button-play-video-1 a").href = "https://www.youtube.com/watch?v=" + contenu.items[0].id.videoId + "&width=640&height=480", document.querySelector("#button-play-video-1-2 a").href = "https://www.youtube.com/watch?v=" + contenu.items[0].id.videoId + "&width=300&height=160", document.querySelector("#button-play-video-2 a").href = "https://www.youtube.com/watch?v=" + contenu.items[1].id.videoId + "&width=640&height=480", document.querySelector("#button-play-video-2-2 a").href = "https://www.youtube.com/watch?v=" + contenu.items[1].id.videoId + "&width=300&height=160", document.querySelector("#button-play-video-3 a").href = "https://www.youtube.com/watch?v=" + contenu.items[2].id.videoId + "&width=640&height=480", document.querySelector("#button-play-video-3-2 a").href = "https://www.youtube.com/watch?v=" + contenu.items[2].id.videoId + "&width=300&height=160", document.querySelector("#button-play-video-4 a").href = "https://www.youtube.com/watch?v=" + contenu.items[3].id.videoId + "&width=640&height=480"


        var boutons = document.getElementsByClassName("form-check-input")


        boutons[0].value=contenu.items[0].id.videoId


        boutons[1].value=contenu.items[1].id.videoId


        boutons[2].value=contenu.items[2].id.videoId


        boutons[3].value=contenu.items[3].id.videoId


    }, function(e) {


        console.error("Execute error", e)


    })


}


window.addEventListener("load", load_functions_of_page),


    function() {


        "use strict";


        let e = (e, t = !1) => (e = e.trim(), t) ? [...document.querySelectorAll(e)] : document.querySelector(e),


            t = (t, o, i, n = !1) => {


                n ? e(o, n).forEach(e => e.addEventListener(t, i)) : e(o, n).addEventListener(t, i)


            },


            o = (e, t) => {


                e.addEventListener("scroll", t)


            },


            i = e("#navbar .scrollto", !0),


            n = () => {


                let t = window.scrollY + 200;


                i.forEach(o => {


                    if (!o.hash) return;


                    let i = e(o.hash);


                    i && (t >= i.offsetTop && t <= i.offsetTop + i.offsetHeight ? o.classList.add("active") : o.classList.remove("active"))


                })


            };


        window.addEventListener("load", n), o(document, n);


        let s = t => {


                let o = e("#header"),


                    i = o.offsetHeight;


                o.classList.contains("header-scrolled") || (i -= 10);


                let n = e(t).offsetTop;


                window.scrollTo({


                    top: n - i,


                    behavior: "smooth"


                })


            },


            a = e("#header");


        if (a) {


            let d = () => {


                window.scrollY > 100 ? a.classList.add("header-scrolled") : a.classList.remove("header-scrolled")


            };


            window.addEventListener("load", d), o(document, d)


        }


        let l = e(".back-to-top");


        if (l) {


            let r = () => {


                window.scrollY > 100 ? l.classList.add("active") : l.classList.remove("active")


            };


            window.addEventListener("load", r), o(document, r)


        }


        t("click", ".scrollto", function(t) {


            if (e(this.hash)) {


                t.preventDefault();


                let o = e("#navbar");


                if (o.classList.contains("navbar-mobile")) {


                    o.classList.remove("navbar-mobile");


                    let i = e(".mobile-nav-toggle");


                    i.classList.toggle("bi-list"), i.classList.toggle("bi-x")


                }


                s(this.hash)


            }


        }, !0), window.addEventListener("load", () => {


            window.location.hash && e(window.location.hash) && s(window.location.hash)


        }), t("click", "#navbar-menu .navbar-nav a", function(e) {


            jQuery(this).closest("div#navbar-menu").removeClass("active")


        }, !0)


    }();






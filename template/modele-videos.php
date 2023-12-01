<?php

/**
 * Template Name: Modèle admin videos
 */

get_header();
$titlebar   = get_field('header_de_la_page');
$title   = get_field('titre_de_la_page');
$premier_tour= get_field('1er_tour');
$quarts_de_finales= get_field('quarts_de_finale');
$final_four= get_field('final_four');
?>

<main id="primary" class="site-main ">
    <section class="videos-playlist">
    <div class="title-gallery">
        <h2 class="title-videos">Les dernières vidéos</h2>
    </div>
    <div class="videos-admin-container" id="videoscontainer">
        <div class="videos-admin-container-element">
            <div class="input-group-text ms-4 mt-4 mb-4 me-4">
                <input class="form-check-input mt-0" type="checkbox" value="pukN49cHGyw" aria-label="Checkbox for following text input">
            </div>
            <div id="video-image-1" class="video-preview-admin" style="background-image: url(https://i.ytimg.com/vi/pukN49cHGyw/hqdefault.jpg);">
                <div class="button-play-video-admin button-play-video-grande-taille" id="button-play-video-1">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
				<div class="button-play-video-admin button-play-video-mobile" id="button-play-video-1-2">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
            </div>
            <div class="video-title-infos">
                <div id="titre-video1">Judo Pro League - Phase de poules : poule A</div>
                <div id="date-video1">22/11/2022</div>
            </div>
        </div>
        <div class="videos-admin-container-element">
            <div class="input-group-text ms-4 mt-4 mb-4 me-4">
                <input class="form-check-input mt-0" type="checkbox" value="pukN49cHGyw" aria-label="Checkbox for following text input">
            </div>
            <div id="video-image-2" class="video-preview-admin" style="background-image: url(https://i.ytimg.com/vi/pukN49cHGyw/hqdefault.jpg);">
                <div class="button-play-video-admin button-play-video-grande-taille" id="button-play-video-2">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
				<div class="button-play-video-admin button-play-video-mobile" id="button-play-video-2-2">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
            </div>
            <div class="video-title-infos">
                <div id="titre-video2">Judo Pro League - Phase de poules : poule A</div>
                <div id="date-video2">22/11/2022</div>
            </div>
        </div>
        <div class="videos-admin-container-element">
            <div class="input-group-text ms-4 mt-4 mb-4 me-4">
                <input class="form-check-input mt-0" type="checkbox" value="pukN49cHGyw" aria-label="Checkbox for following text input">
            </div>
            <div id="video-image-3" class="video-preview-admin" style="background-image: url(https://i.ytimg.com/vi/pukN49cHGyw/hqdefault.jpg);">
                <div class="button-play-video-admin button-play-video-grande-taille" id="button-play-video-3">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
                <div class="button-play-video-admin button-play-video-mobile" id="button-play-video-3-2">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
            </div>
            <div class="video-title-infos">
                
                <div id="titre-video3">Judo Pro League - Phase de poules : poule A</div>
                <div id="date-video3">22/11/2022</div>
            </div>
        </div>
        
        <div class="videos-admin-container-element">
            <div class="input-group-text ms-4 mt-4 mb-4 me-4">
                <input class="form-check-input mt-0" type="checkbox" value="pukN49cHGyw" aria-label="Checkbox for following text input">
            </div>
            <div id="video-image-4" class="video-preview-admin" style="background-image: url(https://i.ytimg.com/vi/pukN49cHGyw/hqdefault.jpg);">
                <div class="button-play-video-admin button-play-video-grande-taille" id="button-play-video-4">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
                <div class="button-play-video-admin button-play-video-mobile" id="button-play-video-4-2">
                    <?php echo do_shortcode('[video_lightbox_youtube video_id="pukN49cHGyw" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                </div>
            </div>
            <div class="video-title-infos">
                
                <div id="titre-video4">Judo Pro League - Phase de poules : poule A</div>
                <div id="date-video4">22/11/2022</div>
            </div>
        </div>
        
    </div>
     <div class="bouton-container">    
        <div class="style-bouton" style="width:fit-content"><a href="javascript:void(0)" id="sauvegarder">sauvegarder</a></div>
    </div>
<script src="https://apis.google.com/js/api.js"></script>
<script>
  /**
   * Sample JavaScript code for youtube.playlists.list
   * See instructions for running APIs Explorer code samples locally:
   * https://developers.google.com/explorer-help/code-samples#javascript
   */
  
  gapi.load("client:auth2", function() {
    gapi.auth2.init({client_id: "378546381901-4v2l4h5sc0s2fprtkbgscqvls1vlbls8.apps.googleusercontent.com",
        plugin_name: 'put anything here',});
  });
  function addvideos(){

  }
  document.getElementById("sauvegarder").addEventListener("click", () => {
    var boutons = document.getElementsByClassName("form-check-input")
            console.log("clicked")
            var i =[0,1,2,3]
            i.forEach(o => {
                if(boutons[o].checked){
                    var id=boutons[o].value
                    var titre=document.getElementById("titre-video"+(o+1)).innerHTML
                    var date= document.getElementById("date-video"+(o+1)).innerHTML
                    var lien=document.getElementById("video-image-"+(o+1)).style.backgroundImage.slice(5,-2)
                    console.log(id,titre,date,lien)
                    $.ajax({
 
                    url: ajaxurl,
                    
                    type: 'POST',
                    
                    data: {
                    
                    post_details : {

                    id_video: id,
                    titre_video:titre,
                    date_video:date,
                    lien_image:lien,
                    
                    },
                    
                    action: 'ajouter_video' // this is going to be used inside wordpress functions.php
                    
                    },
                    
                    error: function(error) {
                    
                    alert("Ajout des vidéos échoué");
                    console.log(error)
                    
                    },
                    
                    success: function(response) {
                    
                    alert("Ajout des videos reussi" + response);
                    console.log(response)
                    
                    }

                    });
                    
                }
                
            })
        })
</script>

    </section>

    <?php
get_footer();
?>
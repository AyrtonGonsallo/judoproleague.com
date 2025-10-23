<?php


/**




 * Template Name: Modèle test videos combats



 */




get_header();
// Appel API JudoManager (test)
$apiUrl = "https://datav2-dev.judomanager.com/api/JudoProLeague/1";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

$combats = array_slice($data['Rencontres'][0]['Combats'], 0, 2); // 2 combats pour test
?>


<style>
table { width:100%; border-collapse: collapse; background:white; }
td, th { border:1px solid #ccc; padding:10px; text-align:center; }
button { padding:6px 12px; cursor:pointer; background:#0073aa; color:white; border:none; border-radius:4px; }
#videoPopup {
    display:none;
    position:fixed;
    top:0; left:0; right:0; bottom:0;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
}
#videoPopupContent {
    background:white;
    padding:20px;
    border-radius:8px;
    position:relative;
    max-width:800px;
    width:90%;
}
#closePopup {
    position:absolute;
    top:8px; right:10px;
    font-size:18px;
    cursor:pointer;
}
video { width:100%; border-radius:6px; }
</style>


<h2>Tests de vidéos JudoManager</h2>

<table>
    <tr><th>Judoka 1</th><th>Judoka 2</th><th>Vidéo</th></tr>
    <?php foreach($combats as $c): 
        $judoka1 = $c['Trame']['Nom1'] . ' ' . $c['Trame']['Prenom1'];
        $judoka2 = $c['Trame']['Nom2'] . ' ' . $c['Trame']['Prenom2'];
        $slug = $c['Media'][0]['Slug'] ?? '';
    ?>
    <tr>
        <td><?= htmlspecialchars($judoka1) ?></td>
        <td><?= htmlspecialchars($judoka2) ?></td>
        <td><button class="voirVideo" data-slug="<?= htmlspecialchars($slug) ?>">Voir la vidéo</button></td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Popup vidéo -->
<div id="videoPopup">
    <div id="videoPopupContent">
        <span id="closePopup">✖</span>
        <video id="videoPlayer" controls></video>
    </div>
</div>

<script>
jQuery(function($){
/*
    $(".voirVideo").on("click", function(){
        var slug = $(this).data("slug");
        if(!slug){ alert("Pas de vidéo pour ce combat"); return; }

        // Appel à l’API MediaTokenForVideofield
        $.getJSON("https://datav2.judomanager.com/api/Contest/MediaTokenForVideofield", {
            slug: slug,
            idPartner: 7
        }).done(function(data){
            if(data && data.url){
                $("#videoPlayer").attr("src", data.url);
                $("#videoPopup").fadeIn();
            } else {
                alert("Vidéo introuvable");
            }
        }).fail(function(){
            alert("Erreur lors du chargement de la vidéo");
        });
    });

    

    $("#closePopup").on("click", function(){
        $("#videoPlayer").get(0).pause();
        $("#videoPopup").fadeOut();
    });
    */
});
</script>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
$(function(){
  $(".voirVideo").on("click", function(){
    const slug = $(this).data("slug");
    if (!slug) return alert("Pas de vidéo pour ce combat.");

    // 🔹 Appel via le proxy dans le même dossier du thème
    $.getJSON("<?php echo get_template_directory_uri(); ?>/template/proxy.php", { slug: slug })
      .done(function(data){
        const videoUrl = data.url || data;

        if (!videoUrl) {
          alert("Lien vidéo non trouvé");
          return;
        }

        const video = document.getElementById('videoPlayer');

        // Si le navigateur supporte HLS nativement (Safari, iPhone)
        if (video.canPlayType('application/vnd.apple.mpegurl')) {
          video.src = videoUrl;
        } else if (Hls.isSupported()) {
          // Sinon, on passe par hls.js
          const hls = new Hls();
          hls.loadSource(videoUrl);
          hls.attachMedia(video);
        } else {
          alert("Votre navigateur ne supporte pas la lecture HLS.");
          return;
        }

        $("#videoPopup").fadeIn();
      })
      .fail(function(){
        alert("Erreur de chargement vidéo");
      });
  });

  $("#closePopup").on("click", function(){
    $("#videoPlayer").get(0).pause();
    $("#videoPopup").fadeOut();
  });
});
</script>




<?php
    get_footer();
?>
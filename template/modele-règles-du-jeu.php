<?php

/**
 * Template Name: Modèle module de pari (règles du jeu)
 */

get_header();
$logo =  wp_get_attachment_image_url( 5115,"large" );
$equipes = get_posts(array(
    'numberposts' => -1,
    'post_type'   => 'equipes',
    'orderby'     => 'title',
    'order'       => 'ASC',
    'meta_query'  => array(
        array(
            'key'     => 'saisons',
            'compare' => 'LIKE',
            'value'   => '2025-2026'
        )
    )
));
?>

<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<main id="primary" class="site-main regles-pari">
    <section class="listes-equipes page-calendrier">

        <div class="flex-3-pari2">
        <div class="sub-menu-element round-border-purple bg-gray flex">
            <a href="/module-de-paris-home">
                <img src="/wp-content/uploads/2025/09/home.webp" width="30" class="menu-icon">
                <span>Accueil</span>
            </a>
        </div>
        <div class="sub-menu-element round-border-purple bg-gray flex">
            <a href="module-de-paris-paris">
                <img src="/wp-content/uploads/2025/09/classer.webp" width="30" class="menu-icon">
                <span>Mes pronos</span>
            </a>
        </div>
        <div class="sub-menu-element round-border-purple bg-gray flex">
            <a href="/module-de-paris-ligues">
                <img src="/wp-content/uploads/2025/09/users.webp" width="30" class="menu-icon">
                <span>Mes ligues</span>
            </a>
        </div>
        <div class="sub-menu-element round-border-purple bg-gray flex">
            <a href="/module-de-paris-classement" class="disabled">
                <img src="/wp-content/uploads/2025/09/medals.webp" width="30" class="menu-icon">
                <span>Mon classement</span>
            </a>
        </div>
    </div><br><br>
        <div class="">
            <div class="flex-row-center">
                <img src="/wp-content/uploads/2025/09/JUDO PRONOS CHALLENGE.png" width="300" style="margin-inline:auto;margin-bottom:20px;" class="sub-header-pari-logo" >
            </div>
            <div class="flex-row-center">
                
            </div>
        </div>

    <div class="container-list">
    <h3> Parie sur la JPL et entre dans le game !</h3>
    <p>
Tu connais la Judo Pro League ? C’est le judo version grand spectacle : des clubs pros, des équipes mixtes, des duels de folie et une ambiance survoltée. Et si on te disait que maintenant, tu pouvais parier sur les résultats et devenir le roi du judo sans poser un pied sur le tatami ?

Bienvenue sur la plateforme de jeu officielle de la JPL. C’est gratuit, c’est fun, c’est stratégique (parfois), et surtout… c’est fait pour claquer des pronos entre potes (ou pas).
    </p>
<p>
👉 Pas besoin d'être expert en paris sportifs : ici, tout le monde a sa chance.
</p>
    <p>
👉 Pas d'argent en jeu : uniquement des points, du skill, de la gloire et, pour les meilleurs, des cadeaux très stylés !
    </p>

    </div>

     <div class="container-list">
     <h3>Le fonctionnement</h3>
     <br>
<!-- Slider -->
<div class="swiper mySwiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <img src="/wp-content/uploads/2025/08/Home page.png" alt="Image 1">
      <div class="caption">Home page : après la création de mon compte, j’accède à mon tableau de bord</div>
    </div>
    <div class="swiper-slide">
      <img src="/wp-content/uploads/2025/08/Mes paris (1).png" alt="Image 2">
      <div class="caption">Mes pronos : Je place mes pronos et mes bonus. Tout à l’avance ou au jour le jour, chacun sa stratégie ! </div>
    </div>
    <div class="swiper-slide">
      <img src="/wp-content/uploads/2025/08/lose.png" alt="Image 3">
      <div class="caption">lose : Je peux consulter mes pronos gagnés ou perdus</div>
    </div>
    <div class="swiper-slide">
      <img src="/wp-content/uploads/2025/08/Classement G-1.png" alt="Image 4">
      <div class="caption">Classement G : Je découvre mon classement après chaque rencontre de JPL. Objectif : la win !</div>
    </div>
  </div>

  <!-- Dots -->
  <div class="swiper-pagination"></div>
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Init -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4,   // 4 colonnes visibles
    spaceBetween: 20,   // espace entre colonnes
    slidesPerGroup: 1,  // slide par colonne
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    breakpoints: {
      0: {
                   slidesPerView: 1.5,
                   centeredSlides: false,
      },
      640: { slidesPerView: 2 },
      1024: { slidesPerView: 4 }
    }
  });
</script>


     
    </div>

   <div class="container-list">
    <h3> 👊 Le concept est simple : tu paries, tu marques des points, tu deviens une légende.</h3>
    <p>À chaque rencontre de la JPL, tu peux :</p>
    <ul style="list-style: disc;">
        <li>Prédire le vainqueur ➜ +10 points</li>
        <li>Trouver le score exact ➜ +20 points</li>
    </ul>
    
    <div class="game-tips">
        <h4><i class="fa-solid fa-circle-info"></i> Exemple simple :</h4>
<img src="/wp-content/uploads/2025/08/BETWINNER.png" alt="Image 4"  style="border-radius: 8px;width: 400px;">
    </div>
   </div>

<div class="container-list">
<ul style="list-style: disc;">
<li>Enchainer les paris gagnants :
Attention, ça rigole pas (enfin si, mais tu vois l’idée) : plus tu enchaînes les bons paris, plus tu marques.</li>
</ul><br>
<p>Si ta série de bons paris consécutifs atteint ces paliers, c’est jackpot :</p>

<p>🎯 3 bons pronos ➜ Score de ton 3e pari x3</p>
<p>💪 6 bons pronos ➜ Score de ton 6e pari x6</p>
<p>🔥 9 bons pronos ➜ Score de ton 9e pari x9</p>
<p>🤯 12 bons pronos ➜ Score de ton 12e pari x12</p>
<p>🐐 15 bons pronos ➜ Score de ton 15e pari x15</p>
<br>
<div class="game-tips">
    <h4><i class="fa-solid fa-circle-info"></i> Exemple simple :</h4>
Jean-Charles vient d’aligner 3 bons résultats. Sur le 3e, il donne le vainqueur, mais pas le score exact ➜ il marque 10 pts et multiplie son total x3 (parce que 3 bons pronos de suite) = 30 pts.
</div>
</div>


<div class="container-list">
<p>⚠️ Tu as manqué un prono (ou oublié de parier) ? Loser. La série s’arrête. Fini les multiplicateurs. Reviens au dojo.</p>
</div>

<div class="container-list">
 <h3> 🔥 3 façons de jouer, 3 façons de briller</h3>
<br>

<div class="flx-presnt">
<div> <img src="/wp-content/uploads/2025/09/BOSS_DU_CLAN.png" /></div>
<div>
<h4>Le boss du clan</h4>
<p style="text-align: left !important;"> Crée ta ligue privée avec tes amis, collègues ou senseïs. Affrontez-vous dans un classement pour la gloire pendant toute la saison. Qui sera le roi du dojo ? Spoiler : pas Jean-Charles.
</p>
</div>
</div>
<br>
<div class="flx-presnt order">
<div>
<h4>Les maîtres du game</h4>
<p style="text-align: left !important;"> Chaque joueur intègre aussi le classement général. Et là, c’est sérieux. À la fin de la saison, les 5 meilleurs joueurs recevront des cadeaux légendaires. On parle pas d’un mug ici.
</p>
</div>
<div> <img src="/wp-content/uploads/2025/09/MAITRE_DU_MONDE.png" /></div>
</div>
<br>
<div class="flx-presnt">
<div> <img src="/wp-content/uploads/2025/09/CHAMPIONS_SEMAINE.png" /></div>
<div>
<h4>Les champions de la semaine</h4>
<p style="text-align: left !important;"> Chaque semaine, les 3 meilleurs scores seront récompensés : des lots + un tirage au sort pour remporter un gros cadeau surprise. Ton moment de briller, c’est peut-être ce week-end.
</p>
</div>
</div>


</div>


<div class="container-list">
<h3> 🎯 Les bonus : ton arme secrète</h3>
<br>
<p>Tu veux dominer la ligue comme Teddy Riner domine un tatami ? Active tes bonus stratégiquement ! Bien jouer tes bonus au bon moment, c'est souvent la clé pour grimper dans le classement.</p>
<ul style="list-style: disc;">
    <li>🎯 Bonus x2 : Tu doubles tes points sur une rencontre.</li>
    <li>⚡ x3 Banco by <img class="banco-3" src="/wp-content/uploads/2025/09/Crédit agricole.png"> : Tu les triples. Oui, ça commence à piquer.</li>
    <li>🃏 Le Joker : T’hésites sur un match alors que t’es sur une grosse série ? Joue ton joker. Si tu te plantes, tu marques rien,… mais ta série continue. Ninja move.</li>
</ul>

<p>⚠️ Attention, un bonus n’est utilisable qu’en amont de la rencontre sur laquelle tu souhaites le jouer Après le début de la rencontre, il sera trop tard ! An-ti-ci-pa-tion</p>

</div>

<div class="container-list">
<h2>🚨 Alors, prêt à montrer que tu connais le judo comme ta poche ?</h2>
<p>Crée ton compte, commence à parier et entre dans la légende de la JPL. Et surtout, n’oublie pas de parier. Jean-Charles a encore oublié la 4e journée et il en pleure encore.
<br>
📲 À toi de jouer.<br>
La JPL n’attend que tes pronos.</p>

</div>

<div class="container-list">
<h2>Les cadeaux :</h2><br>
<p>
<b>Classement général</b><br>
1. Rencontre avec des athlètes de l’EDF Judo<br>
2. 2 places VIP pour le PGS 2027<br>
3. 150€ de bon d’achat sur la boutique France Judo
<br><br>
<b>Champions de la semaine :</b>
<br>
1er : 50€ de bon d’achat boutique<br>
2e : 30€ de bon d’achat boutique<br>
3e : 20€ de bon d’achat boutique<br>
<br><br>
Tirage au sort parmi les champions de la semaine :<br>
2 places pour la PGS 2026 + visite VIP de la salle d’échauffement
</p>

</div>


<!-- <div class="game-help-1">
<p style="margin-bottom:0px;"> 👉 Bien jouer tes bonus au bon moment, c'est souvent la clé pour grimper  dans le classement.</p>
 </div>-->
 




</div>


</div>
</div>
    
    
    
    </section>



    <style>
img.banco-3 {
    width: 20px;
}
.flx-presnt{
    display: flex;
    flex-direction: row;
    gap: 20px;
    justify-content: center;
    align-items: center;}
.flx-presnt img { width: 130px;border-radius: 50%;}
      .regles-pari h2, .regles-pari h3, .regles-pari p{text-align:center;}
.container-list {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
      .consent-title{
        margin-top:10px;
        text-align:center;
      }
      .consent-txt{
        margin-top:20px;
      }
      .connexion-parieur .popup-content{
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 500px;
        max-height: 80vh;
        overflow-y: auto;
        border-radius: 10px;
        z-index: 9999;
      }
      .checkboxes .label{
        font-size:12px;
      }
      .required{
        color:red !important;
      }

@media screen and (max-width: 600px) {
    .flx-presnt {align-items: center;flex-direction: column;}
.flx-presnt.order div:first-child{order:2;}
}
    




      </style>
     
     <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
       
            
    <script>
        jQuery(document).ready(function($) {

        });
    </script>
    <?php
get_footer();
?>

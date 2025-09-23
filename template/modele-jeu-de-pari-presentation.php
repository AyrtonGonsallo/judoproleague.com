<?php

/**
 * Template Name: Modèle module de pari (présentation)
 */

if (  is_user_logged_in() && current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/module-de-paris-home/') );
    exit;
}

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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<main id="primary" class="site-main presentn-pari">
    <section class="listes-equipes page-calendrier">
        <div class="">
            <div class="flex-row-center">
                <img src="/wp-content/uploads/2025/09/JUDO PRONOS CHALLENGE.png" width="300" style="margin:auto;" class="sub-header-pari-logo" >
            </div>
            <div class="flex-row-center">
                
            </div>  
        </div>

        <?php if (is_user_logged_in()) : ?>
                    <form id="logoutForm" method="post" style="display:none;">
                        <input type="hidden" name="jpl_auth_action" value="logout">
                    </form>
                    <a href="#" id="logout" class="enter-game-action logoutclass">Se déconnecter</a>
                <?php else : ?>
                    <a href="#" id="openPopup" class="enter-game-action openPopupclass">J'accède à mes pronos</a>
                <?php endif; ?>
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


     
      <?php if (is_user_logged_in()) : ?>
                    <form id="logoutForm" method="post" style="display:none;">
                        <input type="hidden" name="jpl_auth_action" value="logout">
                    </form>
                    <a href="#" id="logout" class="enter-game-action logoutclass">Se déconnecter</a>
                <?php else : ?>
                    <a href="#" id="openPopup" class="enter-game-action openPopupclass">J'accède à mes pronos</a>
                <?php endif; ?>
    </div>

   <div class="container-list">
    <h3> 👊Le concept est simple : tu paries, tu marques des points, tu deviens une légende.</h3>
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
<p> Crée ta ligue privée avec tes amis, collègues ou senseïs. Affrontez-vous dans un classement pour la gloire pendant toute la saison. Qui sera le roi du dojo ? Spoiler : pas Jean-Charles.
</p>
</div>
</div>
<br>
<div class="flx-presnt order">
<div>
<h4>Les maîtres du game</h4>
<p> Chaque joueur intègre aussi le classement général. Et là, c’est sérieux. À la fin de la saison, les 5 meilleurs joueurs recevront des cadeaux légendaires. On parle pas d’un mug ici.
</p>
</div>
<div> <img src="/wp-content/uploads/2025/09/MAITRE_DU_MONDE.png" /></div>
</div>
<br>
<div class="flx-presnt">
<div> <img src="/wp-content/uploads/2025/09/CHAMPIONS_SEMAINE.png" /></div>
<div>
<h4>Les champions de la semaine</h4>
<p> Chaque semaine, les 3 meilleurs scores seront récompensés : des lots + un tirage au sort pour remporter un gros cadeau surprise. Ton moment de briller, c’est peut-être ce week-end.
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
<p>Crée ton compte, commence à parier et entre dans la légende de la JPL.Et surtout, n’oublie pas de parier. Jean-Charles a encore oublié la 4e journée et il en pleure encore.
<br>
📲 À toi de jouer.<br>
La JPL n’attend que tes pronos.</p>

</div>




<!-- <div class="game-help-1">
<p style="margin-bottom:0px;"> 👉 Bien jouer tes bonus au bon moment, c'est souvent la clé pour grimper  dans le classement.</p>
 </div>-->
 



 <?php if (is_user_logged_in()) : ?>
        <form id="logoutForm" method="post" style="display:none;">
            <input type="hidden" name="jpl_auth_action" value="logout">
        </form>
        <a href="#" id="logout" class="enter-game-action logoutclass">Se déconnecter</a>
    <?php else : ?>
        <a href="#" id="openPopup" class="enter-game-action openPopupclass">J'accède à mes pronos</a>
    <?php endif; ?>
</div>

<!--<div class="container-list faq">
    <h3 class="sub-h">FAQ</h3>
    <h4 class="sub-h">Subheading</h4>
    <div class="accordion pink-ac" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Title
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <p> the frequently asked question in a simple sentence, a longish paragraph, or even in a list.</p>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Title
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
       <p> the frequently asked question in a simple sentence, a longish paragraph, or even in a list.</p>
      </div>
    </div>
  </div>
  </div>-->
</div>
</div>
    
    
    
    </section>



 <div class="connexion-parieur">

 <div id="popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <div class="image-popup-mobile-container">
                    <img width="123" height="auto" src="/wp-content/uploads/2025/09/JUDO%20PRONOS%20CHALLENGE.png" class="mobile " alt="Logo Judo Pro League" decoding="async">
                </div>
                
                <!-- Ecran 0 : Choix -->
                <div class="popup-screen" id="screen-choix">
                    <h2>Connexion ou inscription</h2>
                    <button class="btn" id="btn-register">S'inscrire</button>
                    <button class="btn" id="btn-login">Se connecter</button>
                    
                </div>

                <!-- Ecran 1 : Connexion -->
                <div class="popup-screen" id="screen-login">
                    <h2>Connexion</h2>
                    <form id="authLogin" method="post" >
                        <input type="hidden" name="jpl_auth_action" value="login">
                        <label for="email">Email</label>
                        <input type="email"   name="email" placeholder="" class="input">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" placeholder="" class="input">
                        <button class="btn">Se connecter</button>
                        <a href="#" id="btn-forgot">Mot de passe oublié ?</a>
                    </form>
                </div>

                <!-- Ecran 2 : Mot de passe oublié -->
                <div class="popup-screen" id="screen-forgot">
                    <h2>Réinitialiser votre mot de passe</h2>
                    <form id="authForgot" method="post">
                        <input type="hidden" name="jpl_auth_action" value="forgot">
                        <input type="email"  name="email" placeholder="Votre email" class="input">
                        <button type="button" class="btn btn-secondary side" id="btn-cancel-forgot">Annuler</button>
                        <button class="btn side">Réinitialiser</button>
                        
                    </form>
                </div>

                

                <form id="form-register" method="post">
                    <!-- Champ caché pour dire au plugin qu'on fait une inscription -->
                    <input type="hidden" name="jpl_auth_action" value="register">

                    <!-- Ecran 3 : Inscription (partie 1) -->
                    <div class="popup-screen" id="screen-register-step1">
                        <h2>Création de compte</h2>
                        <p class="register-txt">France Judo collecte vos informations pour organiser et gérer votre participation à Judo Pronos Challenge</p>
                        <!-- Ajouts -->
                        <label for="nom">Nom <span class="required">*</span></label>
                        <input type="text" name="nom" placeholder="Nom" class="input" required>

                        <label for="prenom">Prénom <span class="required">*</span></label>
                        <input type="text" name="prenom" placeholder="Prénom" class="input" required>

                        <label for="date_naissance">Date de naissance <span class="required">*</span></label>
                        <input type="date" name="date_naissance" class="input" required  max="<?php echo date('Y-m-d', strtotime('-15 years')); ?>">
                        <label for="pseudo">Pseudo <span class="required">*</span></label>
                        <input type="text" name="pseudo" placeholder="Pseudo" class="input" required>
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" name="email" placeholder="Email" class="input" required>
                        <label for="password">Mot de passe <span class="required">*</span></label>
                        <input type="password" name="password" placeholder="Mot de passe" class="input" required>
                        <label for="password2">Répéter le mot de passe <span class="required">*</span></label>
                        <input type="password" name="password2" placeholder="Répéter mot de passe" class="input" required>
                        
                        <b class="consent-title">Enregistrer ma participation</b>
                        <p class="consent-text">Vous consentez aux utilisations de vos données personnelles par l’envoi de ce formulaire de participation complété.</p>

                         <div class="checkboxes">
                            <label><input type="checkbox" name="consentement_utilisation_de_donnees" required> Vous attestez avoir pris connaissance des <a href="https://judoproleague.com/protection-des-donnees/" target="_blank">informations sur les utilisations de vos données par France Judo</a><span class="required">*</span></label>

                            <label><input type="checkbox" name="newsletter"> Vous consentez à recevoir la newsletter de France Judo</label>
                            <label><input type="checkbox" name="offres"> Vous consentez à recevoir les offres commerciales de nos partenaires</label>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6Lcnns4rAAAAAPXxMUjylqA_RH1Tww37puyoI8Db"></div>
                        <button class="btn" id="btn-register-next">Suivant</button>
                    </div>

                    <!-- Ecran 4 : Inscription (partie 2) -->
                    <div class="popup-screen" id="screen-register-step2">
                        <h2>Choisie une équipe</h2>
                        <span>Sélectionne ton équipe favorite pour améliorer ton expérience.</span>
                        <input type="text" id="search-team" placeholder="Rechercher une équipe..." class="input">
                        <!-- Select custom -->
                        <div id="team-select-custom" class="custom-select">
                            <ul>
                                <?php foreach ($equipes as $equipe):
                                    $id = $equipe->ID;
                                    $logo = (get_field('logo_circle', $id)) ? get_field('logo_circle', $id) : get_the_post_thumbnail_url($id);
                                    $title = get_the_title($id);
                                ?>
                                <li data-value="<?php echo $id; ?>" class="equipe-fav">
                                    <img src="<?php echo $logo; ?>" width="30" style="vertical-align:middle; margin-right:8px;">
                                    <?php echo $title; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <input type="hidden" name="team_id" id="team_id">
                        </div>

                        <button class="btn" id="btn-register-submit">Terminer</button>
                    </div>
                    

                </form>

                <div class="popup-screen" id="error_messages">
                    <span id="failure" class="message-echec"></span>
                </div>
                <div class="popup-screen" id="success_messages">
                    <span id="success" class="message-succes"></span>
                </div>

            </div>
            
            
    </div> 
</div> 

    <style>
      .consent-title{
        margin-top:10px;
        text-align:center;
      }
      .consent-txt{
        margin-top:20px;
      }
      
      .checkboxes .label{
        font-size:12px;
      }
      .required{
        color:red !important;
      }
      </style>
     
     <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
       <script src="https://www.google.com/recaptcha/api.js" async defer></script>

            
             <script>
    jQuery(document).ready(function($) {

       const urlParams = new URLSearchParams(window.location.search);

if (urlParams.get('forgot_status') === 'sent') {
    // succès
    $("#success").text("✅ Vous allez recevoir un email pour réinitialiser votre mot de passe.");
    $("#success_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");

} else if (urlParams.get('vstatus') === 'validation_succeed') {
    // succès
    $("#success").text("✅ Votre email a été validé ! Vous pouvez maintenant vous connecter.");
    $("#success_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");

}else if (urlParams.get('vstatus') === 'validation_failled') {
    // identifiant existe déjà
    $("#failure").text("❌ Lien de validation invalide ou expiré. !");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");

}
else if (urlParams.get('error') === 'insc') {
    // identifiant existe déjà
    $("#failure").text("❌ Désolé, cet identifiant existe déjà !");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");

} else if (urlParams.get('error') === 'pass_match') {
    // mots de passe différents
    $("#failure").text("⚠️ Les mots de passe ne correspondent pas.");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");
}
else if (urlParams.get('error') === 'consent') {
    // consentement est obligatoire
    $("#failure").text("⚠️ Le consentement est obligatoire.");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");
}
else if (urlParams.get('error') === 'no_email') {
    // Utilisateur inexistant
    $("#failure").text("⚠️ Utilisateur inexistant.");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");
}
else if (urlParams.get('error') === 'no_verified') {
    // Utilisateur inexistant
    $("#failure").text("⚠️ Compte non validé.");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");
}
else if (urlParams.get('error') === 'created_and_no_verified') {
    // Utilisateur inexistant
    $("#failure").text("⚠️ Compte crée mais non validé.");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");
}
 else if (urlParams.get('error') === 'conn') {
    // Email ou identifiant invalide
    let countdown = 4;
    $("#failure").text("❌ Email ou identifiant invalide. Réessayez dans " + countdown + "s.");
    $("#error_messages").addClass("active");
    history.replaceState(null, '', window.location.pathname);
    $("#popup").css("display","flex");

    let interval = setInterval(() => {
        countdown--;
        if (countdown > 0) {
            $("#failure").text("❌ Email ou identifiant invalide. Réessayez dans " + countdown + "s.");
        } else {
            clearInterval(interval);
            $(".popup-screen").removeClass("active");
            $("#screen-login").addClass("active");
        }
    }, 1000);

        
}
        
        $(".logoutclass").on("click", function(e) {
            e.preventDefault();
            $("#logoutForm").submit();
            
        });
        $("#logout_mob").on("click", function(e) {
            e.preventDefault();
            $("#logoutForm_mob").submit();
            
        });

        // Step2 caché au départ
    $("#screen-register-step2").hide();

    // Bouton Suivant (Step1 → Step2)
    $("#btn-register-next").on("click", function(e) {
        e.preventDefault();

        var $step1 = $("#screen-register-step1");
        var pseudo = $step1.find("input[name='pseudo']").val().trim();
        var email = $step1.find("input[name='email']").val().trim();
        var password = $step1.find("input[name='password']").val();
        var password2 = $step1.find("input[name='password2']").val();
        var nom = $step1.find("input[name='nom']").val().trim();
        var prenom = $step1.find("input[name='prenom']").val().trim();
        var naissance = $step1.find("input[name='date_naissance']").val().trim();
        var consent = $step1.find("input[name='consentement_utilisation_de_donnees']").is(":checked");

        let errors = [];

        
        if (!pseudo) {
            errors.push("⚠️ Le champ 'Pseudo' est obligatoire !");
        }
        if (!email) {
            errors.push("⚠️ Le champ 'Email' est obligatoire !");
        }
        if (!password) {
            errors.push("⚠️ Le champ 'Mot de passe' est obligatoire !");
        }
        if (!password2) {
            errors.push("⚠️ Le champ 'Confirmation du mot de passe' est obligatoire !");
        }
        if (!nom) {
            errors.push("⚠️ Le champ 'Nom' est obligatoire !");
        }
        if (!prenom) {
            errors.push("⚠️ Le champ 'Prénom' est obligatoire !");
        }
        if (!naissance) {
            errors.push("⚠️ Le champ 'Date de naissance' est obligatoire !");
        }


        // Mots de passe identiques
        if (password !== password2) {
            errors.push("⚠️ Les mots de passe ne correspondent pas.");
        }

        // Consentement
        if (!consent) {
            errors.push("⚠️ Vous devez accepter l’utilisation de vos données.");
        }
        var captchaResponse = grecaptcha.getResponse();
        if (captchaResponse.length === 0) {
            errors.push("⚠️ Veuillez cocher le captcha !");
           
        }

        // Si déjà des erreurs, afficher et ne pas faire l'AJAX
        if (errors.length > 0) {
            $("#error_messages").html("<ul><li class='message-echec'>" + errors.join("</li><li class='message-echec'>") + "</li></ul>");
            $("#error_messages").addClass("active").css("display","flex");
            $("#popup").css("display","flex");
            history.replaceState(null, '', window.location.pathname);
            return;
        }
        

         

        // Vérification email via AJAX
        if (email) {
            $.post("/wp-admin/admin-ajax.php", {
                action: "check_email_exists",
                email: email,
                pseudo : pseudo
            }, function(response) {
                if (response.email_exists) {
                    errors.push("⚠️ Cet email est déjà utilisé !");
                    $("#error_messages").html("<ul><li class='message-echec'>" + errors.join("</li><li class='message-echec'>") + "</li></ul>");
                    $("#error_messages").addClass("active").css("display","flex");
                    $("#popup").css("display","flex");
                    return;
                }
                if (response.pseudo_exists) {
                    errors.push("⚠️ Ce pseudo est déjà utilisé !");
                    $("#error_messages").html("<ul><li class='message-echec'>" + errors.join("</li><li class='message-echec'>") + "</li></ul>");
                    $("#error_messages").addClass("active").css("display","flex");
                    $("#popup").css("display","flex");
                    return;
                }

                // ✅ Aucun problème, on passe à l'étape 2
                $("#error_messages").removeClass("active").hide();
                $("#screen-register-step1").hide();
                $("#screen-register-step2").show();
            }, "json");
        }
    });


  // Sélection d'une équipe
    $("#team-select-custom li").on("click", function() {
        $("#team_id").val($(this).data("value"));
        $("#team-select-custom li").removeClass("selected");
        $(this).addClass("selected");
    });

    // Recherche
    $("#search-team").on("input", function() {
        var val = $(this).val().toLowerCase();
        $("#team-select-custom li").each(function() {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(val) > -1);
        });
    });

    // Soumission finale du formulaire (Step2)
$("#btn-register-submit").on("click", function(e) {
    var team = $("#team_id").val(); // récupère la valeur du select custom
    if (!team) {
        //alert("Veuillez choisir une équipe !");
        $("#error_messages").html("<ul><li class='message-echec'>⚠️ Veuillez choisir une équipe !</li></ul>");
        $("#error_messages").addClass("active").css("display","flex");
        $("#popup").css("display","flex");
        e.preventDefault();
        return;
    }

    // Le formulaire envoie maintenant pseudo, email, password, password2 et team_id
    $("#form-register").submit();
});
        
    });

$(function(){
    // Ouvrir popup
    $(".openPopupclass").click(function(e){
        e.preventDefault();
        $("#popup").css("display","flex");
        $(".popup-screen").removeClass("active");
        $("#screen-choix").addClass("active");
    });
    $("#openPopup_mob").click(function(e){
        e.preventDefault();
        $("#popup").css("display","flex");
        $(".popup-screen").removeClass("active");
        $("#screen-choix").addClass("active");
    });

    // Fermer popup
    $(".close-btn").click(function(){
        $("#popup").hide();
        $("#screen-register-step1").hide();
    });

    // Navigation entre écrans
    $("#btn-login").click(function(){
        $(".popup-screen").removeClass("active");
        $("#screen-login").addClass("active");
    });

    $("#btn-forgot").click(function(){
        $(".popup-screen").removeClass("active");
        $("#screen-forgot").addClass("active");
    });

    $("#btn-cancel-forgot").click(function(e){
         e.preventDefault(); // empêche la soumission
        $(".popup-screen").removeClass("active");
        $("#screen-choix").addClass("active");
    });

    $("#btn-register").click(function(){
        $(".popup-screen").removeClass("active");
        $("#screen-register-step1").show();
        $("#screen-register-step1").addClass("active");
    });

    $("#btn-register-next").click(function(){
        $(".popup-screen").removeClass("active");
        $("#screen-register-step2").addClass("active");
    });

    // Recherche équipes
    $("#search-team").on("keyup", function(){
        var value = $(this).val().toLowerCase();
        $("#team-select option").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
    </script>
    <?php
get_footer();
?>

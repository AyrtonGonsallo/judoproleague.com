<?php

/**
 * Template Name: Modèle module de pari (S'inscrire ou se connecter et rejoindre une ligue)
 */




get_header();


$ligue_id = $_GET["ligueID"];

if (  is_user_logged_in() && current_user_can('joueur_jpl') ) {
    $flag_possede_compte_joueur=1;
}else{
    $flag_possede_compte_joueur=0;
}

?>


<div class="header-paris-mobile">
    <div class="header-box">
         <div class="header-box">
            <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>
        </div>
    </div>
</div>
<main id="primary" class="site-main ">
    <section class="listes-equipes page-calendrier">

     

    
        <h3>Rejoindre la ligue privée <?php echo get_the_title($ligue_id);?></h3>
       
        <?php if($flag_possede_compte_joueur==1): 
            $user_id = get_current_user_id();
            $user = wp_get_current_user();
            $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
            $prenom = get_user_meta($user_id, 'first_name', true);
            $nom = get_user_meta($user_id, 'last_name', true);
            $parieur_id=$user_id;
            $parieur_user = get_userdata($parieur_id);
            // Mettre à jour les participants
            $participants = get_field('participants', $ligue_id) ?: [];
            if (!in_array($parieur_id, $participants)) {
                $participants[] = $parieur_id;
                update_field('participants', $participants, $ligue_id);
                // Définir status et messages selon action
                
                $mail_sujet = "Bienvenue dans la ligue " . get_the_title($ligue_id);

                $mail_body  = "
                    <p>Bonne nouvelle ! Ta demande d’accès à la ligue <strong>" . get_the_title($ligue_id) . "</strong> vient d’être validée.</p>
                    <p>Tu peux dès maintenant rejoindre tes coéquipiers et faire tes pronos.</p>
                    <p>
                        <a href='" . get_the_permalink($ligue_id) . "' 
                        style='background:#0073aa;color:#fff;padding:10px 15px;text-decoration:none;border-radius:5px;'>
                        Accéder à ma ligue
                        </a>
                    </p>
                ";

                $body = '
                    <div style="font-family:Arial,sans-serif; font-size:14px; color:#333;">
                        <p>Salut ' . esc_html($prenom) . ',</p>
                        
                        ' . $mail_body . '

                        <p>Bonne chance, et que le meilleur judoka des pronos l’emporte !</p>
                        <p>— L’équipe Judo Pronos Challenge</p>
                        
                        <p>
                            <img src="https://judoproleague.com/wp-content/uploads/2023/07/logo-jpl.png" 
                                alt="Logo Judo Pro League" 
                                style="max-width:150px; margin-top:10px;" />
                        </p>
                    </div>';


                    // Avant d'envoyer le mail
                add_filter( 'wp_mail_from', function( $email ) {
                    return 'contact@judoproleague.com';
                });
                add_filter( 'wp_mail_from_name', function( $name ) {
                    return 'Judo Pro League';
                });
                add_filter('wp_mail_content_type', function() { return 'text/html'; });
                // Envoi du mail
                if ($parieur_user) {
                    wp_mail($parieur_user->user_email, $mail_sujet, $body);
                }

                echo "Vous êtes désormais membre de la ligue privée <a href='" . get_the_permalink($ligue_id) . "'>".get_the_title($ligue_id)."</a>";
        

            }else{
                echo "Vous étiez déja membre de la ligue privée <a href='" . get_the_permalink($ligue_id) . "'>".get_the_title($ligue_id)."</a>";

            }

             ?>
                
        <?php endif; ?>
        <?php if($flag_possede_compte_joueur==0): ?>
            Tu n'est pas connecté en tant que joueur
            <a href="#" id="openPopup" class="enter-game-action openPopupclass">S'inscire / Se connecter</a>
                <script>
                jQuery(document).ready(function($){
                    // Ouvre le popup automatiquement
                    $("#popup").css("display","flex");
                    $(".popup-screen").removeClass("active");
                    $("#screen-choix").addClass("active");
                });
                </script>
        <?php endif; ?>


       
    </section>

    <?php
        get_footer();
    ?>



 <div class="connexion-parieur">

 <div id="popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <div class="image-popup-mobile-container">
                    <img width="123" height="auto" src="/wp-content/uploads/2022/10/JPL-LOGO-light.webp" class="mobile " alt="Logo Judo Pro League" decoding="async">
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

} else if (urlParams.get('error') === 'insc') {
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

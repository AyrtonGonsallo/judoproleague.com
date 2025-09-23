<?php

/**
 * Template Name: Modèle module de pari (profil)
 */

// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}
 $user_id = get_current_user_id();
$user = wp_get_current_user();
$pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
$prenom = get_user_meta($user_id, 'first_name', true);
$nom = get_user_meta($user_id, 'last_name', true);
$equipe_user_id  = get_field('equipe', 'user_'.$user_id);
$points = get_field('total_de_points', 'user_'.$user_id) ?: 0;
$serie = get_field('serie_en_cours', 'user_'.$user_id) ?: 0;
$meilleure_serie = (int) get_field('meilleure_serie', 'user_' . $user_id);
$email =  $user->user_email;


get_header();


$messages = [];

// ---- FORMULAIRE CHANGEMENT DE MOT DE PASSE ----
if(isset($_POST['action']) && $_POST['action'] === 'change_password'){
    $current_pass = $_POST['current_password'] ?? '';
    $new_pass     = $_POST['new_password'] ?? '';
    $new_pass_rep = $_POST['new_password_repeat'] ?? '';

    // Vérifier ancien mot de passe
    if(!wp_check_password($current_pass, $user->user_pass, $user->ID)){
        $toast_message = "❌ Mot de passe actuel incorrect";
    } elseif($new_pass !== $new_pass_rep){
        $toast_message = "❌ Les nouveaux mots de passe ne correspondent pas";
    } elseif(strlen($new_pass) < 6){
        $toast_message = "❌ Le mot de passe doit faire au moins 6 caractères";
    } else {
        wp_set_password($new_pass, $user->ID);
        $toast_message = "✅ Mot de passe modifié avec succès !";
    }
}

// ---- FORMULAIRE CHANGEMENT EMAIL ----
if(isset($_POST['action']) && $_POST['action'] === 'change_email'){
    $new_email     = $_POST['new_email'] ?? '';
    $new_email_rep = $_POST['new_email_repeat'] ?? '';
    $password      = $_POST['password'] ?? '';

    // Vérifier le mot de passe
    if(!wp_check_password($password, $user->user_pass, $user->ID)){
        $toast_message = "❌ Mot de passe incorrect";
    } elseif($new_email !== $new_email_rep){
        $toast_message = "❌ Les emails ne correspondent pas";
    } elseif(!is_email($new_email)){
        $toast_message = "❌ Email invalide";
    } else {
        wp_update_user([
            'ID' => $user->ID,
            'user_email' => $new_email
        ]);
        $toast_message = "✅ Email modifié avec succès !";
        $email =  $new_email;
    }
}

// Soumission du formulaire sélection d'équipe
if(isset($_POST['action']) && $_POST['action'] === 'update_team'){
    $team_id = intval($_POST['team_id'] ?? 0);

    if($team_id <= 0){
        $toast_message = "❌ Veuillez sélectionner une équipe valide.";
    } else {
        update_field('field_equipe', $team_id, 'user_' . $user_id);
        $toast_message = "✅ Votre équipe a été mise à jour !";
        $equipe_user_id = $team_id; // Pour garder le select correct
    }
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
    </div>

     <?php
       

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

            
        <!--<div class="flex-3-pari2" style="margin-bottom:4%;">
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
                <a href="/module-de-paris-classement">
                    <img src="/wp-content/uploads/2025/09/medals.webp" width="30" class="menu-icon">
                    <span>Mon classement</span>
                </a>
            </div> 
        </div>-->
    
<div class="profil">
    
        <h3 class="name-prfl"> <?php echo $pseudo;?> </h3>
        <p><strong>Email :</strong> <?php echo ($email); ?></p>
        <p><strong>Série en cours :</strong> <span><?php echo intval($meilleure_serie); ?></span></p>
        <p><strong>Points :</strong> <span><?php echo intval($points); ?></span></p>
        <p>
           <form id="team-form" method="post">
                <input type="hidden" name="action" value="update_team">
                <label>Équipe favorite :</label><br>
                <select name="team_id" id="team_id" required>
                    <option value="">-- Sélectionne une équipe --</option>
                    <?php foreach ($equipes as $equipe):
                        $id = $equipe->ID;
                        $title = get_the_title($id);
                        $selected = ($id == $equipe_user_id) ? 'selected' : '';
                    ?>
                    <option value="<?php echo esc_attr($id); ?>" <?php echo $selected; ?>>
                        <?php echo esc_html($title); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </form>


        </p>

        <a href="#" id="openChangeMail" class="enter-game-action">Changer email</a>

        <a href="#" id="openChangePassword" class="enter-game-action">Changer le mot de passe</a>

        <a href="/module-de-paris-paris/"  class="enter-game-action">Place un pari maintenant</a>

        <?php if(!empty($messages)): ?>
        <div class="messages">
            <?php foreach($messages as $msg): ?>
                <p><?php echo esc_html($msg); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

            </div>
    </section>

    <?php
get_footer();
?>

<div class="footer-menu-mobile-paris mobile">
    <div>
        <div class="flex-4-footer">
           
           <div class="sub-menu-element ">
                <a href="/module-de-paris-home/" class="vertical">
                    <img src="/wp-content/uploads/2025/09/home.webp" width="30" class="menu-img">
                    <span>Accueil</span>
                </a>
            </div>
            <div class="sub-menu-element ">
                <a href="/module-de-paris-paris/" class="vertical">
                    
                    <img src="/wp-content/uploads/2025/09/classer.webp" width="30" class="menu-img">
                    <span>Mes pronos</span>
                </a>
            </div> 
            <div class="sub-menu-element ">
                <a href="/module-de-paris-ligues" class="vertical">
                    <img src="/wp-content/uploads/2025/09/users.webp" width="30" class="menu-img">
                    <span>Mes ligues</span>
                </a>
            </div>
            <div class="sub-menu-element ">
                <a href="/module-de-paris-classement" class="vertical">
                    <img src="/wp-content/uploads/2025/09/medals.webp" width="30" class="menu-img">
                    <div class="champ2"><span>Classement</span></div>
                </a>
            </div>
        </div>
    </div>
</div>



 <div class="connexion-parieur">
    <div id="popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                
               

                <!-- Ecran 1 : Connexion -->
                <div class="popup-screen" id="screen-change-pass">
                    <h2>Modification du mot de passe</h2>
                    <form id="resset_password" method="post">
                        <input type="hidden" name="action" value="change_password">
                        <label for="current_password">Mot de passe actuel</label>
                        <div class="password-wrapper">
                            <input type="password" name="current_password" placeholder="" class="input">
                            <span class="toggle-password"><i class="fa fa-eye"></i></span>
                        </div>
                        <label for="new_password">Nouveau mot de passe</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password" placeholder="" class="input">
                         <span class="toggle-password"><i class="fa fa-eye"></i></span>
                        </div>
                        <label for="new_password_repeat">Répeter le mot de passe</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password_repeat" placeholder="" class="input">
                            <span class="toggle-password"><i class="fa fa-eye"></i></span>
                        </div>
                        <button class="btn"  type="submit">Réinitialiser le mot de passe</button>
                        <a href="#" class="btn-cancel">Annuler</a>
                    </form>
                </div>


                <div class="popup-screen" id="screen-change-login">
                    <h2>Modification du login</h2>
                    <form id="resset_login" method="post">
                        <input type="hidden" name="action" value="change_email">
                        <label for="new_email">nouvel Email</label>
                        <input type="email"   name="new_email" placeholder="" class="input">
                        <label for="new_email_repeat">Répeter le nouvel email</label>
                        <input type="email"   name="new_email_repeat" placeholder="" class="input">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" placeholder="" class="input">
                        <button class="btn"  type="submit">Réinitialiser l'email</button>
                        <a href="#" class="btn-cancel">Annuler</a>
                    </form>
                </div>


            </div>
            
            
    </div> 
</div> 




<?php if ( $toast_message ): ?>
<script>
jQuery(document).ready(function($){
    // Création du toast
    let $toast = $('<div class="custom-toast"></div>').text("<?php echo esc_js($toast_message); ?>");
    $("body").append($toast);

    // Animation
    $toast.fadeIn(400).delay(3000).fadeOut(600, function(){
        $(this).remove();
    });
});
</script>
<style>
.custom-toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #222;
    color: #fff;
    padding: 12px 20px;
    border-radius: 6px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    font-size: 14px;
    display: none;
    z-index: 9999;
}
</style>
<?php endif; ?>
<style>
    .password-wrapper {
        position: relative;
    }
    .messages p { color: red; }
.connexion-parieur i {
    color: #000000ff;
    font-size: 23px;
}
    .password-wrapper .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function($) {
       
        $(".toggle-password").click(function(){
    let input = $(this).siblings("input");
    if(input.attr("type") === "password"){
        input.attr("type", "text");
        $(this).html('<i class="fa fa-eye-slash"></i>'); // utilise .html() au lieu de .text()
    } else {
        input.attr("type", "password");
        $(this).html('<i class="fa fa-eye"></i>');
    }
});

        $("#openChangePassword").click(function(){
            console.log("click")
            $("#popup").css("display","flex");
            $(".popup-screen").removeClass("active");
            $("#screen-change-pass").addClass("active");
        });

        $("#openChangeMail").click(function(){
            console.log("click")
            $("#popup").css("display","flex");
            $(".popup-screen").removeClass("active");
            $("#screen-change-login").addClass("active");
        });

        // Fermer popup
        $(".close-btn").click(function(){
            $("#popup").hide();
        });


        $(".btn-cancel").click(function(){
            $("#popup").hide();
        });

        jQuery(document).ready(function($){
            $("#team_id").change(function(){
                $("#team-form").submit();
            });
        });

    });
</script>

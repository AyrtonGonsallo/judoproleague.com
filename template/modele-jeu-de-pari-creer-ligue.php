<?php

/**
 * Template Name: Modèle module de pari (creer une ligue)
 */


// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}


get_header();


    if (isset($_POST['action']) && $_POST['action'] === 'creer_ligue_par_page' && wp_verify_nonce($_POST['ligue_nonce'], 'creer_ligue_par_page_nonce')) {
        $user_id = get_current_user_id();
        $post_id = wp_insert_post([
            'post_type' => 'ligue',
            'post_title' => sanitize_text_field($_POST['ligue_nom']),
            'post_content' => sanitize_textarea_field($_POST['ligue_nom']),
            'post_status' => 'publish',
        ]);
        if ($post_id) {
            update_field('nom', sanitize_text_field($_POST['ligue_nom']), $post_id);
            update_field('status', ($_POST['ligue_status']), $post_id);
            update_field('createur', $user_id, $post_id);
            // ✅ Passer un flag de succès
            echo "<script>window.ligueCreated = true;</script>";
            

        }
    }
?>


<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <a href="/module-de-paris-ligues/">Mes ligues</a> > <?php echo get_the_title();?>
    </div>
</div>
<main id="primary" class="site-main cree-ligue">
    <section class="listes-equipes page-calendrier">
        <?
        $user_id = get_current_user_id();
        $user = wp_get_current_user();

        $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
        $prenom = get_user_meta($user_id, 'first_name', true);
        $nom = get_user_meta($user_id, 'last_name', true);
        $avatar_id = get_field('avatar', 'user_'.$user_id);
        $avatar_url = ($avatar_id)?$avatar_id:"/wp-content/uploads/2025/08/user-icon.png";
        ?>


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


</div>

                <div id="form-creer-ligue" >
<h3 class="fs-h3">Création d'une ligue</h3>
<br>
                    <form method="post" enctype="multipart/form-data" class="pari-form">
                        <div class="col-2-form">
                            <label for="ligue_nom">Nom de la ligue</label>
                            <input type="text" name="ligue_nom" required placeholder="ligue">
                        </div>
                        <div class="col-2-form">
                            <div>
                                <label for="ligue_status">
                                    Ligue privée<br>
                                    <span class="info-bulle unchecked">
                                        Votre ligue est publique et accessible à tous les utilisateurs depuis la rubrique "rejoindre une ligue". Vous aurez la possibilité d'accepter ou refuser les demandes des utilisateurs pour rejoindre votre ligue.
                                    </span>
                                    <span class="info-bulle checked">
                                        Votre ligue est privée et accessible uniquement sur votre invitation (via le lien "Partager ma ligue"). 
                                    </span>

                                </label>
                            </div>
                            <div>
                                <div class="toggle-wrap">
                                <!-- champ caché envoyé au serveur (valeur synchronisée par JS) -->
                                <input type="hidden" name="ligue_status" id="ligue_status_hidden" value="ouvert">

                                <!-- switch -->
                                <label class="switch" aria-label="Statut de la ligue">
                                    <input type="checkbox" id="ligue_status_toggle">
                                    <span class="slider"></span>
                                </label>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="action" value="creer_ligue_par_page">
                        <?php wp_nonce_field('creer_ligue_par_page_nonce', 'ligue_nonce'); ?>
                        <button type="submit">Créer la ligue</button>
                    </form>
                </div>
           

<div id="toast" class="toast">✅ Ligue créée avec succès !</div>



                
       

       
        <style>
            /* --- Toast notification --- */
.toast {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #28a745;
  color: #fff;
  text-align: center;
  border-radius: 4px;
  padding: 12px;
  position: fixed;
  z-index: 9999;
  left: 50%;
  bottom: 30px;
  font-size: 16px;
  opacity: 0;
  transition: opacity 0.5s, bottom 0.5s;
}
.toast.show {
  visibility: visible;
  opacity: 1;
  bottom: 50px;
}

            /* --- Toggle Switch --- */
            .toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-top: 8px;
            }

            .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
            cursor: pointer;
            }

            /* cacher la checkbox */
            .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
            }

            /* fond du switch */
            .slider {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc;
            border-radius: 34px;
            transition: background-color 0.3s;
            }

            /* bouton du switch */
            .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            top: 3px;
            background-color: #fff;
            border-radius: 50%;
            transition: transform 0.3s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            }

            /* état activé (ouvert) */
            .switch input:checked + .slider {
            background-color: #1724f6
            }
            .switch input:checked + .slider:before {
            transform: translateX(22px);
            }

            /* focus accessible */
            .switch input:focus + .slider {
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
            }
            .info-bulle{
                color:#757575;
                font-size:12px;
            }

        
        </style>
       
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
        <script>
            jQuery(document).ready(function($){
            
                const $toggle = $("#ligue_status_toggle");
                const $hidden = $("#ligue_status_hidden");
                const $msgChecked = $(".info-bulle.checked");
                const $msgUnchecked = $(".info-bulle.unchecked");
                $msgChecked.hide();
                $msgUnchecked.hide();

                function updateStatus() {
                    if ($toggle.is(":checked")) {
                        $hidden.val("ferme");
                        $msgChecked.show();
                        $msgUnchecked.hide();
                    } else {
                        $hidden.val("ouvert");
                        $msgChecked.hide();
                        $msgUnchecked.show();
                    }
                }

                // init au chargement
                updateStatus();

                // au changement
                $toggle.on("change", updateStatus);


                 if (window.ligueCreated) {
                    const $toast = $("#toast");
                    $toast.addClass("show");

                    // cacher après 2.5s
                    setTimeout(() => {
                    $toast.removeClass("show");
                    // redirection différée
                    window.location.href = "/module-de-paris-ligues/"; 
                    }, 2500);
                }


            });
        </script>




    


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

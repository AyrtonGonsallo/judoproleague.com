<?php

/**
 * Template Name: Modèle module de pari (home)
 */

// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}


get_header();

?>

<main id="primary" class="site-main typo">
    <section class="listes-equipes page-calendrier home">
        <?
        $user_id = get_current_user_id();
        $user = wp_get_current_user();

        $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
        $prenom = get_user_meta($user_id, 'first_name', true);
        $nom = get_user_meta($user_id, 'last_name', true);
        $avatar_id = get_field('avatar', 'user_'.$user_id);
        $avatar_url = ($avatar_id)?$avatar_id:"/wp-content/uploads/2025/08/user-icon.png";
        $serie_en_cours_id = (int) get_field('serie_en_cours', 'user_' . $user_id);
        $meilleure_serie = (int) get_field('meilleure_serie', 'user_' . $user_id);
        $classement = (int) get_field('classement', 'user_' . $user_id);
        $paris_effectues = (int) get_field('paris_effectues', 'user_' . $user_id);
        $paris_gagnes = (int) get_field('paris_gagnes', 'user_' . $user_id);
        $ratio = $paris_effectues > 0  ? ceil($paris_gagnes *100 / $paris_effectues)   : 0;
        $total_de_points = (int) get_field('total_de_points', 'user_' . $user_id);

        $paris_serie_courante = get_posts([
            'post_type'      => 'pari',
            'posts_per_page' => -1,
            'meta_query'     => [
                [
                    'key'     => 'serie',
                    'value'   => $serie_en_cours_id,
                    'compare' => 'LIKE'
                ]
            ]
        ]);

        $serie_en_cours = count($paris_serie_courante);
        ?>

 
            
        </div>
<div class="row-center-logo">
<img src="/wp-content/uploads/2025/09/JUDO PRONOS CHALLENGE.png" width="236" class="sub-header-pari-logo" >
</div>

<div class="row-center">
<div class="pnts-element">

    <div class="total-home"><?php echo $total_de_points;?> pts</div>
    <div class="content">

        <div class="content">
            <div>Mon pourcentage de victoire : <b><?php echo $ratio;?> % (<?php echo $paris_gagnes;?>-<?php echo $paris_effectues;?>)</b></div>
        </div>
        <div class="content">
        Classement général : <b><?php echo $classement;?>e</b><br>
        Meilleure série : <b><?php echo $meilleure_serie;?></b><br>
        Série en cours : <b><?php echo $meilleure_serie;?></b><br>
        </div>
    </div>
    <div class="content">
        <div>
            <a href="/module-de-paris-profil/"  class="enter-game-action disabled">Mon profil <i class="fa-regular fa-user"></i></a>
            <form id="logoutForm" method="post" style="display:none;">
                <input type="hidden" name="jpl_auth_action" value="logout">
            </form>
        </div>
        <div>
            <a href="#" id="logout" class="enter-game-action logoutclass">Se déconnecter</a>
        </div>
    </div>
</div>
</div>

        <div class="flex-3-pari">

         <a href="module-de-paris-paris" class="sub-menu-element round-border-purple vertical bg-home" style="background:url('/wp-content/uploads/2025/09/MES_PRONOS.png'); background-repeat: no-repeat;background-position: center;background-size: cover;">
                    <span>Mes pronos</span>
            </a>

           <a href="/module-de-paris-ligues" class="vertical sub-menu-element round-border-purple bg-home" style="background:url('/wp-content/uploads/2025/09/MES_LIGUES.png'); background-repeat: no-repeat;background-position: center;background-size: cover;">
                    <span>Mes ligues</span>
            </a>

<a href="/module-de-paris-classement" class="vertical sub-menu-element round-border-purple bg-home" style="background:url('/wp-content/uploads/2025/09/MON CLASSEMENT.png'); background-repeat: no-repeat;background-position: center;background-size: cover;">
                    <span>Mon classement</span>
</a>

<a href="/module-de-paris-champions-de-la-semaine" class="disabled vertical sub-menu-element round-border-purple bg-home" style="background:url('/wp-content/uploads/2025/09/CHAMPIONS_SEMAINE_.png'); background-repeat: no-repeat;background-position: center;background-size: cover;">
        <div class="champ2"><span>Champions de la semaine</span></div>
</a>


</div>
        <div class="flex-1-pari">
            
            <div class="sub-menu-element round-border-purple">
                <a href="/module-de-paris-regles-du-jeu" class="horizontal">
                    <span style="display: flex; align-items: center; gap: 10px;">Comment ça fonctionne <img src="/wp-content/uploads/2025/09/JUDO PRONOS CHALLENGE.png" width="80" class="sub-header-logo" ></span>
                    
                </a>
            </div>

            <div class="sub-menu-element round-border bg-green">
                <a href="https://whatsapp.com/channel/0029VbB7Urk9xVJke5yDeL3y" target="_blank" class="horizontal2">
                    <div class="what1">
                        <span class="mb10">
                            <strong>Rejoins le Whatsapp</strong>
                        <br></span>
                        Le lien du canal whatsApp, les cadeaux arrivent…
                    </div>
                    
                     <img src="/wp-content/uploads/2025/08/whatssap-icon.webp" width="60px" style="margin-left: auto;"  >
                </a>
            </div>
        </div>
    </section>

    <?php
get_footer();
?>


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function($) {
        $(".logoutclass").on("click", function(e) {
            e.preventDefault();
            $("#logoutForm").submit();
            
        });
    });
</script>

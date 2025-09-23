<?php


if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}
function email_to_pseudo($email) {
    // Partie avant @
    $pseudo = explode('@', $email)[0];

    // Remplacer les points par des espaces
    $pseudo = str_replace('.', ' ', $pseudo);

    // Limiter à 30 caractères
    if(mb_strlen($pseudo) > 15){
        $pseudo = mb_substr($pseudo, 0, 15) . '...';
    }

    return $pseudo;
}

get_header();

        $user_id = get_current_user_id();
        $user = wp_get_current_user();

        $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
        $prenom = get_user_meta($user_id, 'first_name', true);
        $nom = get_user_meta($user_id, 'last_name', true);
        $avatar_id = get_field('avatar', 'user_'.$user_id);
        $avatar_url = ($avatar_id)?$avatar_id:"/wp-content/uploads/2025/08/user-icon.png";
        $current_status = get_field('status', $ligue_id) ?: 'ouvert';

        $titre = get_field('nom',$post->ID);
        $logo_url = get_field('logo', $post->ID)['url'] ?? "/wp-content/uploads/2025/09/hand.png"; 
        $participants = get_field('participants', $post->ID) ?: []; // si vide, tableau vide
        $createur_id = get_field('createur', $post->ID);

        if ($createur_id && !in_array($createur_id, $participants)) {
            array_unshift($participants, $createur_id);
        }
        
        $is_mine=($createur_id==$user_id)?true:false;


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action    = sanitize_text_field($_POST['action']);
            if($action === 'quit_league' || $action === 'delete_league'){
                $league_id = intval($_POST['league_id']);
                $member_id = intval($_POST['member_id']);
                $redirect_url = site_url('/module-de-paris-ligues/');

                if ($action === 'quit_league') {
                    $participants = get_field('participants', $league_id) ?: [];

                    // Retirer le membre de la liste
                    if (($key = array_search($member_id, $participants)) !== false) {
                        unset($participants[$key]);
                        $participants = array_values($participants); // réindexer
                        update_field('participants', $participants, $league_id);
                    }
                } elseif ($action === 'delete_league') {
                    if ($league_id) {
                        wp_delete_post($league_id, true); // true = suppression définitive
                    }
                }
                wp_redirect($redirect_url);
                exit;
            }   
            if ($action === 'bloquer_participant' || $action === 'ajouter_participant') {
                
                $ligue_id = intval($_POST['ligue_id']);
                $participant_id = intval($_POST['participant_id']);
                

               if ($ligue_id && $participant_id) {
                    $ligue_title = get_the_title($ligue_id);
                    $user_info = get_userdata($participant_id);

                    if ($user_info) {
                        $prenom = $user_info->first_name;
                        $nom    = $user_info->last_name;
                        $email  = $user_info->user_email; // ✅ email ici
                    }

                    // Chercher si un status_ligue_joueur existe déjà pour ce couple
                    $existing = get_posts([
                        'post_type'      => 'status_ligue_joueur',
                        'posts_per_page' => 1,
                        'meta_query'     => [
                            'relation' => 'AND',
                            [
                                'key'     => 'membre',
                                'value'   =>  $participant_id, // relation user
                                'compare' => 'LIKE',
                            ],
                            [
                                'key'     => 'ligue',
                                'value'   => $ligue_id , // relation ligue
                                'compare' => 'LIKE',
                            ]
                        ]
                    ]);

                    $now = current_time('mysql'); // format Y-m-d H:i:s
                    $new_status = ($action === 'bloquer_participant') ? 'bloque' : 'admis';

                    if ($existing) {
                        // ⚡ Mise à jour existant
                        $post_id = $existing[0]->ID;
                        update_field('status', $new_status, $post_id);
                        update_field('date_de_derniere_modification', $now, $post_id);
                    } else {
                        // ⚡ Création d’un nouvel objet
                        $post_id = wp_insert_post([
                            'post_type'   => 'status_ligue_joueur',
                            'post_status' => 'publish',
                            'post_title'  => "Status {$email} - Ligue {$ligue_title}",
                        ]);

                        if ($post_id) {
                            update_field('membre', $participant_id, $post_id);
                            update_field('ligue', $ligue_id, $post_id);
                            update_field('status', $new_status, $post_id);
                            update_field('date_de_derniere_modification', $now, $post_id);
                        }
                    }
                    $toast_message = "✅ Participant {$email} mis à jour en '{$new_status}' pour la ligue {$ligue_title} !";
                }
            }

            if ($action === 'update_ligue_status') {
                if (empty($_POST['ligue_status_nonce']) 
                    || !wp_verify_nonce($_POST['ligue_status_nonce'], 'update_ligue_status_nonce')) {
                    wp_die('Nonce invalide ❌');
                }

                $post_id = intval($_POST['post_id'] ?? 0);
                $new_status = sanitize_text_field($_POST['new_status'] ?? '');

                if (!$post_id || !in_array($new_status, ['ouvert', 'ferme'])) {
                    wp_die('Paramètres invalides ❌');
                }

                // Met à jour le champ ACF
                update_field('status', $new_status, $post_id);

                $toast_message = "✅ Statut mis à jour en « $new_status » !";
            }
               
                        
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
            $action = $_POST['action'];

            if (in_array($action, ['valider_demande','refuser_demande'])) {
                $demande_id = intval($_POST['demande_id']);
                $parieur_id = intval($_POST['parieur_id']);
                $ligue_id   = intval($_POST['ligue_id']);
                // Infos parieur
                $parieur_user = get_userdata($parieur_id);
                $prenom = get_user_meta($parieur_user->ID, 'first_name', true);
                $nom    = get_user_meta($parieur_user->ID, 'last_name', true);

                if (!$demande_id || !$parieur_id || !$ligue_id) {
                    echo "<p style='color:red'>Paramètres invalides.</p>";
                    return;
                }

                $is_accept = ($action === 'valider_demande');
                    $status    = $is_accept ? 'acceptee' : 'refusee';
                // Mettre à jour le statut de la demande
                update_field('status', $status, $demande_id);
                
                if($is_accept){
                     // Mettre à jour les participants
                    $participants = get_field('participants', $ligue_id) ?: [];
                    if (!in_array($parieur_id, $participants)) {
                        $participants[] = $parieur_id;
                        update_field('participants', $participants, $ligue_id);
                    }

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
                }
               

                

                // Toast message
                $toast_message = "✅ La demande de {$prenom} {$nom} a bien été " . ($is_accept ? "validée" : "refusée") . " !";

                // Ajouter créateur si besoin
                $participants = get_field('participants', $post->ID) ?: [];
                $createur_id  = get_field('createur', $post->ID);
                if ($createur_id && !in_array($createur_id, $participants)) {
                    array_unshift($participants, $createur_id);
                }
            }
        }



        // 2. Récupérer toutes les demandes liées à cette ligue
        $demandes = get_posts([
            'post_type'   => 'demande',
            'numberposts' => -1,
            'meta_query'  => [
                'relation' => 'AND', // toutes les conditions doivent être vraies
                [
                    'key'     => 'ligue',
                    'value'   => $post->ID,
                    'compare' => 'LIKE', 
                ],
                [
                    'key'     => 'status',
                    'value'   => 'en_attente', // champ status = en attente
                    'compare' => 'LIKE', 
                ]
            ]
        ]);
?>

<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <a href="/module-de-paris-ligues/">Mes ligues</a> > <?php echo get_the_title();?>
    </div>
</div>
<main id="primary" class="site-main cntnt-ligue">
    <section class="listes-equipes page-calendrier" style="max-width: 100%;">
     
            
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
       
    <div class="content-ligue">    
        <div>
            <h2 class="league-title">
                <?php echo esc_html($titre); ?>
            </h2>
            <div class="flex-3-ligue">
                <?php if(!$is_mine){?>
                <div class="bg-gray-border-purple">
                    <form method="post" action="" class="insivible-form">
                        <input type="hidden" name="league_id" value="<?php echo esc_attr($post->ID); ?>">
                        <input type="hidden" name="member_id" value="<?php echo esc_attr($user_id); ?>">
                        <input type="hidden" name="action" value="quit_league">
                        <button type="submit" class="invisible-button">Quitter la ligue</button>
                    </form>
                </div>
                <?php }?>
                <?php if($is_mine){?>
                    <form method="post" action="" class="insivible-form">
                        <input type="hidden" name="league_id" value="<?php echo esc_attr($post->ID); ?>">
                        <input type="hidden" name="member_id" value="<?php echo esc_attr($user_id); ?>">
                        <input type="hidden" name="action" value="delete_league">
                        <button type="submit" class="supprimer-ligue">Supprimer la ligue</button>
                    </form>
                <?php }?>
            </div>
        
            <?php if($is_mine){?>
            <div class="flx-div">
<div>
                <h3 style="margin-top: 0px;">Ligue privée</h3>
                <p style="color:#625765;">La ligue est exclusive, accessible uniquement aux joueurs invités et nécessitant votre approbation.</p>
</div>

                <div class="toggle-wrap">
                    <form method="post" id="ligue-status-form">
                        <input type="hidden" name="action" value="update_ligue_status">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
                        <input type="hidden" name="new_status" id="ligue_status_hidden" value="<?php echo esc_attr(get_field('status', $post->ID)); ?>">
                        <?php wp_nonce_field('update_ligue_status_nonce', 'ligue_status_nonce'); ?>

                        <label class="switch">
                            <input type="checkbox" id="ligue_status_toggle" <?php checked(get_field('status', $post->ID), 'ferme'); ?>>
                            <span class="slider"></span>
                        </label>
                    </form>
                </div>
            </div>
            
           
            <div class="share-box">
                <b>Lien de partage :</b><br>
                <input type="text" id="share-link" value="<?php echo esc_url(get_site_url()); ?>/rejoindre-ligue-privee?ligueID=<?php echo ($post->ID);?>" readonly style="width:100%;padding:5px;">
                <!--<button id="copy-link" class="copy-link">Copier</button>-->
            </div>
            
            
        
        <?php }?>
        </div>
        <div>
            <?php 
                if (!empty($participants)) : 
                    $total = count($participants); 
                    echo "<h2 class='div-m'>Membres</h2>";
                ?>

                <ul class="no-padding">
                    <?php $i=0;
                    foreach ($participants as $participant_id) : 
                        $prenom = get_user_meta($participant_id, 'first_name', true);
                        $nom = get_user_meta($participant_id, 'last_name', true);
                        $user = get_user_by('id', $participant_id);

                        $pseudo = get_field('pseudo', 'user_'.$participant_id) ?: $user->display_name;
                        if (empty($prenom) && empty($nom)) {
                            // Si vide, assigner un pseudo
                            $pseudo = email_to_pseudo($pseudo);  // Mettre un pseudo par défaut si nécessaire
                        }else {
                            // Sinon, concaténer prénom et nom
                            $pseudo = $prenom . ' ' . $nom;
                        }
                        $is_me=( $user_id == $participant_id)?" (moi) ":"";
                        $date_insc = date_i18n('d/m/Y', strtotime($user->user_registered));
                        $class = ($i % 2 !== 0) ? 'impair' : 'pair';
                        // Chercher si un status_ligue_joueur existe déjà pour ce couple
                        $status_ligue_joueur = get_posts([
                            'post_type'      => 'status_ligue_joueur',
                            'posts_per_page' => 1,
                            'meta_query'     => [
                                'relation' => 'AND',
                                [
                                    'key'     => 'membre',
                                    'value'   =>  $participant_id, // relation user
                                    'compare' => 'LIKE',
                                ],
                                [
                                    'key'     => 'ligue',
                                    'value'   => $post->ID , // relation ligue
                                    'compare' => 'LIKE',
                                ]
                            ]
                        ]);
                        $current_status = "non défini";

                        if (!empty($status_ligue_joueur)) {
                            $status_id = $status_ligue_joueur[0]->ID; // ✅ premier élément du tableau
                            $current_status = get_field('status', $status_id);
                        }
                    



                        ?>
                        <li class="participant-element <?php echo esc_attr($class); ?>">
                            <div class="date-action">
                                <?php echo esc_html($pseudo . $is_me); ?>
                            </div>
                            <div class="date-action">
                                <?php if ($user_id != $participant_id && $is_mine): ?>
                                    <?php if ( $current_status == "non défini" && !$is_me): ?>
                                        <!-- Ajouter un participant -->
                                        <form method="post" action="">
                                            <input type="hidden" name="ligue_id" value="<?php echo esc_attr($post->ID); ?>">
                                            <input type="hidden" name="participant_id" value="<?php echo esc_attr($participant_id); ?>">
                                            <input type="hidden" name="action" value="bloquer_participant">
                                            <button type="submit" class="delete-button">
                                                <img src="/wp-content/uploads/2025/09/block-picto.png" class="img-40" alt="Bloquer">
                                            </button>
                                        </form>
                                    <?php elseif ($current_status != "admis"): ?>
                                        <!-- Ajouter un participant -->
                                        <form method="post" action="">
                                            <input type="hidden" name="ligue_id" value="<?php echo esc_attr($post->ID); ?>">
                                            <input type="hidden" name="participant_id" value="<?php echo esc_attr($participant_id); ?>">
                                            <input type="hidden" name="action" value="ajouter_participant">
                                            <button type="submit" class="delete-button">
                                                <img src="/wp-content/uploads/2025/09/star_gray.png" class="img-40" alt="Ajouter">
                                            </button>
                                        </form>
                                    <?php elseif ($current_status != "bloque"): ?>
                                        <!-- Bloquer un participant -->
                                        <form method="post" action="">
                                            <input type="hidden" name="ligue_id" value="<?php echo esc_attr($post->ID); ?>">
                                            <input type="hidden" name="participant_id" value="<?php echo esc_attr($participant_id); ?>">
                                            <input type="hidden" name="action" value="bloquer_participant">
                                            <button type="submit" class="delete-button">
                                                <img src="/wp-content/uploads/2025/09/block-picto.png" class="img-40" alt="Bloquer">
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </li>

                    <?php 
                    $i++;
                endforeach; ?>
                </ul>

            <?php endif; ?>
        </div>

<div>
    <?php if ( $is_mine) {
        $total_demandes = count($demandes);
        $i=0;
        echo "<h2 class=''>Membres en attente de validation</h2>";

        if ($demandes) {
            echo '<ul class="no-padding">';
            $i = 0;

            foreach ($demandes as $demande) {
                $date = get_field('date', $demande->ID);
                $class = ($i % 2 !== 0) ? 'impair' : 'pair';
                
                // Récupérer le parieur
                $parieur = get_field('parieur', $demande->ID);

                $parieur_id = $parieur['ID'];
                $prenom = $parieur['user_firstname'];
                $nom    = $parieur['user_lastname'];
                $email  = $parieur['user_email'];
                
                $user = get_user_by('id', $parieur_id);

                $pseudo = get_field('pseudo', 'user_'.$parieur_id) ?: $user->display_name;
                if (empty($prenom) && empty($nom)) {
                    // Si vide, assigner un pseudo
                    $pseudo = email_to_pseudo($pseudo);  // Mettre un pseudo par défaut si nécessaire
                }else {
                    // Sinon, concaténer prénom et nom
                    $pseudo = $prenom . ' ' . $nom;
                }

                // Récupérer le status
                $status_field = get_field_object('status', $demande->ID);
                $status_value = $status_field['value'] ?? '';   // ex: "acceptee"
                $status_label = $status_field['choices'][$status_value] ?? $status_value; // ex: "Acceptée"

                echo '<li class="participant-element '.esc_attr($class).'">';
                
                echo '<div class="date-action">' . esc_html($pseudo) . '</div>';
                
                echo '<div class="date-action">';
            

                // Formulaire pour valider la demande
                echo '<form method="post">';
                echo '<input type="hidden" name="demande_id" value="'.esc_attr($demande->ID).'">';
                echo '<input type="hidden" name="parieur_id" value="'.esc_attr($parieur_id).'">';
                echo '<input type="hidden" name="ligue_id" value="'.esc_attr($post->ID).'">';
                echo '<input type="hidden" name="action" value="valider_demande">';
                echo '<button type="submit" class="valider-button">Accepter</button>';
                echo '</form>';

                // Formulaire pour valider la demande
                echo '<form method="post">';
                echo '<input type="hidden" name="demande_id" value="'.esc_attr($demande->ID).'">';
                echo '<input type="hidden" name="parieur_id" value="'.esc_attr($parieur_id).'">';
                echo '<input type="hidden" name="ligue_id" value="'.esc_attr($post->ID).'">';
                echo '<input type="hidden" name="action" value="refuser_demande">';
                echo '<button type="submit" class="refuser-button">Refuser</button>';
                echo '</form>';

                echo '</div>';
                echo '</li>';

                $i++;
            }
            echo '</ul>';
        }else{
            echo 'Aucune demande en attente';
        }
    
    }
    ?>
  </div>
</div>


        


                        
                       
                        
                    
                
                    
                    
              
             


    </section>

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

.content-ligue{
    margin-top: 4%;
    display: grid;
    gap: 20px;
    grid-template-columns: 1fr 1fr 1fr;
}
.valider-button {
    color: #020640;
    background-color: #84EBB4;
    padding: 10px 20px;
    width: 100%;
    border: solid 1px #1FC16B;
    border-radius: 8px;
}
.refuser-button {
    color: #020640;
    background-color: #FB3748;
    padding: 10px 20px;
    width: 100%;
    border: solid 1px #D00416;
    border-radius: 8px;
}
.flex-3-ligue {
    display: grid;
    grid-template-columns: 1.1fr 1fr 1fr;
    gap: 10px;
    justify-items: center;
    align-items: center;
    justify-content: center;
    align-content: center;
}
.supprimer-ligue{
    color: #ffffff;
    background-color: #D00416;
    padding: 10px 20px;
    width: 100%;
    border: none;
    border-radius: 8px;
}
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 24px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #1724f6;
}

input:checked + .slider:before {
  transform: translateX(26px);
}
.share-ligue{
    color: #ffffff;
    background-color: #1724F6;
    padding: 10px 20px;
    width: 100%;
    border: none;
    border-radius: 8px;
    font-weight:bolder;
}
</style>

    <script>
        var ligueID = "<?php echo $ligue_id; ?>";
        var ligueUrl = "<?php echo esc_url($ligue_url); ?>";
        var ligueTitle = "<?php echo $ligue_title; ?>";
        var baseUrl = "<?php echo esc_url(get_site_url()); ?>"; // récupère automatiquement le domaine actuel
    </script>
    <script>
        jQuery(document).ready(function($){

            $('#ligue_status_hidden').val($('#ligue_status_toggle').is(':checked') ? 'ferme' : 'ouvert');

            $('#ligue_status_toggle').on('change', function(){
                // mettre à jour le hidden
                $('#ligue_status_hidden').val($(this).is(':checked') ? 'ferme' : 'ouvert');

                // soumettre le formulaire après 2 secondes
                setTimeout(() => {
                    $('#ligue-status-form').submit();
                }, 1000);
            });

           
           

            // Copier le lien
            $(document).on("click", "#copy-link", function(){
                 
                let input = document.getElementById("share-link");
                input.select();
                input.setSelectionRange(0, 99999); // pour mobile

                try {
                    // Méthode moderne
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(input.value()).then(() => {
                            alert("Lien copié !");
                        });
                    } else {
                        // Fallback
                        document.execCommand("copy");
                        alert("Lien copié !");
                    }
                } catch (err) {
                    console.error("Erreur lors de la copie :", err);
                    alert("Impossible de copier le lien");
                }
            });




           
        });
    </script>



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

<?php

/* Template Name: Reset Password Custom */


if ( ! defined('ABSPATH') ) exit;
get_header();
?>
<main id="primary" class="site-main cntnt-ligue">
    <section class="listes-equipes page-calendrier" style="max-width: 100%;">
        <div class="custom-password">
            <? echo do_shortcode("[reset_password]"); ?>
        </div>
    </section>
</main>
<?php
get_footer();
?>

<script>

    jQuery(document).ready(function($){

    // --- FORMULAIRE RESET PASSWORD (nouveau mot de passe) ---
    var $newPassForm = $('fieldset:has(#som_new_user_pass)');

    if($newPassForm.length){

        // Supprimer fieldset et legend
        $newPassForm.replaceWith($newPassForm.contents());

        // Traduire les textes
        $('.somfrp-lost-pass-form-text p.extra-space').text(
            "Veuillez saisir un nouveau mot de passe."
        );
        $('label[for="som_new_user_pass"]').text("Nouveau mot de passe");
        $('label[for="som_new_user_pass_again"]').text("Confirmer le mot de passe");
        $('#reset-pass-submit').text("Réinitialiser le mot de passe");

        // Traduire les titres des boutons eye-toggle (optionnel)
        $('.somfrp-eye-toggle').attr('title', 'Afficher / masquer le mot de passe');
    }

    // --- FORMULAIRE LOST PASSWORD (demande email/username) ---
    var $lostPassForm = $('fieldset:has(#somfrp_user_info)');
    if($lostPassForm.length){

        // Supprimer fieldset et legend
        $lostPassForm.replaceWith($lostPassForm.contents());

        // Traduire texte et label
        $('.somfrp-lost-pass-form-text p.extra-space').text(
            "Veuillez saisir votre adresse e-mail ou votre nom d'utilisateur. Vous recevrez un lien pour créer un nouveau mot de passe par e-mail."
        );
        $('label[for="somfrp_user_info"]').text("Adresse e-mail ou nom d'utilisateur");
        $('#reset-pass-submit').text("Réinitialiser le mot de passe");
    }

    // --- MESSAGE PASSWORD ENVOYÉ ---
    $('.som-password-sent-message span').text(
        "Un e-mail a été envoyé. Veuillez vérifier votre boîte de réception."
    );

    // --- MESSAGE PASSWORD RESET ---
    $('#password-lost-form-wrap fieldset p').html(
        'Votre mot de passe a été réinitialisé. Vous pouvez maintenant <a href="' + $('#password-lost-form-wrap a').attr('href') + '">vous connecter</a>.'
    );
    // supprimer fieldset restant
    $('#password-lost-form-wrap fieldset').contents().unwrap();

    // Sélectionner le fieldset généré
    var $fieldset = $('fieldset:has(#somfrp_user_info)');
    $('legend').remove(); 

    if($fieldset.length){

        // 1️⃣ Supprimer le fieldset et legend, garder le contenu
        $fieldset.replaceWith($fieldset.contents());

        // 2️⃣ Traduire le texte de description
        $('.somfrp-lost-pass-form-text p.extra-space').text(
            "Veuillez saisir votre adresse e-mail ou votre nom d'utilisateur. Vous recevrez un lien pour créer un nouveau mot de passe par e-mail."
        );

        // 3️⃣ Modifier le label
        $('label[for="somfrp_user_info"]').text("Adresse e-mail ou nom d'utilisateur");

        // 4️⃣ Modifier le bouton si nécessaire
        $('#reset-pass-submit').text("Réinitialiser le mot de passe");
    }
});

</script>
<?php

/**
 * Template Name: Modèle A-propos
 */

get_header();
$titlebar   = get_field('header_de_la_page');
$title   = get_field('titre_de_la_page');
?>

<main id="primary" class="site-main ">
    <section class="listes-equipes page-about">
        <?php the_content(); ?>
		
<!-- 		<section class="jpl-faq-section">

    <div class="jpl-faq-heading">
        <h2>
            Questions fréquentes
        </h2>
        <p>
            Retrouvez les réponses aux principales questions
            concernant la Judo Pro League.
        </p>

    </div>


    <div class="jpl-faq">

        <?php
        $faq_items = array(
            "Qu’est-ce que la Judo Pro League ?",
            "Comment fonctionne une rencontre ?",
            "Combien de combattants composent une équipe ?",
            "Comment sont attribués les points au classement ?",
            "Comment une équipe se qualifie-t-elle pour la phase finale ?",
            "Où consulter les résultats et le classement ?"
        );

        foreach ($faq_items as $index => $question):
        ?>

            <div class="jpl-faq-item">

                <button
                    type="button"
                    class="jpl-faq-question"
                    aria-expanded="false"
                >

                    <span class="jpl-faq-number">
                        <?php echo sprintf('%02d', $index + 1); ?>
                    </span>

                    <span class="jpl-faq-question-text">
                        <?php echo esc_html($question); ?>
                    </span>

                    <span class="jpl-faq-icon">
                        <i class="fa-solid fa-plus"></i>
                    </span>

                </button>


                <div class="jpl-faq-answer">

                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Integer vitae justo nec lorem consequat
                        tincidunt. Curabitur euismod, nisl vel sollicitudin
                        posuere, nisl neque consequat libero, vitae
                        tincidunt nibh erat at mauris.
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>-->
		
		
    </section> 

    <?php
get_footer();
?>
<!-- 	<script>
document.querySelectorAll('.jpl-faq-question').forEach(function(button) {

    button.addEventListener('click', function() {

        const item = this.closest('.jpl-faq-item');
        const isActive = item.classList.contains('active');

        document.querySelectorAll('.jpl-faq-item').forEach(function(otherItem) {
            otherItem.classList.remove('active');
        });

        if (!isActive) {
            item.classList.add('active');
        }

    });

});
</script> -->
	<script>
document.querySelectorAll('.jpl-faq-question').forEach(function(button) {

    button.addEventListener('click', function() {

        const item = this.closest('.jpl-faq-item');
        const isActive = item.classList.contains('active');

        document.querySelectorAll('.jpl-faq-item').forEach(function(otherItem) {
            otherItem.classList.remove('active');
        });

        if (!isActive) {
            item.classList.add('active');
        }

    });

});
</script>
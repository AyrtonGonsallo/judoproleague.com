jQuery(document).ready(function($) {
	
    /****** Equal (min-height) for textes,titles, exc in inline blocs *****/
        var max_heightTxt =(classes)=>{
            var max_height_txt = jQuery(classes).map(function (){return jQuery(this).height();}).get();
            minHeightTxt = Math.max.apply(null, max_height_txt);
            jQuery(classes).css( "min-height",minHeightTxt );
        }
   
        //dupliquer le code suivant ou cas de besoin d'autres element de méme hauteur !
      setTimeout(function() { 
        max_heightTxt('.div-jdk-tabs');
		//max_heightTxt('.nv-team-hdr');
	}, 1500);
	/************************************************************/
    setTimeout(function() { 
        console.log("recherche de judokas",($('#judoka-search').length)?true:false)

        $(document).on('input', '#judoka-search', function () {

            const query = $(this).val().toLowerCase();

            $('#judoka-results').empty();

            if (query.length < 2) {
                return;
            }

            $('#judoka1-select option, #judoka2-select option').each(function () {

                const id = $(this).val();
                const text = $(this).text();

                if (!id) return;

                if (text.toLowerCase().includes(query)) {

                    $('#judoka-results').append(
                        '<div class="judoka-item" data-id="' + id + '">' +
                        text +
                        '</div>'
                    );
                }

            });

        });

        // Sélectionner un judoka et l'ajouter au champ caché
        $(document).on('click', '.judoka-item', function () {

            const id = $(this).data('id');

            if (!$('#judoka1-select').val()) {
                $('#judoka1-select').val(id).trigger('change');
            } else if (!$('#judoka2-select').val()) {
                $('#judoka2-select').val(id).trigger('change');
            } else {
                alert('Les deux judokas sont déjà sélectionnés.');
            }

            $('#judoka-results').empty();
            $('#judoka-search').val('');
        });

        console.log("recherche de rencontre",($('#rencontre-search').length)?true:false)

        $(document).on('input', '#rencontre-search', function () {

            const query = $(this).val().toLowerCase();
            const results = $('#rencontre-results');

            results.empty();

            if (query.length < 2) {
                return;
            }

            let count = 0;

            $('#rencontre-select option').each(function () {

                if (count >= 20) return false;

                const id = $(this).val();
                const text = $(this).text();

                if (!id) return;

                if (text.toLowerCase().includes(query)) {

                    results.append(
                        '<div class="rencontre-item" data-id="' + id + '">' +
                        text +
                        '</div>'
                    );

                    count++;
                }
            });

        });


        // Sélectionner une rencontre et l'ajouter au champ caché
        $(document).on('click', '.rencontre-item', function () {

            const id = $(this).data('id');

            $('#rencontre-select')
                .val(id)
                .trigger('change');

            $('#rencontre-results').empty();
            $('#rencontre-search').val('');
        });
    
        

    }, 5000);


    
});

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

        $('#judoka-search').on('input', function() {
            var query = $(this).val();
            if (query.length > 2) {
                console.log(query)
                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'search_judokas',
                        query: query
                    },
                    success: function(data) {
                        console.log(data)
                        $('#judoka-results').empty();
                        data.forEach(function(judoka) {
                            $('#judoka-results').append('<div class="judoka-item" data-id="' + judoka.id + '">' + judoka.text + '</div>');
                        });
                    }
                });
            }
        });
    
        // Sélectionner un judoka et l'ajouter au champ caché
        $('#judoka-results').on('click', '.judoka-item', function() {
            $(this).css({
                "background-color": "red",
                "color": "#ffffff"
            });
            var judokaId = $(this).data('id');
            var judokaName = $(this).text();
            var prev_judokas = $('#selected-judokas').val();
            var new_judokas = prev_judokas+"/"+judokaId
            $('#selected-judokas').val(new_judokas).trigger('input');
            $('#selected-judokas2').val(new_judokas).trigger('input');
            //$('#judoka-search').val(judokaName);
            //$('#judoka-results').empty();
        });

    }, 5000);
    
    
});

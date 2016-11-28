jQuery(document)
  .ready(function() {

  	jQuery('.ui.sidebar')
	  .sidebar('attach events', '.toc.item')
	;

	jQuery(window).resize(function() {
		if (jQuery(window).width() < 700) {
		    jQuery('.window').removeClass('horizontal');
		    jQuery('.window').addClass('raised');
		}
		else {
		     jQuery('.window').removeClass('raised');
		    jQuery('.window').addClass('horizontal');
		}
	});

	jQuery('.ui.dropdown')
	  .dropdown()
	;

	jQuery('.ui.accordion')
	  .accordion()
	;

	jQuery('.main-menu a.item').on('click', function(){
		jQuery('.main-menu a.item.active').removeClass('active');
		$this.addClass('active');
	})

	jQuery('nav a[href^="/' + location.pathname.split("/")[1] + '"]').addClass('active');

	// Search Form in Navbar
	/*jQuery('a.search-btn').on('click', function(){
		jQuery('.prime').transition('hide');
		jQuery('.ui.menu:not(.vertical) .item.search-ui').transition('slide left');
		jQuery('a.search-btn').hide();
		jQuery('a.search-close').show();
	});*/

	/*jQuery('a.search-close').on('click', function(){
		jQuery('.ui.menu:not(.vertical) .item.search-ui').transition('slide left');
		jQuery('a.search-close').hide();
		jQuery('a.search-btn').show();
		jQuery('.prime').transition('fade down', '2560ms');
	});*/

	var $content = jQuery('.ajax_posts');
	var $loader = jQuery('#more_posts');
	var cat = $loader.data('category');
	var ppp = 4;
	var offset = jQuery('#main').find('.post').length;
	 
	$loader.on( 'click', load_ajax_posts );
	 
	function load_ajax_posts() {

		var exclude = jQuery('#exclude').val();
		var split = exclude.split(",");
		var post_not_in = new Array();
		
		for(i = 0; i < split.length; i++)
		{
			post_not_in.push(split[i]);
		}
		var json = JSON.stringify(post_not_in);

		if (!($loader.hasClass('loading') || $loader.hasClass('post_no_more_posts'))) {
			jQuery.ajax({
				type: 'POST',
				dataType: 'html',
				url: screenReaderText.ajaxurl,
				data: {
					'cat': cat,
					'ppp': ppp,
					'offset': offset,
					'post_not_in' : json,
					'action': 'mytheme_more_post_ajax'
				},
				beforeSend : function () {
					$loader.addClass('loading');
				},
				success: function (data) {
					var $data = jQuery(data);
					if ($data.length) {
						var $newElements = $data.css({ opacity: 0 });
						$content.append($newElements);
						$loader.removeClass('loading');
						$newElements.animate({ opacity: 1 });
						$loader.removeClass('loading').html(screenReaderText.loadmore);
					} else {
						$loader.removeClass('loading').addClass('post_no_more_posts').html(screenReaderText.noposts);
					}
				},
				error : function (jqXHR, textStatus, errorThrown) {
					$loader.html($.parseJSON(jqXHR.responseText) + ' :: ' + textStatus + ' :: ' + errorThrown);
					console.log(jqXHR);
				},
			});
		}
		offset += ppp;
		return false;
	}


	// TAB MENU FOR EVENT AND NEWS
	jQuery('#news-tab .button').tab();

	jQuery(document).on('click', 'a#event-next-page', function ( e ) {
                
        var button              = jQuery( this ),
            paged               = parseInt( button.attr('data-page') ),
            formData            = jQuery('#tim-event-search').serializeArray();

        if( button.hasClass('tim__load') ) return false;
        button.addClass('loading');

        jQuery.ajax({
            url: screenReaderText.ajaxurl,
            type: 'post',
            data: {
                action: 'vio_event_ajax_pagination',
                queryVars: screenReaderText.queryVars,
                extraQuery: {
                    'm' : formData[0].value,
                    's' : formData[1].value,
                },
                page: paged,
                nonce: screenReaderText.timNonce
            },
            success: function( result ) {

                if( result == '-1' ) {
                    button.hide('fast').remove();
                } else {

                    paged++;
                    button.attr('data-page', paged);
                    jQuery('#event-list').append( result );
                }
                
                button.removeClass('loading');
            }
        })

        e.preventDefault();
    }); 

  });

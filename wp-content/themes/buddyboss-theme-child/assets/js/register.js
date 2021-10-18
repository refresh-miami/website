jQuery( document ).ready( function( $ ) {
    
    
    $('.rm-register-slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        dotsClass: 'rm-slick-dots'
    });

    $(document).on('gform_page_loaded', function(event, form_id, current_page) {

        console.log( 'loading page ' + current_page );
        
        var group = false;

        /* ajax and pull slide information */

        switch ( current_page ) {
            case '1':
            case '2':
                group = 1;
                break;
            case '3':
            case '4':
            case '5':
            case '6':
                group = 2;
                break;
            case '7':
                group = 3;
            case '8':
                group = 4;
                break;

        } /* end switch */

        // AJAX call to remove metadata
        $.post(
            ajaxurl,
            {
                action:       'fm_ajax_get_slide',
                group:        group,
                current_page: current_page,
                form_id:      form_id
                // nonce:   envira_proofing_metabox.nonce
            },
            function( response ) {
                console.log( response );
                // Unlock order
                $( 'div#step-text' ).html( response );
                $('.rm-register-slider').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                    dotsClass: 'rm-slick-dots'
                });
            },
            'html'
        );

        $.post(
            ajaxurl,
            {
                action:       'fm_ajax_get_slide_icon',
                group:        group,
                current_page: current_page,
                // nonce:   envira_proofing_metabox.nonce
            },
            function( response ) {
                console.log( response );
                // Unlock order
                $( 'div#step-icon' ).html( response );
            },
            'html'
        );

    });

} );
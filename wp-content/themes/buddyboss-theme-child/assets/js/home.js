jQuery( document ).ready( function( $ ) {
    
    
    
    $('.rm-testimonial-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        arrows: false,
        dotsClass: 'rm-slick-dots hp-dots',
        responsive: [
            {
              breakpoint: 1008,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }

          ]
    });


    // $('.rm-partner-slider').slick({
    //     infinite: true,
    //     slidesToShow: 6,
    //     slidesToScroll: 1,
    //     dots: true,
    //     arrows: false,
    //     dotsClass: 'rm-slick-dots hp-dots'
    // });

} );
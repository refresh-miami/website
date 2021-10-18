jQuery( document ).ready( function( $ ) {

    $(document).ready(function() {
        $('legend.collapsible-legend').click(function() {

          $(this).parent().toggleClass('active');

          if ($(this).parent().hasClass('active')) {
            $(this).removeClass('closed').addClass('active');
            $(this).parent().find('.collapsible-fieldset').removeClass('closed').addClass('active');
          } else {
            $(this).removeClass('active').addClass('closed');
            $(this).parent().find('.collapsible-fieldset').removeClass('active').addClass('closed');
          }
        });

        $('#search_news_days').on("change mousemove", function() {
            $(this).next().html($(this).val());
        });

        $('.subnav-search.members-search').show();

      });








    // reset dropdowns if we should.
    // $("#news-category-dd").val( $("#news-category-dd").val() );
    // $("#news-tag-dd").val( $("#news-tag-dd").val() );

    // $('#news-category-dd').on('change', function () {
    //   var url = $(this).val(); // get selected value
    //   if (url) { // require a URL
    //       window.location = url; // redirect
    //   }
    //   return false;
    // });

    // $('#news-tag-dd').on('change', function () {
    //   var url = $(this).val(); // get selected value
    //   if (url) { // require a URL
    //       window.location = url; // redirect
    //   }
    //   return false;
    // });

} );

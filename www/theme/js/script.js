$(document).ready(function() {
    
    let docWidth = $(document).width();
    let docHeight = $(document).height();

    if($('#content').height() < docHeight-$('footer').height()-$('nav').height()-90) {
        $('footer').addClass('absolute-footer');
    }

});
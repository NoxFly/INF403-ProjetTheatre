$(document).ready(function() {
    
    let docWidth = $(document).width();
    let docHeight = $(document).height();


    if($('#content').height() < docHeight-$('footer').height()) {
        $('footer').addClass('absolute-footer');
    }

});
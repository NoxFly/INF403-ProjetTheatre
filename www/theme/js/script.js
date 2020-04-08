$(document).ready(function() {
    
    let docWidth = $(document).width();
    let docHeight = $(document).height();
	//alert(($('#content').height()+50) + ' < ' + (docHeight-$('nav').height()-$('footer').height()-100) + ' = '+ ($('#content').height()+50 < docHeight-$('nav').height()-$('footer').height()-100));
    if($('#content').height()+50 < docHeight-$('nav').height()-$('footer').height()-60) {
        $('footer').addClass('absolute-footer');
    }

});
$(document).ready(function() {
    
    let docWidth = $(document).width();
    let docHeight = $(document).height();
	
	if($('#content').height()+50 < docHeight-$('nav').height()-$('footer').height()-100) {
        $('footer').addClass('absolute-footer');
	}
	

	$('.page-accueil h3').each(function() {
		let span = $('<span>');
		span.addClass('h3-home-bg');
		span.text($(this).text());
		$(this).text('');
		$(this).html(span);
	});


	$('#select-specDos').on('change', function() {
		let data = $(this).children('option:selected').text();

		// ajax for spec-dos
		$.post("", {category: data}).done(function(data) {
			//console.log(data);
			if(/<table>/.test(data)) {
				data = data.match(/(<table>(?:.|\n)*<\/table>)/gmi)[0];
			} else {
				data = data.match(/<p style=.*>.*<\/p>/)[0];
			}

			$('#specDos-res').html(data);
		});
	});
});
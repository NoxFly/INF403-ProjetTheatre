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
		post({category: data}, data => {
			if(/<table>/.test(data)) {
				data = data.match(/(<table>(?:.|\n)*<\/table>)/gmi)[0];
			} else {
				data = data.match(/<p style=.*>.*<\/p>/)[0];
			}

			$('#specDos-res').html(data);
		});
	});

	$('#spec-dos-v3 select').on('change', function() {
		let n = parseInt($(this).children('option:selected').text());
		$('#result').html('');
		
		post({noDossier: n}, data => {
			if(/<article id="step\-2">/.test(data)) {
				data = data.match(/(<article id="step\-2">(?:.|\n)*<\/article>)/gmi)[0];
				let div = $('<div>');
				div.html(data);
				data = div.children('article').html();
				$('#spec-dos-v3 #step-2').html(data);
			}
		});
	});

	$('body').on('input', '#spec-dos-v3 #step-2 input', function() {
		let n = $('#spec-dos-v3 select').children('option:selected').text();
		let cat = $(this).val();

		post({categorie: cat, noDossier: n}, data => {
			if(/<table>/.test(data)) {
				data = data.match(/(<table>(?:.|\n)*<\/table>)/gmi)[0];
				$('#result').html(data);
			}
		});
	});

	$('.page-details-ticket select').on('change', function() {
		let n = $(this).children('option:selected').text();
		$('#result').html('');
		
		post({noSerie: n}, data => {
			if(/<table>/.test(data)) {
				data = data.match(/(<table>(?:.|\n)*<\/table>)/gmi)[0];
			} else {
				data = data.match(/<p style=.*>.*<\/p>/)[0];
			}
			$('.page-details-ticket #result').html(data);
		});
	});
});

function post(params, callback=null) {
	$('body').addClass('wait');

	$.post("", params).done(data => {
		$('body').removeClass('wait');
		if(callback) callback(data);
	});
}
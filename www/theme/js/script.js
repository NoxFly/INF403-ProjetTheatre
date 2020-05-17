$(document).ready(function() {

	const oDates = {
		JAN: '01', FEB: '02', MAR: '03', APR: '04',
		MAY: '05', JUN: '06', JUL: '07', AUG: '08',
		SEP: '09', OCT: '10', NOV: '11', DEC: '12'
	};
    
    let docWidth = $(document).width();
    let docHeight = $(document).height();
	
	// change footer's position relativly to the page content's height
	if($('#content').height()+50 < docHeight-$('nav').height()-$('footer').height()-100) {
        $('footer').addClass('absolute-footer');
	}
	
	// stylise each h3 in the home page
	$('.page-accueil h3').each(function() {
		let span = $('<span>');
		span.addClass('h3-home-bg');
		span.text($(this).text());
		$(this).text('');
		$(this).html(span);
	});

	// select a catergory
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

	// select a backrest
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

	// select a category
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

	// select a ticket
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


	// go from personal tables to transfert page
	$('.page-tables-personnelles button').click(() => {
		location.href = 'transfert';
	});

	let tableAction = null;

	// when hovering a table, show the options pannel
	$('body').on('mouseenter', '.page-gerer-representations table', function() {
		tableAction = $(this);
		$('#pannel-spectacle').css({
			top: ($(this).offset().top + $(this).height() / 2) + 'px',
			left: ($(this).offset().left + $(this).width() - 2) + 'px'
		}).fadeIn(0);
	});


	let wnf = $('#window-new-show');


	// open the form to create a new show
	$('body').on('click', '#new-show-btn', () => {
		wnf.find('h2').text('Nouveau spectacle');
		wnf.removeClass('editShow').addClass('newShow');
		$('#spectacles').fadeOut(0);
		wnf.fadeIn(0);
	});

	// close the form to create a new show
	wnf.find('.cancel').click(() => {
		$('#spectacles').fadeIn(0);
		wnf.fadeOut(0);
		
		// reset values of inputs each time we close the form
		wnf.find('input').each((idx, input) => $(input).val(''));
		$('#area-representations').html("<p class='desc' style='font-size: .8em;'>Aucune date</p>");
	});

	wnf.find('#dateRepInput').on('change', function() {
		// clone it and remove its id
		let dateInput = $(this).clone();
		dateInput.removeAttr('id');
		console.log(dateInput.val());

		let placeInput = null;

		// this date is already on the date's list
		let unique = true;
		$('#area-representations input').each((idx, input) => {
			if(input.value == this.value) unique = false;

			// sort by date - find the right place
			if(input.value < this.value) {
				placeInput = $(input);
			}
		});

		$(this).val('');

		if(!unique) return;
		//

		// 0 registered date
		if(!placeInput) {
			$('#area-representations p').remove();
			$('#area-representations').prepend(dateInput);
		}
		
		// append at the right place
		else {
			dateInput.insertAfter(placeInput);
		}

	});

	// remove a registered date when creating new show
	$('body').on('click', '#area-representations input', function() {
		$(this).remove();

		if($('#area-representations input').length == 0) $('#area-representations').append("<p class='desc' style='font-size: .8em;'>Aucune date</p>");
	});


	// validate form of show
	wnf.find('.validate').click(() => {
		// values of form
		let showName = wnf.find('input[name="nomSpectacle"]').val();
		let showDuration = wnf.find('input[name="dureeSpectacle"]').val();
		let dates = [];
		wnf.find('#area-representations input').each((idx, input) => dates.push($(input).val()));


		if(!/\S+/.test(showName)) return; // need a show name
		if(!/\d+/.test(showDuration) || parseInt(showDuration) < 0) return; // need a positive integer show duration
		

		post({
			action: wnf.attr('class'),
			name: showName,
			duration: showDuration,
			dates: dates
		}, data => {
			console.log(data);
			let popup = $(data).find('#connexion-state');
			data = $(data).find('#spectacles').html();

			$('#content').append(popup);

			if(popup.hasClass('success')) {
				wnf.fadeOut(0);
				$('#spectacles').html(data).fadeIn(0);

				// reset values of inputs each time we close the form
				wnf.find('input').each((idx, input) => $(input).val(''));
				$('#area-representations').html("<p class='desc' style='font-size: .8em;'>Aucune date</p>");
			}
		});
	});



	// delete a show
	$('body').on('click', '#delete-spec', function() {
		post({
			action: 'delete',
			noSpec: tableAction.attr('data-id')
		}, data => {
			let popup = $(data).find('#connexion-state');
			$('#content').append(popup);

			if(popup.hasClass('success')) {
				tableAction.remove();
				tableAction = null;
				$('#pannel-spectacle').fadeOut(0);
			}
		});
	});



	// edit a show
	$('body').on('click', '#edit-spec', function() {
		$('#spectacles').fadeOut(0);
		
		wnf.find('h2').text('Modifier un spectacle');
		wnf.removeClass('newShow').addClass('editShow');
		wnf.find('input[type="text"]').val(tableAction.find('tr:first-child td').text().trim());
		wnf.find('input[type="number"]').val(parseInt(tableAction.find('tr:nth-child(2) td').text().trim()));
		
		let dates = tableAction.find('tr:nth-child(3) td').text().trim().split(', ');
		
		dates.forEach(date => {
			let [day, month, year] = date.split('-');

			day = day.toString().padStart(2, 0);
			month = oDates[month];
			year = `20${year}`;

			let formatDate = `${year}-${month}-${day}`;
			console.log(formatDate);

			$(`<input type="date" value="${formatDate}">`).appendTo($('#area-representations'));
		});

		if(dates.length > 0) {
			$('#area-representations p').remove();
		}


		wnf.fadeIn(0);
	});




});

// ajax post function
function post(params, callback=null) {
	$('body').addClass('wait');

	$.post("", params).done(data => {
		$('body').removeClass('wait');
		if(callback) callback(data);
	});
}
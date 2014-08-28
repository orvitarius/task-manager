$(document).ready(function() {
	
	/**
	 * Menu superior
	 *
	 */
	
	$('.fletxa').click(function() {
		$('#selector-projectes').slideToggle();
	})
	
	function currentMenuItem() {
		var url = window.location.href;
		url = url.split('.php')[0];
		url = url.split('/');
		var last = url.length;
		url = url[last-1];
		
		$('.menu-superior .nav .nav-item').each(function() {
			var thisurl = $(this).find('a').attr('href');
			thisurl = thisurl.split('.php')[0];
			if (thisurl == url) {
				$(this).addClass('current-item');
			} else {
				$(this).removeClass('current-item');
			}
		});
	}
	
	
	currentMenuItem();

	
	
	/**
	 * Datepicker setup
	 *
	 */
	
	$('.datepicker').datepicker({
		inline: true,  
        showOtherMonths: true,  
        dayNamesMin: ['Diu', 'Dil', 'Dim', 'Dmc', 'Dij', 'Div', 'Dis'],
        firstDay: 1,
        monthNames: ['Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'],
        dateFormat: "dd/mm/yy",
	});
		
		
		
	/**
	 * Carregar una tasca
	 *
	 */	
	
	$('.tasca-titol').click(function() {
		$('.tasca-descr').slideToggle();
		$('.tasca').toggleClass('amagades');
	});
	 
	$('.tasca-titol').dblclick(function() {
		var numtasc = $(this).attr('id');
		var projecte = projecteActual();
		window.location.href = "index.php?p="+ projecte +"&tasca="+numtasc; 
	});
	
	
	if(tascaActiva()) {
		$('#buttonForm1').attr('name', 'editarTasca');
		$('#buttonForm1').addClass('two-one');
		$('#buttonForm2').css('display', 'block');
	} else {
		$('#buttonForm1').attr('name', 'afegirTasca');
		$('#buttonForm1').removeClass('two-one');
		$('#buttonForm2').css('display', 'none');
	}
	
	
	$('#buttonForm2').click(function() {
		projecte = projecteActual();
		window.location.href = "index.php?p="+projecte;
	});
	
	
	function tascaActiva() {
		var url = window.location.href;
			params = url.split('&tasca=');
			tasca  = params[1];
			if (params.length > 1) {
				activa = true;
			} else {
				activa = false;
			}
		return activa;	
	}
	
	function projecteActual() {
		var url = window.location.href;
			params = url.split('=');
			params = params[1].split('&');
			return params[0];
	}
	
	
	
	
	
	/**
	 * Filtradors
	 *
	 */
	 
	function amagaTasques(idcheckbox) {
		var classetasca = checkers[idcheckbox];
		if($('#'+idcheckbox).is(':checked')) {
			$('.'+classetasca).css('display', 'none');
		} else {
			$('.'+classetasca).css('display', 'block');
		}
	}
	
	function marcaTasques(idcheckbox) {
		var classetasca = checkers[idcheckbox];
		$('.tasca').each(function() {
			if ($(this).hasClass(classetasca)) {
				$(this).addClass('marcades');
			} else {
				$(this).addClass('anti-marcades');
			}
		});
	}
	
	function desmarcaTasques(idcheckbox) {
		var classetasca = checkers[idcheckbox];
		$('.tasca').removeClass('marcades');
		$('.tasca').removeClass('anti-marcades');
	}
	
	function mostraNomes(idcheckbox) {
		var classetasca = checkers[idcheckbox];
		var filtretipus = $('#'+idcheckbox).attr('id');
			filtretipus = filtretipus.split('-')[0];
			
		$('.tasca').each(function() {
			if (!$(this).hasClass(classetasca)) {
				$(this).css('display', 'none');
			}
		});
		$('.checker').each(function() {
			var $input = $(this).find('input');
			var inputid = $input.attr('id');
			var tipus = inputid.split('-')[0];
			if ((tipus == filtretipus) && (inputid != idcheckbox)) {	
				$(this).find('input').attr('checked', false);
				$(this).find('label').addClass('unchecked');
			}
		});
		$('#'+idcheckbox).attr('checked', true);
		$('#'+idcheckbox).siblings('input').attr('checked', true);
	}


	
	$('#filtres .checker label').click(function() {
		$(this).toggleClass('unchecked');
		var checkboxid = $(this).siblings('input').attr('id');
		amagaTasques(checkboxid);
	});
	
	$('#filtres .checker label').mouseover(function() {
		var checkboxid = $(this).siblings('input').attr('id');
		marcaTasques(checkboxid);
	});
	
	$('#filtres .checker label').mouseout(function() {
		var checkboxid = $(this).siblings('input').attr('id');
		desmarcaTasques(checkboxid);
	});
	
	$('#filtres .filtrelabel').mouseover(function() {
		var checkboxid = $(this).next('.checker').find('input').attr('id');
		marcaTasques(checkboxid);
	});
	
	$('#filtres .filtrelabel').mouseout(function() {
		var checkboxid = $(this).next('.checker').find('input').attr('id');
		desmarcaTasques(checkboxid);
	});
	
	$('#filtres .filtrelabel').click(function() {
		var checkboxid = $(this).next('.checker').find('input').attr('id');
		console.log(checkboxid);
		mostraNomes(checkboxid);		
	});
	
	var checkers = { 'est-04' : 'Acabada', 
					 'est-02' : 'Inactiva', 
					 'est-01' : 'Activa',
					 
					 'sub-00001' : 'General', 
					 'sub-00002' : 'Funcionament', 
					 'sub-00003' : 'CSS', 
					 'sub-00004' : 'Testing',
					 
					 'pri-01' : 'molturgent', 
					 'pri-02' : 'urgent', 
					 'pri-03' : 'normal', 
					 'pri-04' : 'pocurgent', 
					 'pri-05' : 'quanpuguis', 
					 'pri-06' : 'nula'			};
					 

	
		
	
	
		
	
	/**
	 * Sidebar
	 *
	 */
	 
	$('#feina-sidebar').click(function() {
		$('.feina').toggleClass('hidden');
		$('.tasques').toggleClass('feina-hidden');
	});
	
	
	
	/**
	 * Drag'n'Drop
	 +
	 */
	
	$('.tasques').sortable({
	    scroll: false
    });
    
    $('.tasques').disableSelection();
    
    
	$( ".tasca" ).droppable({
    	drop: function( event, ui ) {
        	var id_drop = $(this).attr('id');
        		id_drag = $(ui.draggable).attr('id');
        	$.ajax ({
	        	type: 'GET',
	        	data: { drag: id_drag, drop: id_drop },
	        	url: 'queryordretasques.php',
	        }).done(function() {
		       	location.reload();
		    });        	
		}
    });
    
    
    $( "#paperera" ).droppable({
    	drop: function( event, ui ) {
	        var id_drop = $(this).attr('id');
	        	id_drag = $(ui.draggable).attr('id');
	        	
	        $.ajax ({
		        type: 'GET',
		        data: { esborrarTasca: '1', id_tasca: id_drag },
		        url: 'querytasques.php',
	        }).done(function() {
		       	location.reload();
	        });
        }
    });
    
});
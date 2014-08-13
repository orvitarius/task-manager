$(document).ready(function() {
	
	$('.fletxa').click(function() {
		$('#selector-projectes').slideToggle();
	})
	
	
	
	$('.tasca').dblclick(function() {
		$('.tasca').each(function() {
			$(this).removeClass('activada');
		})
		$(this).toggleClass('activada');
	});
	
	
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
	 
	$('.tasca-titol').dblclick(function() {
		var numtasc = $(this).attr('id');
		
		window.location.href = "index.php?p=Reptext&tasca="+numtasc; //CANVIAR PER A QUALSEVOL PROJECTE
	});
	
	
	if(tascaActiva()) {
		$('#buttonForm1').attr('name', 'editarTasca');
		$('#buttonForm1').html('-');
		$('#buttonForm1').addClass('two-one');
		//$('#buttonForm2').addClass('two-two');
		$('#buttonForm2').css('display', 'block');
		//$('.feina').css('min-height', '545px');
	} else {
		$('#buttonForm1').attr('name', 'afegirTasca');
		$('#buttonForm1').html('+');
		$('#buttonForm1').removeClass('two-one');
		//$('#buttonForm2').removeClass('two-two');
		$('#buttonForm2').css('display', 'none');
		//$('.feina').css('min-height', '500px');
	}
	
	
	$('#buttonForm2').click(function() {
		projecte = projecteActual();
		window.location.href = "index.php?p="+projecte;
	});
	
	
	function tascaActiva() {
		var url = window.location.href;
			params = url.split('&tasca=');
			tasca  = params[1];
			//console.log(params.length);
			if (params.length > 1) {
				//console.log('hola');
				activa = true;
			} else {
				activa = false;
			}
		return activa;	
	}
	
	function projecteActual() {
		var url = window.location-href;
			params = url.split('=');
			params = params[1].split('&');
			return params[0];
	}
	
	
	
	
	
	/**
	 *
	 *
	 */
	
	$('#est-04').click(function() {
		if($(this).is(':checked')) {
			$('.Acabada').css('display', 'block');
		} else {
			$('.Acabada').css('display', 'none');
		}
	});
	$('#est-04').mouseover(function() {
		$('.Acabada').css('outline', '4px solid orange');
	});
	$('#est-04').mouseout(function() {
		$('.Acabada').css('outline', 'none');
	});
	
	
	$('#est-02').click(function() {
		if($(this).is(':checked')) {
			$('.Inactiva').css('display', 'block');
		} else {
			$('.Inactiva').css('display', 'none');
		}
	});
	$('#est-02').mouseover(function() {
		$('.Inactiva').css('outline', '4px solid orange');
	});
	$('#est-02').mouseout(function() {
		$('.Inactiva').css('outline', 'none');
	});
	
	$('#est-01').click(function() {
		if($(this).is(':checked')) {
			$('.Activa').css('display', 'block');
		} else {
			$('.Activa').css('display', 'none');
		}
	});
	$('#est-01').mouseover(function() {
		$('.Activa').css('outline', '4px solid orange');
	});
	$('#est-01').mouseout(function() {
		$('.Activa').css('outline', 'none');
	});
	
	$('#sub-00001').click(function() {
		if($(this).is(':checked')) {
			$('.General').css('display', 'block');
		} else {
			$('.General').css('display', 'none');
		}
	});
	$('#sub-00001').mouseover(function() {
		$('.General').css('outline', '4px solid steelblue');
	});
	$('#sub-00001').mouseout(function() {
		$('.General').css('outline', 'none');
	});
	
	$('#sub-00002').click(function() {
		if($(this).is(':checked')) {
			$('.Funcionament').css('display', 'block');
		} else {
			$('.Funcionament').css('display', 'none');
		}
	});
	$('#sub-00002').mouseover(function() {
		$('.Funcionament').css('outline', '4px solid steelblue');
	});
	$('#sub-00002').mouseout(function() {
		$('.Funcionament').css('outline', 'none');
	});
	
	$('#sub-00003').click(function() {
		if($(this).is(':checked')) {
			$('.CSS').css('display', 'block');
		} else {
			$('.CSS').css('display', 'none');
		}
	});
	$('#sub-00003').mouseover(function() {
		$('.CSS').css('outline', '4px solid steelblue');
	});
	$('#sub-00003').mouseout(function() {
		$('.CSS').css('outline', 'none');
	});
	
	$('#sub-00004').click(function() {
		if($(this).is(':checked')) {
			$('.Testing').css('display', 'block');
		} else {
			$('.Testing').css('display', 'none');
		}
	});
	$('#sub-00004').mouseover(function() {
		$('.Testing').css('outline', '4px solid steelblue');
	});
	$('#sub-00004').mouseout(function() {
		$('.Testing').css('outline', 'none');
	});
	
	$('#pri-01').click(function() {
		if($(this).is(':checked')) {
			$('.molturgent').css('display', 'block');
		} else {
			$('.molturgent').css('display', 'none');
		}
	});
	$('#pri-01').mouseover(function() {
		$('.molturgent').css('outline', '4px solid yellowgreen');
	});
	$('#pri-01').mouseout(function() {
		$('.molturgent').css('outline', 'none');
	});
	
	$('#pri-02').click(function() {
		if($(this).is(':checked')) {
			$('.urgent').css('display', 'block');
		} else {
			$('.urgent').css('display', 'none');
		}
	});
	$('#pri-02').mouseover(function() {
		$('.urgent').css('outline', '4px solid yellowgreen');
	});
	$('#pri-02').mouseout(function() {
		$('.urgent').css('outline', 'none');
	});
	
	$('#pri-03').click(function() {
		if($(this).is(':checked')) {
			$('.normal').css('display', 'block');
		} else {
			$('.normal').css('display', 'none');
		}
	});
	$('#pri-03').mouseover(function() {
		$('.normal').css('outline', '4px solid yellowgreen');
	});
	$('#pri-03').mouseout(function() {
		$('.normal').css('outline', 'none');
	});
	
	$('#pri-04').click(function() {
		if($(this).is(':checked')) {
			$('.pocurgent').css('display', 'block');
		} else {
			$('.pocurgent').css('display', 'none');
		}
	});
	$('#pri-04').mouseover(function() {
		$('.pocurgent').css('outline', '4px solid yellowgreen');
	});
	$('#pri-04').mouseout(function() {
		$('.pocurgent').css('outline', 'none');
	});
	
	$('#pri-05').click(function() {
		if($(this).is(':checked')) {
			$('.quanpuguis').css('display', 'block');
		} else {
			$('.quanpuguis').css('display', 'none');
		}
	});
	$('#pri-05').mouseover(function() {
		$('.quanpuguis').css('outline', '4px solid yellowgreen');
	});
	$('#pri-05').mouseout(function() {
		$('.quanpuguis').css('outline', 'none');
	});
	
	$('#pri-06').click(function() {
		if($(this).is(':checked')) {
			$('.nula').css('display', 'block');
		} else {
			$('.nula').css('display', 'none');
		}
	});
	$('#pri-06').mouseover(function() {
		$('.nula').css('outline', '4px solid yellowgreen');
	});
	$('#pri-06').mouseout(function() {
		$('.nula').css('outline', 'none');
	});
	
	
	
	
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
	
	$(".tasca").draggable();
	
	$( ".tasca" ).droppable({
      drop: function( event, ui ) {
        //alert('holaaa');
        var id_drop = $(this).attr('id');
        	id_drag = $(ui.draggable).attr('id');
        	//alert(id_drop);
        	//alert(id_drag);
        	$.ajax ({
	        	type: 'GET',
	        	data: { drag: id_drag, drop: id_drop },
	        	url: 'queryordretasques.php',
        	}).done(function() {
	        	location.reload();
        	});
        	
        	//window.location.href = "queryordretasques.php?drag="+id_drag+"&drop="+id_drop;
      }
    });
    
    
    $( "#paperera" ).droppable({
    	drop: function( event, ui ) {
        //alert('holaaa');
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
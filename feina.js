$(document).ready(function() {
	
	/**
	 * -------------------------
	 * FUNCIONAMENT DEL RELLOTGE
	 * -------------------------
	 */
	
	/**
	 * Netejar agulla marcada amb TRUE
	 *
	 */
	 
	function clearAgulla(sec, min, hour, container, separacio) {
		var posicioMarcador = separacio + 'px';
		if (sec) {
			container.find('.segons').find('.sec').remove();
			container.find('.segons').find('.end').css('left', posicioMarcador);
		}
		if (min) {
			container.find('.minuts').find('.min').remove();
			container.find('.minuts').find('.end').css('left', posicioMarcador);
		}
		if (hour) {
			container.find('.hores').find('.hor').remove();
			container.find('.hores').find('.end').css('left', posicioMarcador);
		}
	}
	
	/**
	 * Imprimir ticks de les agulles
	 *
	 */
	  
	function printTick(rellotgeID, agulla, posiciotick, separacio) {
		var $rellotge = $('#'+rellotgeID);
		var classagulla = '.'+agulla;
		var posicioMarcador = posiciotick + 2 * separacio;
		var classtick = '';
		var posiciotick = posiciotick + 'px';
			posicioMarcador = posicioMarcador + 'px';
			
		if (agulla == 'segons') {
			classtick = 'sec';
		} else if (agulla == 'minuts') {
			classtick = 'min';
		} else if (agulla == 'hores') {
			classtick = 'hor';
		}
		
		$rellotge.find(classagulla).find('.end').before('<div class="tick ' + classtick + '" style="left:' + posiciotick + '"></div>');
		$rellotge.find(classagulla).find('.end').css('left', posicioMarcador);	
	}

	function printTickSegon(rellotgeID, separacio, timer) {
		var left = timer.seconds * separacio;
		var $rellotge = $('#'+rellotgeID);
		if (timer.seconds == 0 ) {
			clearAgulla(true,false,false, $rellotge, separacio);
			left = 0;
		}
		if (timer.seconds > 0) {
			printTick(rellotgeID, 'segons', left, separacio);
		}
		return false;
	}
		
	function printTickMinut(rellotgeID, separacio, timer) {
		var left = timer.minutes * separacio;
		var $rellotge = $('#'+rellotgeID);
		if (timer.minutes == 0 ) {
			clearAgulla(false,true,false, $rellotge, separacio);
			left = 0;
		}
		if (timer.minutes > 0) {
			printTick(rellotgeID, 'minuts', left, separacio);
		}
		return false;
	}
	
	function printTickHora(rellotgeID, separacio, timer) {
		var left = timer.hours * separacio;
		var $rellotge = $('#'+rellotgeID);
		if (timer.hours == 0 ) {
			clearAgulla(false,false,true, $rellotge, separacio);
			left = 0;
		}
		if (timer.hours > 0) {
			printTick(rellotgeID, 'hores', left, separacio);
		}
		return false;
	}
	
	/**
	 * Numero en dos digits
	 *
	 */	
	
	function dosdigits(num) {
		var c = parseInt(num, 10);
		return (c<10) ? "0"+c : c;
	}
	
	/**
	 * Comptar un segon del rellotge
	 *
	 */
	 
	function countClock(timer, separacio) {
		timer.secondUp();
		var sec = dosdigits(timer.seconds);
			min = dosdigits(timer.minutes);
			hor = dosdigits(timer.hours);
		$('#secs').val(sec);
		$('#mins').val(min);
		$('#hores').val(hor);
		printTickSegon(containerID, separacio, timer);
		if (timer.seconds == 0) {
			printTickMinut(containerID, separacio, timer);
		}
		if (timer.minutes == 0 && timer.seconds == 0) {
			printTickHora(containerID, separacio, timer)
		}
		return false;
	};
	
	/**
	 * Start
	 *
	 */
	 
	function startclock() {
		clocker = setInterval(function() {
			countClock(timer, separacio);
		}, 1000);
		return clocker;
	}
	
	/**
	 * Reiniciar rellotge
	 *
	 */
	 
	function reiniciarRellotge(container) {
		$('#secs').val('00');
		$('#mins').val('00');
		$('#hores').val('00');
		timer.seconds = 0;
		timer.minutes = 0;
		timer.hours = 0;
		clearAgulla(true, true, true, container, separacio);
		$('#stop').addClass('reset');
		$('.time').removeClass('paused');
		$('.time').removeClass('running');
		return false;
	}

	/**
	 * Funcions botons rellotge
	 *
	 */
	 
	$('#stop').click(function() {
		clearInterval(clocker);
		if ($(this).hasClass('reset')) {
			var container = $('#'+containerID);
			reiniciarRellotge(container);
		} else {
			$(this).addClass('reset');
			$('.time').addClass('paused');
			$('.time').removeClass('running');
		}
		return false;
	});
	
	$('#start').click(function() {
		startclock();
		$('#stop').removeClass('reset');
		$('.time').addClass('running');
		$('.time').removeClass('paused');
	});
	
		
	/*
	 * Configuracio rellotge
	 *
	 */
		
	var separacio = 7;
	var containerID = 'rellotge1';
	var timer = clock; // Variable de tipus clock (clock.js)
	
	
	
	
	
	
	
	
	/**
	 * --------------------------
	 * TAULA DE SESSIONS DE FEINA
	 * --------------------------
	 */
	 
	/**
	 * Converors minuts <--> XXh YYm
	 *
	 */
	
	function string2minuts(temps) {
		var tempsm = temps.split('h');
		var hores = tempsm[0] * 60;
		var mins  = tempsm[1].split(' ');
			mins  = mins[1].split('m');
			mins  = mins[0] * 1;
		return hores + mins; 
	}
	
	function minuts2string(minuts) {
		var h = Math.floor(minuts / 60);
			m = minuts % 60;
		
			temps = h+"h "+m+"m";
		return temps;
	}
	
	/**
	 * Total temps linies seleccionades
	 *
	 */
	 
	function totalTempsSeleccio() {
		var temps = 0;
		totalSeleccio = 0;
		$('#sessions-table').find('.seleccionada').each(function() {
			temps = $(this).find('.temps').html();
			temps = string2minuts(temps);
			totalSeleccio += temps;
		});
		if (temps == 0) {
			totalSeleccio = 0;
			$('#sessions-table').find('.temps').each(function() {
				temps = $(this).html();
				temps = string2minuts(temps);
				totalSeleccio += temps;
			});
		}
	}
	
	
	/**
	 * Seleccionar linies
	 *
	 */
	 
	totalSeleccio = 0;
	
	$('#sessions-table').find('td').click(function() {
		$(this).parent('tr').toggleClass('seleccionada');
		totalTempsSeleccio();
		$('.total').find('.temps').html(minuts2string(totalSeleccio));
	});
	
	
	/**
	 * Filtrar comentaris
	 *
	 */
	
	$('#commentsearch').click(function() {
		if($(this).hasClass('coment-icon-blank')) {
			$(this).removeClass('coment-icon-blank');
			$(this).addClass('coment-icon-green');
			$('#sessions-table').find('.no-comen').parent('tr').css('visibility','hidden');
			return true;
		}
		if($(this).hasClass('coment-icon-green')) {
			$(this).removeClass('coment-icon-green');
			$(this).addClass('coment-icon-red');
			$('#sessions-table').find('tr').css('visibility', 'visible');
			$('#sessions-table').find('.comen').not('.no-comen').parent('tr').css('visibility','hidden');
			return true;
		}
		if($(this).hasClass('coment-icon-red')) {
			$(this).removeClass('coment-icon-red');
			$(this).addClass('coment-icon-blank');
			$('#sessions-table').find('tr').css('visibility', 'visible');
			return true;
		}
	});
	
	
	/**
	 * Veure comentaris TODO --> ajustar posicio
	 *
	 */
	
	$('.coment-icon').hover(function() {
		var parent = $(this).parent('.comen');
		var	row = parent.parent('tr');
		var pos = row.offset();
		var toprow = pos.top;
		var containerheight = $('.scrollbody').css('height');
			containerheight = containerheight.split('px')[0];
		var limitPercent = .5;
			containerheight *= limitPercent;
			containerheight += 100;
		console.log(containerheight);
		if (pos.top < containerheight) {
			var top = toprow - 50;
		} else {
			var commentheight = $('.popupcomment').css('height');
				commentheight = commentheight.split('px')[0];
			var top = toprow - commentheight - 50;
		}
		
		if (!parent.hasClass('no-comen')) {
			var text = parent.find('p').text();
			$('.popupcomment').css('top', top);
			$('.popupcomment').find('p').text(text);
			$('.popupcomment').fadeIn();
		} else {
			$('.popupcomment').find('p').text('');
		}
	});
	
	$('.coment-icon').mouseout(function() {
		$('.popupcomment').fadeOut();
	});

});
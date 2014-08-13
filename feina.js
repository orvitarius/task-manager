$(document).ready(function() {
	
	var timer = clock;
	
	timer.secondUp();
	timer.setClock();
	//timer.start();
	
	function countClock(timer) {
		timer.secondUp();
		var sec = dosdigits(timer.seconds);
			min = dosdigits(timer.minutes);
			hor = dosdigits(timer.hours);
		$('#secs').val(sec);
		$('#mins').val(min);
		$('#hores').val(hor);
		printSegon($('.segons'));
		if (timer.seconds == 0) {
			printMinut($('.minuts'));
		}
		printHora($('.hores'));
		return false;
	};
	
	function startclock() {
		$('#stop').removeClass('reset');
		//$('#stop').val('Stop');	
		clocker = setInterval(function() {
			countClock(timer);
		}, 1000);
		return clocker;
	}
	
	
	$('#stop').click(function() {

		clearInterval(clocker);
		
		if ($(this).hasClass('reset')) {
			var container = $('#rellotge1');
			reiniciarRellotge(container);
		} else {
			//$(this).val('Reset');
			$(this).addClass('reset');
		}
		
		//$(this).toggleClass('reset');
	});
	
	$('#start').click(function() {
		startclock();
	});
	
	function reiniciarRellotge(container) {
		$('#secs').val('00');
		$('#mins').val('00');
		$('#hores').val('00');
		timer.seconds = 0;
		timer.minutes = 0;
		timer.hours = 0;
		clear(true, true, true, container);
		$('#stop').addClass('reset');
		//$('#stop').val('Reset');
	}
	
		
	//$('#secs').click(function() {
	//	clearInterval(clocker);
	//});
	
	//startclock();
	
	function printSegon(container) {
		var left = timer.seconds * 7;
			leftend = left + 14;
		var supercontainer = $('#rellotge1');
		if (timer.seconds == 0 ) {
			clear(true,false,false, supercontainer);
			left = 0;
			leftend = 0;
		}
		left = left + 'px';
		if (timer.seconds > 0) {
			container.find('.end').before('<div class="tick sec" style="left:' + left + '"></div>');
			container.find('.end').css('left', leftend);
		}
	}
	
	function printMinut(container) {
		var left = timer.minutes * 7;
			leftend = left + 14;
		var supercontainer = $('#rellotge1');
		if (timer.minutes == 0 ) {
			clear(false,true,false, supercontainer);
			left = 0;
		}
		left = left + 'px';
		if (timer.minutes > 0) {
			//container.append('<div class="tick min" style="left:' + left + '"></div>');
			container.find('.end').before('<div class="tick min" style="left:' + left + '"></div>');
			container.find('.end').css('left', leftend);
		}
	}
	
	function printHora(container) {
		var left = timer.hours * 7;
			leftend = left + 14;
		left = left + 'px';
		if (timer.hours > 0) {
			container.append('<div class="tick hor" style="left:' + left + '"></div>');
		}
	}
	
	function clear(sec, min, hour, container) {
		if (sec) {
			//console.log(container);
			container.find('.segons').find('.sec').remove();
			container.find('.segons').find('.end').css('left', '7px');
		}
		
		if (min) {
			container.find('.minuts').find('.min').remove();
			container.find('.minuts').find('.end').css('left', '7px');
		}
		
		if (hour) {
			container.find('.hores').find('.hor').remove();
			container.find('.hores').find('.end').css('left', '7px');
		}
		
		
	}
	
	function dosdigits(num) {
		var c = parseInt(num, 10);
		return (c<10) ? "0"+c : c;
	}
	
	
	
	
	
	
	
	//Taula
	
	totalSeleccio = 0;
	
	$('#sessions-table').find('td').click(function() {
		$(this).parent('tr').toggleClass('seleccionada');
		totalTempsSeleccio();
		console.log(totalSeleccio);
		$('.total').find('.temps').html(minutsAtemps(totalSeleccio));
	});
	
	function totalTempsSeleccio() {
		//console.log('ttS');
		var temps = 0;
		totalSeleccio = 0;
		$('#sessions-table').find('.seleccionada').each(function() {
			console.log('sel');
			temps = $(this).find('.temps').html();
			temps = tempsAMinuts(temps);
			totalSeleccio += temps;
		});
		if (temps == 0) {
			totalSeleccio = 0;
			$('#sessions-table').find('.temps').each(function() {
				temps = $(this).html();
				temps = tempsAMinuts(temps);
				totalSeleccio += temps;
			});
		}
	}
	
	function tempsAMinuts(temps) {
		var tempsm = temps.split('h');
		var hores = tempsm[0] * 60;
		var mins  = tempsm[1].split(' ');
			mins  = mins[1].split('m');
			mins  = mins[0] * 1;
			
		return hores + mins; 
	}
	
	function minutsAtemps(minuts) {
		var h = Math.floor(minuts / 60);
			m = minuts % 60;
		
			temps = h+"h "+m+"m";
			return temps;
	}
	
	
	
	
	$('#commentsearch').click(function() {
		console.log('kd');
		//var that = $(this);
		//3classToggle(that, 'coment-icon-blank', 'coment-icon-green', 'coment-icon-red');
		if($(this).hasClass('coment-icon-blank')) {
			$(this).removeClass('coment-icon-blank');
			$(this).addClass('coment-icon-green');
			$('#sessions-table').find('.no-comen').parent('tr').css('visibility','hidden');
			//$('#sessions-table').find('.no-comen').parent('tr').find('td').css('height','0');
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
			//$('#sessions-table').find('tr').find('td').css('height', '30px');
			return true;
		}
	});
	

});
$(document).ready(function() {
	
	function percentCompletades(id_sub) {
		var total = $('#total-0000'+id_sub).val();
		var fetes = $('#fetes-0000'+id_sub).val();
		if (total != 0) {
			return fetes/total * 100;
		} else {
			return 0;
		}
	}
	
	
	function printTicksPercent(thicktick, separation, id_sub) {
		var id = '#barra-0000'+id_sub;
		var tWidthpx = $(id).width(); //450px
		var tWidthTickpx = thicktick + separation; //9px
		var ticks = tWidthpx / tWidthTickpx; //50
		var percent = percentCompletades(id_sub); // x exemple 9,09090909..
		ticks = ticks * percent / 100; // 50 * 9,09090909 / 100 = 4,54545454
		ticks = Math.floor(ticks) // 4
		percent = Math.round(percent);
		
		//FER FUNCIO
		if(percent == 100) {
			$(id).find('.percent').addClass('complet');
			$(id).find('.end').css('display', 'none');
			$(id).parents('.estad').addClass('centpercent');
		} else {
			$(id).find('.percent').removeClass('complet');
			$(id).find('.end').css('display', 'block');
		}
		
		
		if(percent <= 50) {
			$(id).parents('.estad').addClass('interval2');
		}
		
		if(percent <= 25) {
			$(id).parents('.estad').addClass('interval1');
		}
		
		if(percent == 0) {
			$(id).parents('.estad').addClass('interval0');
		}
		
		percent = percent + '%';
		for(var i = 0; i < ticks; i++) {
			left = tWidthTickpx * i;
			$(id).append('<div class="tick" style="left:'+left+'px"></div>');
			$(id).find('.end').css('left', left+12);
			$(id).find('.percent').css('left', left+25);
			$(id).find('.percent').html(percent);
		}
		return false;
	}
	
	
	function printTicksPercentTotal(thicktick, separation) {
		var $totalest = $('.total');
		var $barra = $totalest.find('.barra');
		var tasques = 0;
		var fetes   = 0;
		$('.tTotal').each(function() { tasques += $(this).val() * 1; }); 
		$('.tFetes').each(function() { fetes   += $(this).val() * 1; }); 
		var percent = fetes / tasques * 100;
		var tWidthpx = $barra.width(); 
		var tWidthTickpx = thicktick + separation;
		var ticks = tWidthpx / tWidthTickpx; 
		ticks = ticks * percent / 100;
		ticks = Math.floor(ticks); 
		percent = Math.round(percent);
		percent = percent + '%';
		for(var i = 0; i < ticks; i++) {
			left = tWidthTickpx * i;
			$barra.append('<div class="tick" style="left:'+left+'px"></div>');
			$barra.find('.percent').css('left', left+25);
			$barra.find('.percent').html(percent);
			$barra.find('.end').css('left', left+12);
		}
		return false;
	}
	
	
	var thicktick = 7;
	var separation = 2;
	
	//TODO --> Automatitzar
	
	printTicksPercent(thicktick, separation, 00001);
	printTicksPercent(thicktick, separation, 00002);
	printTicksPercent(thicktick, separation, 00003);
	printTicksPercent(thicktick, separation, 00004);
	
	printTicksPercentTotal(thicktick, separation);
	
	
	
	
	function percentDies() {
		var diesInici = $('#dataInici').find('.dies').html();
		var diesLimit = $('#dataLimit').find('.dies').html();
		diesInici = diesInici.split(' ')[1];
		diesLimit = diesLimit.split(' ')[1];
		var totaldies = diesInici*1 + diesLimit*1;		
		var percent = Math.round(diesInici * 100 / totaldies);
		return percent;
	}
	
	function printTicksDies(thcktick, separation) {
		var $barra = $('.percentatgeTemps');
		var percent = percentDies();
		
		var tWidthpx = $barra.width(); 
		var tWidthTickpx = thicktick + separation;
		var ticks = tWidthpx / tWidthTickpx; 
		ticks = ticks * percent / 100;
		ticks = Math.floor(ticks); 
		percent = Math.round(percent);
		percent = percent + '%';
		for(var i = 0; i < ticks; i++) {
			left = tWidthTickpx * i;
			$barra.append('<div class="tick" style="left:'+left+'px"></div>');
			$barra.find('.percent').css('left', left+25);
			$barra.find('.percent').html(percent);
			$barra.find('.end').css('left', left+12);
		}
		return false;

	}
	
	printTicksDies(thicktick, separation);
	
});
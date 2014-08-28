<div class="menu-superior">
	
	<!-- SELECTOR DE PROJECTES -->
	
	<!-- $projecte ve de funcions.php -->
	
	<a class="titol-projecte" href="index.php?p=<?php echo $projecte; ?>"><?php echo $projecte; ?></a>
	
	<svg height="20" width="20" class="fletxa">
	    <polyline fill="none" stroke="darkred" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points = "0,0 8,12 16,0" />
	</svg>
	
	<ul class="selector" id="selector-projectes">
	    <?php omplirMenuProjectes($db); ?>
	</ul>
	
	<!-- NAVIGATOR -->
	
	<ul class="nav">
		<li class="nav-item" id="feina"		><a href="feina.php?p=<?php		echo $projecte; ?>"></a></li>
		<li class="nav-item" id="tasques"	><a href="index.php?p=<?php		echo $projecte; ?>"></a></li>
		<li class="nav-item" id="projecte"	><a href="projecte.php?p=<?php	echo $projecte; ?>"></a></li>
	</ul>
</div>
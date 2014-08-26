<div class="menu-superior">
	<a class="titol-projecte" href="index.php?p=<?php echo $projecte; ?>"><?php echo $projecte; ?></a>
	
	<svg height="20" width="20" class="fletxa">
	    <polyline fill="none" stroke="darkred" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
	    	points =	"0,0
	    				 8,12
	    				 16,0" />
	</svg>
	
	
	<ul class="selector" id="selector-projectes">
	    <?php
	    $query = $db->query("SELECT nom FROM projectes");
	    while ($proj = $db->fetch_array($query)) {
	    	echo '<li><a href="index.php?p='.$proj['nom'].'">'.$proj['nom'].'</a></li>';
	    }
	    ?>
	</ul>
	
	<!--<a class="button afegir" id="nova-feina" href="feina.php?p=<?php echo $projecte; ?>">+</a>-->
</div>
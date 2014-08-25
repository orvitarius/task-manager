<!DOCTYPE html>

<html>

<head>

	<meta charset="utf-8" />
	
	<meta name="viewport" content="width=device-width" />
	<link rel="shortcut icon" href="images/favicon.png" />
	
	<title>Task Manager</title>
	
	
	<!-- JQUERY -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	
	
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/inici.css" />
	<link rel="stylesheet" href="css/publica.css" />
	<link rel="stylesheet" href="css/feina.css" />

	
	
</head>

<body class="publica">

	<section class="header">		
		<img id="logoprincipal" src="images/logo.png" />
	</section>
	
	<section class="content">
		
		<section class="tasques tasques-publica">
		
			<div class="tasca" id="tasca1">
				<span class="tasca-titol">Remember</span>
				<p class="tasca-descr"></p>
			</div>
			<div class="tasca" id="tasca2">
				<span class="tasca-titol" id="">Organize</span>
				<p class="tasca-descr"></p>
			</div>
			<div class="tasca" id="tasca3">
				<span class="tasca-titol" id="">Time</span>
				<p class="tasca-descr"></p>
			</div>

		</section>
	</section>
	

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>

</html>
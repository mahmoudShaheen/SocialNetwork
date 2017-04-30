<html>
	<head>
		<title>CSE-ZU Social Network</title>
		<link href="../../stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>CSE-ZU Social Network: Admin Area</h1>
			<?php
				//show log out link if user logged in
				require_once(dirname(__DIR__)."/includes/session.php"); 
				if (logged_in_as()){
					echo "<div align=\"right\">";
					echo "<a href=\"../logout.php\">Log out</a>";
					echo "</div>";
				}
			
			?>
		</div>
		<div id="main">

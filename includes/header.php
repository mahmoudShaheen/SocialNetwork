<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CSE-ZU Social Network</title>
		<!-- Bootstrap -->
    	<link href="../../stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
    	<!-- Css -->
    	<link rel="stylesheet" href="../../stylesheets/style.css" type="text/css">
        <link rel="stylesheet" href="../../stylesheets/font-awesome.min.css" type="text/css">
        <link rel="shortcut icon" href="../../images/bb.gif" type="image/x-icon">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="../../javascripts/jquery.js"></script>

	</head>
	<body>
		<div id="header">
			<div id="navbar">
			<nav class="navbar navbar-inverse navbar-fixed-top">
				
			    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      	</button>
				      	<a class="navbar-brand active" href="#"> CSE Network</a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					    <form class="navbar-form navbar-left" role="search">
					        <div class="input-group">
					        	<input type="text" class="form-control" placeholder="Search..." aria-describedby="basic-addon1">
							    <span class="input-group-addon" id="basic-addon1">
							    	<i class="fa fa-search" aria-hidden="true"></i>
							    </span>
							</div>
					    </form>
				      	<ul class="nav navbar-nav navbar-right list">
					        <li><a href="profile.php"><img src="../../images/bb.gif" width="20" height="20"><?php
								require_once(dirname(__DIR__)."/includes/social_functions.php"); 
								$user_id = $_SESSION['user_id'];
									$user = get_user_data($user_id);
									 if( $user_row = mysqli_fetch_assoc($user)) {
										echo htmlentities($user_row["username"]);
									 }
							?></a></li>
						    <li role="presentation">
							    <a href="index.php">
								    <i class="fa fa-home" aria-hidden="true"></i> Home
								    <span class="badge">42</span>
							    </a>
						    </li>
						   
						    <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-comment" aria-hidden="true"></i>
								    <span class="badge">3</span></a>
					          <ul class="dropdown-menu">
					            <li><a href="gset.html">General setting</a></li>
					            <li><a href="#">Another action</a></li>
					            <li><a href="#">Something else here</a></li>
					            <li role="separator" class="divider"></li>
					            <li><a href="../../pages/home/logout.php">Log out</a></li>
					          </ul>
				        	</li>
						    <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell" aria-hidden="true"></i>
								    <span class="badge">33</span></a>
					          <ul class="dropdown-menu">
					            <li><a href="gset.html">General setting</a></li>
					            <li><a href="#">Another action</a></li>
					            <li><a href="#">Something else here</a></li>
					            <li role="separator" class="divider"></li>
					            <li><a href="../../pages/home/logout.php">Log out</a></li>
					          </ul>
				        	</li>
				        	
						    
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog" aria-hidden="true"></i> <span class="caret"></span></a>
					          <ul class="dropdown-menu">
					            <li><a href="gset.html">General setting</a></li>
					            <li><a href="#">Another action</a></li>
					            <li><a href="#">Something else here</a></li>
					            <li role="separator" class="divider"></li>
					            <li><a href="../../pages/home/logout.php">Log out</a></li>
					          </ul>
				        	</li>
				      	</ul>
				    </div><!-- /.navbar-collapse -->
			 	</div> <!-- /.container-->
			</nav>
			</div>
		
			<?php
				//show log out link if user logged in
				require_once(dirname(__DIR__)."/includes/session.php"); 
				if (logged_in_as()){
					echo "<div align=\"right\">";
					echo "<a href=\"../home/logout.php\">Log out</a>";
					echo "</div>";
				}
			
			?>
		</div>
		<div id="main">

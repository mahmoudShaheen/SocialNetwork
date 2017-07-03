<?php require_once("../../includes/crud_labs.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php require_once("../../includes/social_functions.php"); ?>

<?php
	confirm_logged_in();
?>

<?php
	if(admin_check()){ //user is admin
		include("../../includes/header_admin.php");
		include("../../includes/sidebar_admin.php");
	}else{ //normal user
		include("../../includes/header.php");
		include("../../includes/sidebar.php");
	}
?>
		<!-- Page Content -->
		
				
			
		<div class="table">
			<div class="container">
			<table id="structure">
<?php

    $all_labs = read_all_labs($read_all_labs_stmt);
echo '<table ><tr><th>Username</th><th>Content</th><th>Location</th><th>About</th></tr>';
    while ($one_lab = $all_labs->fetch_assoc()) {

		$result_set = get_user_data($one_lab['user_id']);
		$user_data  = mysqli_fetch_assoc($result_set);
		echo '<tr><td>'.$user_data['username'].'</td><td>'.$one_lab['name'].'</td><td>'.$one_lab['location'].'</td><td>'.$one_lab['about'].'</td></tr>';
    }

 ?></table></div></div>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>

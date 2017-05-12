<?php require_once("../../includes/labs_includes/crud_labs.php"); ?>
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

<?php

    $all_labs = read_all_labs($read_all_labs_stmt);

    while ($one_lab = $all_labs->fetch_assoc()) {

		$result_set = get_user_data($one_lab['user_id']);
		$user_data  = mysqli_fetch_assoc($result_set);

        echo htmlentities($user_data['username']);          // user_name entry
        echo htmlentities($one_lab['name']);                // content entry
        echo htmlentities($one_lab['location']);            // location entry
        echo htmlentities($one_lab['about']);               // about entry
    }

 ?>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>

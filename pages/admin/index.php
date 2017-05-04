<?php require_once("../../includes/session.php"); ?>
<?php 
	confirm_logged_in(); 
	confirm_admin();
?>
<?php 
//page to add ref. to other administrator pages.
?>
<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>
<ul>
<li><a href="add_admin.php">Add Admin</a></li>
<li><a href="add_user.php">Add User</a></li>
<li><a href="change_password.php">Change Password</a></li>
<li><a href="college_role.php">Change Collge Role</a></li>
<ul>
<?php include("../../includes/footer.php"); ?>
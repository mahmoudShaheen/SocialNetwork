<?php
require_once("Functionforphp.php");

$errors = array();
$message = "";
$username = "";
$password = "";
if(isset($_POST['submit'])){
	// Form was submitted
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	
	// Validations
	$fields_required = array("username", "password");
	foreach($fields_required as $filed){
		$value = trim($_POST[$filed]);
		if(!ckempty($value)){
		$errors[$filed] = ucfirst($filed) . " can't be blank.";
		}
	}
	
	if(empty($errors)){
		if($username == "root" && $password == "root"){
			redirect_to("hello.php");
		}else {
		$message = "Username/Passoword do not match.";
	} 
	} else {
		$username = "";
		$message = "Please log in. ";
	}
}
?>

<html leng="en">
 <head>
   <title>Form</title>
 <head>
 <body>
	
	<?php echo $message; ?><br />
	<?php echo form_errors($errors)?>
	<form action="login.php" method="post">
	  Username:<input type="text" name="username" value="<?php echo htmlspecialchars($username);?>" /><br />
	  Passoword:<input type="password" name="password" value=""/><br />
	  <br />
	  <input type="submit" name="submit" value="Submit" />
	  </form>
 </body>
</html>
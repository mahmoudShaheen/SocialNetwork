<?php
// Redirect to another location 
function redirect_to($new_location){
header("Location:" .$new_location);
exit;
}
?>

<?php
function form_errors($errors=array()){
	$output = "";
	if(!empty($errors)){
		//$output .= "div class=\"error\">";
		$output .= "Please fix the following errors";
		$output .= "<ul>";
		foreach ( $errors as $key => $error) {
			$output .= "<li>{$error}</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";
	}
	return $output;
}
?>

<?php
// // check if the field is empty or not
 function ckempty($value){
	return isset($value) && $value!== "";
}
// // check type
function cktype($value){
	return is_string($value);
}
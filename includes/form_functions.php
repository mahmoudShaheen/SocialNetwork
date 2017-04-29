<?php require_once("functions.php"); ?>
<?php
	//File for forms validation functions
	
	//check if any required field is empty
	//returns an array of empty required fields
	function check_required_fields($required_array) {
		$field_errors = array();
		foreach($required_array as $fieldname) {
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]))) { 
				$field_errors[] = $fieldname; 
			}
		}
		return $field_errors;
	}

	//check maximum field length
	//returns an array of fields exceed the maximum length
	function check_max_field_lengths($field_length_array) {
		$field_errors = array();
		foreach($field_length_array as $fieldname => $maxlength ) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { 
				$field_errors[] = $fieldname; 
			}
		}
		return $field_errors;
	}

	//check minimum field length
	//returns an array of fields less than minimum length
	function check_min_field_lengths($field_length_array) {
		$field_errors = array();
		foreach($field_length_array as $fieldname => $minlength ) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) < $minlength) { 
				$field_errors[] = $fieldname; 
			}
		}
		return $field_errors;
	}
	
	//display the errors sent as array
	function display_errors($error_array) {
		echo "<p class=\"errors\">";
		echo "Please review the following fields:<br />";
		foreach($error_array as $error) {
			echo " - " . $error . "<br />";
		}
		echo "</p>";
	}

?>
<?php
//encodes string for html
 function html_encode($string){
	return htmlspecialchars($string);
}
?>

<?php
//encodes URLs
 function url_encode($string){
	return rawurlencode($string);
}
?>


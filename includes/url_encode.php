<?php
//page the link will lead to it 
$url_page = 'login.php';  
$linktext = "go to login screen";
?>

<?php
// this gives you a clean link to use
$url = "http://localhost/";
$url .= rawurlencode($url_page);
?>

<a href="<?php 
// htmlspecialchars escapes any html that 
// might do bad things to your html page
echo htmlspecialchars($url); 
?>">
<?php 
echo htmlspecialchars($linktext); 
?>
</a>
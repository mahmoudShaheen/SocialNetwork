<?php

?>

<html>
<head>
	<title> Chat Box </title>
	<link href="chat.css" rel="stylesheet" type="text/css"  />
	<script src="jquery-1.9.0.js"></script>
	<script>
		function submitChat(){
			if(form1.uname.value == '' || form1.msg.value == ''){
				alert('All fields are mandatory !!!');
				return;
			}
			var uname = form1.uname.value;
			var msg = form1.msg.value;
			var xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status==200){
					document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
					form1.msg.value ='';
				}
			}
			xmlhttp.open('GET','insert.php?uname='+uname+'&msg='+msg,true);
			xmlhttp.send();
			
		}
		
		$(document).ready(function(e) {
			$.ajaxSetup({cache:false});
			setInterval(function(){$('#chatlogs').load('logs.php');},1000);
		});
	</script>
	
</head>
<body>
	<h1> Welcome to chat try </h1>
	<form name="form1" id="form1">
		<input type="text" name="uname" id="uname"/> <br />
		<div id="chatlogs" name="chatlogs">
		LOADING CHATLOGS PLEASE WAIT...
		</div>
		<br />
		<textarea name="msg" id="msg" ></textarea> <br />
		<a href="#" onclick="submitChat()">Send</a> <br /> <br />
		
		
	</form>
</body>
</html>
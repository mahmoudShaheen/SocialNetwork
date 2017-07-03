<?php 
	//check if user logged in
	//if not redirect to login page
require_once("../../includes/session.php"); 
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
	//if user tries to enter admin area
	//user will be redirected here
	//with permission denied message
	if (isset($_GET['permission']) && $_GET['permission'] == 1) {
		$message = "Permission Denied!.";
		if (!empty($message)) {
			echo "<p class=\"message\">" . $message . "</p>";
		}
	}
	?>
	<?php
	//get page number from query string to show post 10 posts per page
	//page numbers starts from zero for first page
	if (isset($_GET['page']) ) {
		$page_number = $_GET['page'];
	}else{
		$page_number = 0; //first page
	}
	?>
	
	<link href="../../stylesheets/chatstyledoc.css" rel="stylesheet" type="text/css"/>
	<script language="JavaScript" type="text/javascript" src="../../javascripts/jquery-3.1.1.js"></script>
	
	<div class="table">
		<div class="container">
			<div>
				<h1> chat box </h1>
			</div>
			<table>
				<tr>
					<td style=" position: relative; width: 100%; height: 100%;">
						<div style=" position: relative; width: 100%; height: 100%;">
							<div width="100%" height="100%">
								<table>
									<tr>
										<td style="position: relative; width: 20%; ">
											<label style="position: relative; width: 100%; " > Username : </label>
										</td>
										<td style="position: relative; width: 50%; ">
											
											<select style=" position: relative; width: 100%; height: 100%;" id="friendlist"></select>
										</td>
										<td style="position: relative; width: 30%; ">
											<button style="position: relative; width: 100%; " id="btnSelectFriend">Select Friend</button>
											
										</td>
									</tr>
									<tr >
										<td colspan="3" width="100%"; height="100%"; >
											<div id="log"></div>
											<input type="text" placeholder="Type your msg here .." id="msgtext" width="100%"/>
											<br />
											<br />
											<button style="position: relative; width: 50%; height: 25px; " id="btnSend">Send</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</td>
					
				</tr>
			</table>
			
			<script>
				function sleepMillis(miliseconds) {
				   var currentTime = new Date().getTime();
				   while (currentTime + miliseconds >= new Date().getTime()) {
				   }
				}

				var AccountName = "";
				
				function getSessionName() {
					getRequest(
						'conf.php', // URL for the PHP file
						drawOutput,  // handle successful request
						drawError    // handle error
					);
					return false;
				}
				
				// handles drawing an error message
				function drawError() {
					log.innerHTML += ("<div style=\"display: inline;  width: 180px; overflow-y: auto; border-radius: 15px; float: left;  background: yellow; padding: 7px; border: solid 1px black;\"> <span style=\"color: red;\">"+ "Warning" +": "+ "<span style=\"color: blue;\"> "+ "You must login first" + "</span></div><br/><br/>");
				}
				
				// handles the response, adds the html
				function drawOutput(responseText) {
					//log.innerHTML += ("<div style=\"display: inline;  width: 180px; overflow-y: auto; border-radius: 15px; float: left;  background: yellow; padding: 7px; border: solid 1px black;\"> <span style=\"color: red;\">"+ "Self" +": "+ "<span style=\"color: blue;\"> "+ responseText + "</span></div><br/><br/>");
					AccountName = responseText;
				}
				
				// helper function for cross-browser request object
				function getRequest(url, success, error) {
					var req = false;
					try{
						// most browsers
						req = new XMLHttpRequest();
					} catch (e){
						// IE
						try{
							req = new ActiveXObject("Msxml2.XMLHTTP");
						} catch(e) {
							// try an older version
							try{
								req = new ActiveXObject("Microsoft.XMLHTTP");
							} catch(e) {
								return false;
							}
						}
					}
					if (!req) return false;
					if (typeof success != 'function') success = function () {};
					if (typeof error!= 'function') error = function () {};
					req.onreadystatechange = function(){
						if(req.readyState == 4) {
							return req.status === 200 ? 
								success(req.responseText) : error(req.status);
						}
					}
					req.open("GET", url, true);
					req.send(null);
					return req;
				}
				
				getSessionName();
				var sock;
				var log = document.getElementById('log');
				var friendname = "";
				sleepMillis(200);
				var UserName = "X";
				sock = new WebSocket("ws://localhost:5001");
				var slist = document.getElementById('friendlist');
				
				
				document.querySelector('#btnSelectFriend').onclick = function(){
					if (AccountName == ""){
						window.location.replace("../home/login.php");
					}else{
						friendname = slist.value.trim();
						log.innerHTML = "";
						sock.send(JSON.stringify({
							type: "open_chat",
							fromname: AccountName.trim(),
							toname: friendname
						}));
					}
				};
				
				
				sock.onopen = function(){
					//log.innerHTML += ("<div style=\"display: inline; word-wrap: break-word; width: 180px; overflow-y: auto; border-radius: 15px; float: right; background: white; padding: 7px; border: solid 1px black;\"> <span style=\"color: red;\">"+ AccountName +": "+ "<span style=\"color: blue;\"> "+ AccountName + "</span></div><br/><br/>");
					if(AccountName != ""){
						UserName = AccountName;
						//friendname = prompt('what is your friend username ?');
						sock.send(JSON.stringify({
							type: "open_socket",
							fromname: AccountName.trim()
						}));
					}else{
						window.location.replace("../home/login.php");
					}
				}
				
				sock.onmessage = function(event){
					//console.log(event);
					
					var json = JSON.parse(event.data);
					
					if( json.type == "msg" ){
						if(json.name=="You"){
							log.innerHTML += ("<div style=\"display: inline;  word-wrap: break-word; width: 60%; overflow-y: auto; border-radius: 15px; float: right; background: white; padding: 7px; border: solid 1px black;\"> <span style=\"color: red;\">"+ json.name +": "+ "<span style=\"color: blue;\"> "+json.data + "</span></div><br/><br/>");
						}else{
							log.innerHTML += ("<div style=\"display: inline; word-wrap: break-word; width: 60%; overflow-y: auto; border-radius: 15px; float: left;  background: yellow; padding: 7px; border: solid 1px black;\"> <span style=\"color: red;\">"+ json.name +": "+ "<span style=\"color: blue;\"> "+json.data + "</span></div><br/><br/>");
						}
						//word-break: break-all; word-wrap: break-word;
						//log.innerHTML += '<div style="float: right;"> <span style="color: red;">'+ json.name +": "+ '<span style="color: blue;"> '+json.data + '</span></div>'+'<br/>';
						$('#log').animate({scrollTop: $('#log').prop("scrollHeight")}, 10);

					}else if( json.type == "users" ){
						slist.innerHTML += ("<option value=\" " + json.user + " \" >" + json.user + "</option>");
					}
				}
				
				document.querySelector('#msgtext').addEventListener('keypress', function (e) {
					var key = e.which || e.keyCode;
					if (key === 13) { // 13 is enter
						if (AccountName != UserName){
							window.location.replace("../home/login.php");
						}else{
							var text = document.getElementById('msgtext');
							if(text.value.trim() != ""){
								sock.send(JSON.stringify({
									type: "message",
									data: text.value
								}));
							}
							text.value = "";
							text.focus();
						}
					}
				});
				
				document.querySelector('#btnSend').onclick = function(){
					if (AccountName != UserName){
						window.location.replace("../home/login.php");
					}else{
						var text = document.getElementById('msgtext');
						if(text.value.trim() != ""){
								sock.send(JSON.stringify({
									type: "message",
									data: text.value
								}));
							}
						text.value = "";
						text.focus();
					}
				};
				
				var intervalID = setInterval(function(){
					getSessionName();
					if ( AccountName == "" || UserName == "X" || AccountName!=UserName){
						window.location.replace("../home/login.php");
					}
				}, 2000);
					
				
			</script>

		</div>
	</div>
	
	
	<?php
		if(admin_check()){ //user is admin
			include("../../includes/footer_admin.php");
		}else{ //normal user
			include("../../includes/footer.php");
		}
	?>
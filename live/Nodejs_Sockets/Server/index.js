var server = require('ws').Server;
var s = new server({ port: 5001})

var mysql      = require('mysql');
var sleep = require('system-sleep');


var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'mydb'
});
connection.connect();


/*
connection.query('SELECT * from user', function(err, rows, fields) {
  if (!err)
    console.log('The solution is: ', rows);
  else
    console.log('Error while performing Query.');
});
*/
//connection.end();

s.on('connection', function(ws){
	ws.on('message', function(msg){
		
		message = JSON.parse(msg);
		if(message.type == "open_chat"){
			
			ws.personName = message.fromname;
			ws.toName = message.toname;
			
			console.log("new client connected");
			
			//################################################################33333
			var sql = "SELECT user_id FROM user where username = \"" + message.fromname + "\" ;";
			connection.query( sql , function(err, rows){
				if(!err){
					ws.user1_id = rows[0].user_id;
				}else{
					console.log("Can not fined user " +  message.fromname + " in database..");
				}
			});
			sleep(100);
			//################################################################33333
			sql = "SELECT user_id FROM user where username = \"" + message.toname + "\" ;";
			connection.query( sql , function(err, rows){
				if(!err){
					ws.user2_id = rows[0].user_id;
				}else{
					console.log("Can not fined user " + message.toname + " in database..");
				}
			});
			sleep(100);
			//################################################################33333
			sql = "SELECT header_id FROM message_header where (user1_id = "+ ws.user1_id +" AND user2_id = "+ ws.user2_id +") OR (user1_id = "+ws.user2_id+" AND user2_id = "+ ws.user1_id +") ; ";
			console.log(sql);
			connection.query( sql , function(err, rows) {
				if (!err){
					console.log('The solution is: ', rows.length);
					if(rows.length == 0){
						console.log("inserting new Header id for chat");
						sql = "INSERT INTO message_header(user1_id, user2_id) VALUES( "+ws.user1_id+", " + ws.user2_id + ");";
						connection.query( sql , function(err, result){
							if(!err){
								console.log(result);
								
								sql = "SELECT header_id FROM message_header where (user1_id = \""+ message.fromname +"\" AND user2_id = \""+ message.toname +"\") OR (user1_id = \""+message.toname+"\" AND user2_id = \""+ message.fromname +"\") ; ";
								connection.query( sql , function(err, rows) {
									if (!err){
										console.log(rows);
										ws.header_id = rows[0].header_id;
										
										console.log(ws.user1_id);
										console.log(ws.user2_id);
										console.log(ws.header_id);
									}else{
										console.log("Error getting Header_id after insertion");
									}
								});
								
								
							}else{
								console.log('Error while inserting new header.');
							}
						});
					}else{
						
						ws.header_id = rows[0].header_id;
						
						console.log(ws.user1_id);
						console.log(ws.user2_id);
						console.log(ws.header_id);
						getMsgs(ws);
			
					}
				}else{
					console.log("Error getting Header_id");
				}
			});
			
			//################################################################33333
			
			
			
			
			
			/*
			connection.query( sql , function(err, rows) {
			if (!err){
				console.log('The solution is: ', rows.length);
				if(rows.length == 0){
					console.log("inserting");
					sql = "INSERT INTO message_header(user1_id, user2_id) VALUES( 10, 12);";
					connection.query( sql , function(err, result){
						if(!err){
							console.log(result);
						}else
							console.log('Error while performing Query.');
					});
				}else{
					console.log('header_id = : ', rows[0].header_id);
					ws.header_id = rows[0].header_id;
					
					console.log("New connected socket data : ")
					console.log(ws.personName);
					console.log(ws.toName);
					console.log(ws.header_id);
				}
			}else
				console.log('Error while performing Query.');
			});
			*/
			
			s.clients.forEach( function e(client){
				if(client.personName == ws.toName && client.toName == ws.personName){
					client.send(JSON.stringify({
						name: ws.personName,
						data: "is now online ..."
					}));
				}
			});
			return;
			
			
			
		}else if(message.type == "message"){
			s.clients.forEach( function e(client){
				if(client.personName == ws.toName && client.toName == ws.personName ){
					client.send(JSON.stringify({
						name: ws.personName,
						data: message.data
					}));
				}else if(client.personName == ws.personName){
					client.send(JSON.stringify({
						name: "You",
						data: message.data
					}));
				}
			});
			return;
		}
	});
	
	

	ws.on('close', function(){
		console.log("Lost one client!");
		/*
		s.clients.forEach( function e(client){
			if(client != ws){
				client.send(JSON.stringify({
					name: ws.personName,
					data: "Left Conversation"
				}));
			}
		});
		*/
	});
});



function getMsgs(WS){
	var sql = "SELECT message FROM message where header_id = " + WS.header_id + " ;";
	connection.query( sql , function(err, rows){
		if(!err){
			console.log(rows);
			for( var i=0 ; i<rows.length ; i++){
				WS.send(JSON.stringify({
						name: "You",
						data: rows[i].message
				}));
			}
		}else
			console.log('Error while performing Query. from getmsgs function');
	});
}


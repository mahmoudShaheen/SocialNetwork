
var server = require('ws').Server;
var s = new server({ port: 5001})

var mysql = require('mysql');
var sleep = require('system-sleep');

var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'root',
  database : 'mydb'
});
connection.connect();


s.on('connection', function(ws){
	ws.on('message', function(msg){
		
		message = JSON.parse(msg);
		if(message.type == "open_chat"){
			
			ws.personName = message.fromname.trim();
			ws.toName = message.toname.trim();
			
			console.log("new client connected");
			console.log(ws.personName);
			console.log(ws.toName);
			
			
			//################################################################33333
			var sql = "SELECT user_id FROM user where username = \"" + message.fromname + "\" ;";
			connection.query( sql , function(err, rows){
				if(!err){
					if(rows.length == 0){
						ws.close();
					}else{
						ws.from_id = rows[0].user_id;
					}
				}else{
					console.log("Can not fined user " +  message.fromname + " in database..");
				}
			});
			sleep(100);
			
			//################################################################33333
			sql = "SELECT user_id FROM user where username = \"" + message.toname + "\" ;";
			connection.query( sql , function(err, rows){
				if(!err){
					if(rows.length == 0){
						ws.close();
					}else{
						ws.to_id = rows[0].user_id;
					}
				}else{
					console.log("Can not fined user " + message.toname + " in database..");
				}
			});
			sleep(100);
			
			//################################################################33333
			sql = "SELECT * FROM message_header where (user1_id = "+ ws.from_id +" AND user2_id = "+ ws.to_id +") OR (user1_id = "+ws.to_id+" AND user2_id = "+ ws.from_id +") ; ";
			console.log(sql);
			connection.query( sql , function(err, rows) {
				if (!err){
					console.log('The solution is: ', rows.length);
					if(rows.length == 0){
						console.log("inserting new Header id for chat");
						sql = "INSERT INTO message_header(user1_id, user2_id) VALUES( "+ws.from_id+", " + ws.to_id + ");";
						connection.query( sql , function(err, result){
							if(!err){
								console.log(result);
								
								sql = "SELECT * FROM message_header where (user1_id = "+ ws.from_id +" AND user2_id = "+ ws.to_id +") OR (user1_id = "+ws.to_id+" AND user2_id = "+ ws.from_id +") ; ";
								connection.query( sql , function(err, rows) {
									if (!err){
										console.log(rows);
										ws.header_id = rows[0].header_id;
										ws.user1_id = rows[0].user1_id;
										ws.user2_id = rows[0].user2_id;
										
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
						ws.user1_id = rows[0].user1_id;
						ws.user2_id = rows[0].user2_id;
										
						console.log(ws.user1_id);
						console.log(ws.user2_id);
						console.log(ws.header_id);
						getMsgs(ws);
			
					}
				}else{
					console.log("Error getting Header_id");
				}
			});
				
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
			var owner = 1;
			if(ws.from_id == ws.user1_id){
				owner = 0;
			}
			sql = "INSERT INTO message(header_id, owner, message) VALUES( " + ws.header_id + ", " + owner + ",\"" + message.data + "\" )";
			connection.query( sql , function(err, result){
				if(!err){
					console.log(result);
				}else{
					console.log("Error inserting new message ..");
					console.log(sql);
				}
			});
					
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
	});
});



function getMsgs(WS){
	
	var sql = "SELECT * FROM message where header_id = " + WS.header_id + " ;";
	connection.query( sql , function(err, rows){
		if(!err){
			console.log(rows);
			for( var i=0 ; i<rows.length ; i++){
				if((rows[i].owner == 0 && WS.from_id == WS.user1_id )|| ( rows[i].owner == 1 && WS.from_id == WS.user2_id ) ){
					WS.send(JSON.stringify({
						name: "You",
						data: rows[i].message
					}));
				}else{
					WS.send(JSON.stringify({
						name: WS.toName,
						data: rows[i].message
					}));
				}
				
			}
		}else
			console.log('Error while performing Query. from getmsgs function');
	});
}


var server = require('ws').Server;
var s = new server({ port: 5001})

s.on('connection', function(ws){
	ws.on('message', function(msg){
		
		message = JSON.parse(msg);
		if(message.type == "name"){
			console.log("new client connected");
			ws.personName = message.data;
			s.clients.forEach( function e(client){
				if(client != ws){
					client.send(JSON.stringify({
						name: ws.personName,
						data: "Joined"
					}));
				}
			});
			return;
		}
		s.clients.forEach( function e(client){
			if(client != ws){
				client.send(JSON.stringify({
					name: ws.personName,
					data: message.data
				}));
			}else{
				client.send(JSON.stringify({
					name: "You",
					data: message.data
				}));
			}
		});
	});
	
	ws.on('close', function(){
		console.log("Lost one client!");
		s.clients.forEach( function e(client){
			if(client != ws){
				client.send(JSON.stringify({
					name: ws.personName,
					data: "Left Conversation"
				}));
			}
		});
	});
});
function getCookie(name)
{
	var re = new RegExp(name + "=([^;]+)");
	var value = re.exec(document.cookie);
	return (value != null) ? unescape(value[1]) : null;
}


var jestZajety = false;
var stan = 0;

//zwaraca status chatu
function getStateOfChat() {
	if(!jestZajety){
		jestZajety = true;
		$.ajax({
			type: "POST",
			url: "MyBank.php",
			data: {'whatToDo': 'getState'},
			dataType: "json",	
			success: function(data) {
				stan = data.stan;
				jestZajety = false;
			}
		});
	}	
}

//Updates the chat
function updateChat(nick) {
	if(!jestZajety){
		jestZajety = true;
		$.ajax({
			type    : "POST",
			url     : "MyBank.php?" + new Date().getTime(),
			data    : {'whatToDo': 'update'},
			dataType: "json",
			success : function(data) {
				var arr = data;
				var i;
				var out = "";

				for(i = 0; i < arr.length; i++) {
					out += "<div id='testchat'>";
					if (nick == arr[i].NICK){
						out+= "<td class='thisIsMe'><div id='nick'>"; 
					} else {
						out+= "<td class='thisIsFiend'><div id='nick'>";
					}
					out+= arr[i].NICK +
					"</div></td><div id='data'>" +
					arr[i].time +
					"</div><div id='wiadomosc'>"; 
					if (i==0){ 
						out+= "<strong>" + arr[i].msg + "</strong>";
					} else {
						out+= arr[i].msg;
					}
					out+= "</div></div>";
				}
				out += "";
				//alert(out);
				console.log(out);
				$('#chat').html(out);				
				//document.getElementById('chat').scrollTop =document.getElementById('chat').scrollHeight;
				jestZajety = false;
			},
			error : function (jqXHR, textStatus, errorThrown){
				console.log("Bład po SELECT: " + textStatus + " ; " + errorThrown + ";");
				console.log(jqXHR);
			}
		});
	}
	else {
		setTimeout(updateChat, 1500);
	}
}

//wysyłamy komunikat
function sendChat(msg, nick) { 
	$.ajax({
		type    : "POST",
		url     : "MyBank.php",
		data    : {'whatToDo': 'send', 'msg': msg, 'NICK': nick},
		dataType: "json",
		success : function(data){
			console.log(data);
		},
		error : function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR);
		}
	});
}



function Chat () {
    this.update   = updateChat;
    this.send     = sendChat;
    this.getState = getStateOfChat;
}


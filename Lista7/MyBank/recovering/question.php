<?php

      require_once("../mydb.php");
	  
	session_start();
	
	echo '<div>aby odzyskac haslo, odpowiedz na pytanie</div><br>';
	$name=$_SESSION['logrec'];
	
	$sql = "SELECT * FROM safety WHERE Nick = '$name'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$question = $row["Question"];   
	$answer= $row["Answer"];
	echo $question;
    echo '<br>';

?>
		 <form method="post">
            <p>OdpowiedŸ: <input type="text" name="answer" ></p>
            <p><input type="submit" value="wyœlij" /></p>
         </form>
<?php
		if($_SERVER["REQUEST_METHOD"] == "POST") {

				$useranswer = mysqli_real_escape_string($db,$_POST['answer']); 

			

				if($answer==$useranswer) {
					$tablica = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','o','p','q','r','s','t','u','v','w','x','y','z',
					'A','B','C','D','E','F','G','H','I','J','K','L','O','P','Q','R','S','T','U','V','W','X','Y','Z');
					$token="";
					for( $x = 1; $x <= 10; $x++ ){
						$los = array_rand($tablica);
						$token=$token.$tablica[$los];
					}
					echo $token;

						$sql = "SELECT * FROM accounts WHERE name = '$name'";
						$result = mysqli_query($db,$sql);
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
						$adres = $row["mail"]; 
						echo $adres;
					
					$sql = "INSERT into codes (Nick,pass) values ('".$name."','".$token."')";
					$result = mysqli_query($db,$sql);
					
					$od  = "From: uzytkownik@kursphp.com \r\n";
					$od .= 'MIME-Version: 1.0'."\r\n";
					$od .= 'Content-type: text/html; charset=iso-8859-2'."\r\n";

					$tytul = "Odzyskiwanie has³a w testowej aplikacji";
					$wiadomosc = "<html>
					<head>
					</head>
					<body>
						<b>Witaj serdecznie, ".$adres."!</b><br/>
						<div>Otrzyma³eœ tê wiadomoœæ, poniewa¿ uaktywni³eœ opcjê 'odzyskiwanie hasla'.</div><br>
						<div>Aby zrestartowaæ haslo, wprowadz poni¿szy token na stronê weryfikacji <a href= 'http://localhost/Mybank/recovering/verify.php'> TUTAJ</a></div><br>
						<div><b>TOKEN </b>".$token."</div><br>
						<div><b>NIE UDOSTÊPNIAJ NIKOMU TEJ WIADOMOŒCI!!!</b></div><br><br>
						<div>Z powa¿aniem- administrator</div>
					</body>
					</html>";

// u¿ycie funkcji mail
					mail($adres, $tytul, $wiadomosc, $od);					
					
						session_destroy();
						header('location: info.php');
				}else {
					echo' <p>spróbuj ponownie</p><br> ';
					
					}
				}
?>
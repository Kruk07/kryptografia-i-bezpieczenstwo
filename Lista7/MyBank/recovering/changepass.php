	<?php
      require_once("../mydb.php");
	  session_start();
	 echo "<div>token wprowadzony pomyúlnie, moøesz teraz zmieniÊ swoje has≥o</div><br>";
?>	  
		 <form method="post">
            <p>Wprowadü tutaj nowe has≥o: <input type="password" name="pass1" ></p><br>
			<p>Wprowadü has≥o ponownie: <input type="password" name="pass2" ></p><br>
            <p><input type="submit" value="wyúlij" /></p>
         </form>
		 
<?php
 if($_SERVER["REQUEST_METHOD"] == "POST") {

				$pass1 = mysqli_real_escape_string($db,$_POST['pass1']); 
				$pass2 = mysqli_real_escape_string($db,$_POST['pass2']); 
	

		//echo $hashed_pass;
				if($pass1==$pass2) {

					$nick=$_SESSION['recover'] ;
					
								$sql = "SELECT * FROM accounts WHERE name = '$nick'";
			$result = mysqli_query($db,$sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

			$stored_pass = $row["pass"];     
					
						$i = 32;
					$cstrong = TRUE;
					$bytes = openssl_random_pseudo_bytes($i, $cstrong);

					$salt   = substr($stored_pass, 0, 64);
					$hashed_pass = $salt . hash_hmac('sha512', $salt.$pass1, 'abcdefghij');
					
					$sql = "UPDATE accounts SET pass='$hashed_pass' WHERE name = '$nick'";
					$result = mysqli_query($db,$sql);
					header('location: confirm.php');
				}else {
					echo' <p>rozne hasla</p><br> ';
					
				}
			}
?>	  
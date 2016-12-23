	<?php
      require_once("../mydb.php");
	 
?>	  
		 
		 
		 <form method="post">
            <p>Wprowadü tutaj otrzymany token: <input type="text" name="token" ></p>
            <p><input type="submit" value="wyúlij" /></p>
         </form>
		 
	<?php
     if($_SERVER["REQUEST_METHOD"] == "POST") {

				$token = mysqli_real_escape_string($db,$_POST['token']); 
			
	
				$sql = "SELECT * FROM codes WHERE pass = '$token'";
				$result = mysqli_query($db,$sql);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

				$tokenrec = $row["pass"];
		//echo $hashed_pass;
				if($token==$tokenrec) {
					session_start();
					$nick = $row["Nick"];   
					$_SESSION['recover'] = $nick;
					
					$sql = "DELETE FROM codes WHERE Nick = '$nick'";
					$result = mysqli_query($db,$sql);
					header('location: changepass.php');
				}else {
					echo' <p>zly token </p><br> ';
					
				}
			}
	 
?>	  
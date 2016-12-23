        <?php
		 	require_once("../myDb.php");
			session_start();
		    if($_SERVER["REQUEST_METHOD"] == "POST") {

				$myusername = mysqli_real_escape_string($db,$_POST['login']); 
			
	
				$sql = "SELECT * FROM accounts WHERE name = '$myusername'";
				$result = mysqli_query($db,$sql);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

			
		//echo $hashed_pass;
				if(mysqli_num_rows($result) == 1 ) {
					$_SESSION['logrec'] = $myusername;
					header('location: question.php');
				}else {
					echo' <p>zly login </p><br> ';
					
				}
			}
		 ?>
		 <html>
			<head>
			</head>
			<body>
		 <form method="post">
            <p>Podaj login: <input type="text" name="login" ></p>
            <p><input type="submit" value="wyœlij" /></p>
         </form>
		 </body>
		 </html>
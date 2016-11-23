<?php
	require_once("myDb.php");
	require_once("page.php");
	session_start();
   
	if(isset($_SESSION['login']))
		header("location:form.php");
	$error = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$myusername = mysqli_real_escape_string($db,$_POST['username']); 
		$post_pass = $_POST['password'];
	
		$sql = "SELECT * FROM accounts WHERE name = '$myusername'";
		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		//print_r($row);
		$stored_pass = $row["pass"]; // db pass      
		
				$i = 32;
		$cstrong = TRUE;
		$bytes = openssl_random_pseudo_bytes($i, $cstrong);

		$salt   = substr($stored_pass, 0, 64); // salt from db
		$hashed_pass = $salt . hash_hmac('sha512', $salt.$post_pass, 'abcdefghij');
		echo $hashed_pass;
		if(mysqli_num_rows($result) == 1 && md5($stored_pass) === md5($hashed_pass)) {
			//session_register("myusername");
			$_SESSION['login'] = $myusername;
			header("location: form.php");
		}else {
			$error = "Z³y login lub has³o";
		}
	}
   
	$P = new Page();
	echo $P->Begin();
?>
    <form action="" method="post">
        <label>Nazwa: </label><input type="text" name="username" class="box" /><br /><br />
        <label>Has³o: </label><input type="password" name="password" class="box" /><br/><br />
        <input type="submit" value=" Zaloguj " /><br />
    </form>
<?php

	
	echo $P->End();
?>
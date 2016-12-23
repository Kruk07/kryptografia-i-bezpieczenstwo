<?php
   require_once('session.php');
   require_once("mydb.php");
   require_once("page.php");
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	  //var_dump($_POST);
      $accountNr = mysqli_real_escape_string($db,$_POST['accountNr']);
      $value = mysqli_real_escape_string($db,$_POST['value']);
	  $title = mysqli_real_escape_string($db,$_POST['title']);
	  
	  doPayment($_SESSION['login'], $accountNr, $value, $title);
	
   }
	$P = new Page();
   echo $P->Begin();
   echo $P->loggedAs();
?>
		Przelew wykonany:
		<div>
			<table id="senttable" border="10">
				<tr>
					<th>Id</th>
					<th>Na konto</th> 
					<th>Kwota</th>
					<th>Tytul</th>
				</tr>
				<tr>
			<?php
			$result = $db->query("SELECT * FROM history ORDER BY id DESC LIMIT 1");
			$row = $result->fetch_assoc();
			echo "<th>".$row["id"]."</th><br>"
				."<th>".$row["accountTo"]."</th><br>"
				."<th>".$row["value"]."</th><br>"
				."<th>".$row["title"]."</th><br>";
			?>
				</tr>
			</table>
		</div>
<?php
	echo $P->End();
?>
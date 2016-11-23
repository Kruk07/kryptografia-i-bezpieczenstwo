
<?php
   require_once('session.php');
   require_once("page.php");
      require_once("mydb.php");
   
   $P = new Page();
   echo $P->Begin();
   echo $P->loggedAs();
?>
		<button onclick="self.location='logout.php'">Wyloguj!</button>
		<p id="pr"><b >Przelew</b></p><br>
		<form id="form1" action = "confirm.php" method = "post">
			<label>Rachunek: </label><input id="accnr" type = "text" name = "accountNr" class = "box" /><br>
            <label>Kwota: </label><input type = "text"   name = "value" class = "box" /><br>
			<label>Tytul: </label><input type = "text" name = "title" class = "box" /><br>
            <input type = "submit" value = " Dalej "/><br>
		</form>
		<br>
		<br>
		<div>
			<div id="napis">Historia wykonanych przelewow</div>
			<table id="senttable" border="10">
				<tr>
					<th>Id</th>
					<th>Na konto</th> 
					<th>Kwota</th>
					<th>Tytul</th>
				</tr>
				
			<?php
			$name = $_SESSION['login'];
			$result = $db->query("SELECT * FROM history WHERE name like '".$name."' ORDER BY id DESC LIMIT 10");
			while(			$row = $result->fetch_assoc()){
			echo "<tr><th>".$row["id"]."</th>"
				."<th>".$row["accountTo"]."</th>"
				."<th>".$row["value"]."</th>"
				."<th>".$row["title"]."</th></tr>";
				
			}
			?>
				
			</table>
		</div>

<?php
	echo $P->End();
?>
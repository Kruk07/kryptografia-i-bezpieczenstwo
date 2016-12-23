<?php

$HEADER =<<<EOT
<!DOCTYPE html>
<html>
	<head>

		<script src="jquery-3.1.1.min.js"></script>
		
		<title>Bank</title>
	</head>
	<body>
EOT;

$FOOTER = <<<EOT
<script src="script.js"></script>
	</body>
</html>
EOT;

class Page{

  public function loggedAs(){
	  if(isset($_SESSION['login']))
		return "Witaj: <span id=\"nick\">" . $_SESSION['login'] .  "</span><br>";
		
  }

  public function Begin() {
    global $HEADER;
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); // Proxies.
	return $HEADER;
  }

  public function End() {
    global $FOOTER;
    return $FOOTER;
  }
}
?>
<?php
	require_once("myDb.php");
	require_once("page.php");
	require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
	require_once __DIR__ . '/gplus-lib/vendor/autoload.php';
	session_start();
	
	
	//inicjowanie strony
	$P = new Page();
	echo $P->Begin();
   	//reCAPTCHA
require_once '/recaptcha-master/src/autoload.php';

$siteKey = '6Leomw8UAAAAAIaBe8OwhtjNjsOr3QGDHlcMW-gw';
$secret = '6Leomw8UAAAAADAT4Ek-50aeR-pkwhYNNiHJIoco';
$lang = 'pl';

   //GOOGLE+
CONST CLIENT_ID= '1036240666436-h0qlli3q2gqvkhmisn42oave9gc7b2tb.apps.googleusercontent.com';
CONST CLIENT_SECRET='iT-TBwwDIjisV-rJxTAWhK3n';
CONST REDIRECT_URI='http://localhost/Mybank/index.php';

$client= new Google_Client();
$client->setClientID(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email');

$plus = new Google_Service_Plus($client);

if(isset($_REQUEST['logout'])){
	session_unset();
}
if(isset($_GET['code'])){

	$client->authenticate($_GET['code']);
	$_SESSION['access_token']= $client->getAccessToken();
	$redirect='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	header('Loaction:'.filter_var($redirect,FILTER_SANITIZE_URL));
}
if(isset($_SESSION['access_token']) && $_SESSION['access_token']){
	$client->setAccessToken($_SESSION['access_token']);
	$me = $plus->people->get('me');
	$id = $me['id'];
	$name = $me['displayName'];
	$email = $me['emails'][0]['value'];
	$pass = $me['password'];
	$_SESSION['login'] = $name;
	header("location: form.php");
}else{
	$authUrl=$client->createAuthUrl();
}
   // Zwyk³e logowanie
	if(isset($_SESSION['login']))
		header("location:form.php");
	$error = "";
	
	
	
	if(isset($_POST['g-recaptcha-response']))
    {
		 $recaptcha = new \ReCaptcha\ReCaptcha($secret);
         $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
         if($resp->isSuccess())
         {
            if($_SERVER["REQUEST_METHOD"] == "POST") {

			$myusername = mysqli_real_escape_string($db,$_POST['username']); 
			$post_pass = $_POST['password'];
	
			$sql = "SELECT * FROM accounts WHERE name = '$myusername'";
			$result = mysqli_query($db,$sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

			$stored_pass = $row["pass"];     
		
				$i = 32;
			$cstrong = TRUE;
			$bytes = openssl_random_pseudo_bytes($i, $cstrong);

			$salt   = substr($stored_pass, 0, 64);
			$hashed_pass = $salt . hash_hmac('sha512', $salt.$post_pass, 'abcdefghij');
		//echo $hashed_pass;
			if(mysqli_num_rows($result) == 1 && md5($stored_pass) === md5($hashed_pass)) {

				$_SESSION['login'] = $myusername;
				header("location: form.php");
			}else {
				echo' <p>zly login lub haslo</p><br> ';
				header("location: index.php");
			}
			}
         }
         else
         {
              header("location: form.php");
         }
	}
    else
    {
		 echo '
         <form action "" method="post">
            
			<label>Nazwa: </label><input type="text" name="username" class="box" /><br /><br />
			<label>Has³o: </label><input type="password" name="password" class="box" /><br/><br />
            <div class="g-recaptcha" data-sitekey="'.$siteKey.'"></div>
            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl='.$lang.'">
            </script>
            <input type="submit" value=" Zaloguj " /><br />
            </form>
         ';
    }
		
		
	
//FACEBOOK	
   $fb = new Facebook\Facebook([
  'app_id' => '1884059228481142', // Replace {app-id} with your app id
  'app_secret' => '38aa3b84f056948eb05ac1a54bcd2cc6',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/MyBank/fb-callback.php', $permissions);










?>
	
<a href="recovering/recover.php"> Odzyskiwanie hasla </a><br>
	
	
<?php
	echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
	if (isset($authUrl)){
		echo "<a class='login' href='".$authUrl."'><img src='gplus-lib/signin_button.png' height='50px'/>";
	}else{
		print "ID: {$id} <br>";
		print "Name: {$name} <br>";
		print "Email: {$email} <br>";
		print "Password: {$pass} <br>";
		echo "<a class='logout' href='?logout'><button>Logout</button></a>";
	}
	
	echo $P->End();
?>
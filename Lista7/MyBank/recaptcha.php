<?php

require_once '/recaptcha-master/src/autoload.php';

$siteKey = '6Leomw8UAAAAAIaBe8OwhtjNjsOr3QGDHlcMW-gw';
$secret = '6Leomw8UAAAAADAT4Ek-50aeR-pkwhYNNiHJIoco';

$lang = 'pl';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Test reCAPTCHA</title>
    </head>
    <body>

<?php
    if(isset($_POST['g-recaptcha-response']))
    {
         $recaptcha = new \ReCaptcha\ReCaptcha($secret);
         $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
         if($resp->isSuccess())
         {
              echo '<h2>Sukces!</h2><p>Przeszed�e� test antybotowy.</p>';
         }
         else
         {
              echo '<h2>Co� posz�o nie tak </h2><p>Wygl�da na to �e jeste� botem :(</p>';
         }
    }
    else
    {
         echo '
         <form method="post">
            <p>POdaj imie: <input type="text" name="Imi�" value="test"></p>

            <div class="g-recaptcha" data-sitekey="'.$siteKey.'"></div>
            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl='.$lang.'">
            </script>
            <p><input type="submit" value="wy�lij" /></p>
            </form>
         ';
    }
    ?>
</body>
</html>
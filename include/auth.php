<?php
// Database
$db['host']     = 'localhost';
$db['user']     = 'pouet';
$db['password'] = 'pouet';
$db['database'] = 'pouet';

$sceneidUrl = "http://$_SERVER[HTTP_HOST]/fake-sceneid.php";
$sceneidLogin = "pouet";
$sceneidPassword = md5("pouet");

define('RECAPTCHA_PUB_KEY', 'pouet');
define('RECAPTCHA_PRIV_KEY', 'pouet');

define('RECAPTCHA_MAILHIDE_PUB_KEY', 'pouet');
define('RECAPTCHA_MAILHIDE_PRIV_KEY', 'pouet');

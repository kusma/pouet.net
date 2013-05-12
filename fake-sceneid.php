<?
$users = array(
	1 => array(
		'login' => 'user',
		'password' => md5('pass'),
		'nickname' => 'SomeUser',
		'firstname' => 'Some',
		'lastname' => 'User',
		'email_hidden' => 'yes',
		'email' => 'foo@bar.com',
		'url' => 'http://bar.com/~foo',
		'birthdate' => '0000-00-00',
		'country_id' => 'FI',
		'country' => 'Finland'
	),
	2 => array(
		'login' => 'admin',
		'password' => md5('admin'),
		'nickname' => 'admin',
		'firstname' => 'Admin',
		'lastname' => 'Boss',
		'email_hidden' => 'yes',
		'email' => 'admin@localhost',
		'url' => 'http://localhost/',
		'birthdate' => '0000-00-00',
		'country_id' => 'FR',
		'country' => 'France'
	)

);

function error($returnCode, $returnMessage) {
	echo <<<EOT
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<sceneid>
	<returnCode>$returnCode</returnCode>
	<returnMessage>$returnMessage</returnMessage>
</sceneid>
EOT;
	exit(1);
}

if (!isset($_GET['command']))
	error(0, 'Command not defined');

switch ($_GET['command']) {
case 'getUserInfo':
	if (!isset($_GET['userID']))
		error(11, 'No userID, login or cookie parameter defined');
	$uid = $_GET['userID'];

	if (!isset($users[$uid]))
		error(12, 'User does not exist');
	$user = $users[$uid];

	echo <<<EOT
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<sceneid>
	<returnCode>10</returnCode>
	<returnMessage>User data fetched succesfully</returnMessage>
	<user id="$uid">
		<id>$uid</id>
		<login>$user[login]</login>
		<nickname>$user[nickname]</nickname>
		<firstname>$user[firstname]</firstname>
		<lastname>$user[lastname]</lastname>
		<email hidden="$user[email_hidden]">$user[email]</email>
		<url>$user[url]</url>
		<birthdate>$user[birthdate]</birthdate>
		<country id="$user[country_id]">$user[country]</country>
	</user>
</sceneid>
EOT;
	break;

case 'loginUserMD5':
	if (!isset($_GET['login']))
		error(31, 'User login not specified');
	if (!isset($_GET['password']))
		error(33, 'User password not specified');

	$login = $_GET['login'];
	$password = $_GET['password'];

	$user = NULL;
	$uid = -1;
	foreach ($users as $id => $u)
		if ($u['login'] == $login) {
			$user = $u;
			$uid = $id;
		}

	if ($user == NULL || $uid < 0)
		error(32, 'User does not exist');
	if ($password !== $user['password'])
		error(34, 'Invalid password');

	echo <<<EOT
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<sceneid>
	<returnCode>30</returnCode>
	<returnMessage>User logged in succesfully</returnMessage>
	<user id="$uid">
		<id>$uid</id>
		<login>$user[login]</login>
		<nickname>$user[nickname]</nickname>
		<firstname>$user[firstname]</firstname>
	        <lastname>$user[lastname]</lastname>
		<email hidden="$user[email_hidden]">$user[email]</email>
		<url>$user[url]</url>
		<birthdate>$user[birthdate]</birthdate>
		<country id="$user[country_id]">$user[country]</country>
		<verified>1</verified>
	</user>
	<cookie>
		<name>SCENEID_COOKIE</name>
		<value>62d21009241f07455ea677c68145bcab</value>
		<expires>1102960691</expires>
		<path>/</path>
		<domain>scene.org</domain>
		<secure>0</secure>
	</cookie>
</sceneid>
EOT;
	break;


case 'logoutUser':
	if (!isset($_GET['userID']))
		error(0, 'userID required');
	$uid = $_GET['userID'];

	echo <<<EOT
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<sceneid>
	<returnvalue id="40">User logged out succesfully</returnvalue>
	<user id="$uid"/>
</sceneid>
EOT;
	break;

/*
case 'registerUserMD5':
	echo <<<EOT
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<sceneid>
	<returnvalue id="20">User registered succesfully</returnvalue>
	<user id="8124"/>
</sceneid>
EOT;
	break;
*/

case 'setUserInfoMD5':
	if (!isset($_GET['userID']))
		error(0, 'userID required');
	$uid = $_GET['userID'];

	echo <<<EOT
<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<sceneid>
	<returnvalue id="50">User data updated succesfully</returnvalue>
	<user id="$uid"/>
</sceneid>
EOT;
	break;

default:
	error(0, 'Command not defined');
}

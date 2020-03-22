<?php
//date_default_timezone_set("America/New_York");
require_once "settings.php";
$config = require("db/config.php");
$db = new PDO($config["db"], $config["username"], $config["password"]);

if( strtolower($_SERVER["HTTP_HOST"]) === ALLOWED_HOST )
{	

	$pages = explode("/", trim($_SERVER['REQUEST_URI'],'/'));

session_set_cookie_params(60*60*8, "/", "." . $_SERVER["HTTP_HOST"], 1, 0);
session_start();
	
	$page = strtolower($pages[0]) === "admin" && empty($_SESSION['user']) ? "login.php" : "inner.php";
		
	if( strtolower($pages[0]) === "admin" && !empty($_POST['login']) && !empty($_POST['password']) )
	{
		$query = $db->prepare("SELECT * FROM users WHERE login = :login AND pass = :pass");
		$query->bindParam(":login", $_POST['login']);
        $query->bindParam(":pass", md5($_POST['password']));
        $query->execute();
        $user = $query->fetchAll();

		if( is_array($user[0]) && count($user[0]) > 0 ) 
		{
			$page = "inner.php";
			$_SESSION['lvl'] = $user[0]["lvl"];
			$_SESSION['user'] = $user[0]["login"];
			
		}else $auth_result = "sorry, auth fail, try again pls.";

	}

	if( strtolower($pages[0]) === 'logout' )
	{
		unset($_SESSION);
		session_unset();
		session_destroy();
		header("Location: /");
	}

	require_once PATH . "pages/" . $page;

} else echo "Access Denied";

?>



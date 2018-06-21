<?php
ob_start("ob_gzhandler");
session_start();

$username = "admin";
$password = "admin";

// main page
$mainpage = "main.php";

$IPaddress = $_SERVER["REMOTE_ADDR"];
$UsersOnlinetime=time();
$time_check=$UsersOnlinetime-900;

if(isset($_SESSION['logedin']))
if($_SESSION['logedin'] == 'loggedin')
{
header("Location: $mainpage");
exit(); 
} 


// If the form was submited check if the username and password match
if(isset($_POST['submit']))
{

if($_POST['username'] == $username && $_POST['password'] == $password)
{
		$_SESSION['logedin'] = 'loggedin';
		
		// Redirect to the page
		header("Location: $mainpage");
		exit();
}
else
{
		$error = '<br /><br />Invalid Username or Password!';
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-US">
<head>
<title>Login</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<style type="text/css">
html, body, #wrapper {
	height:100%;
	width: 100%;
	margin: 0;
	padding: 0;
	border: 0;
}
#wrapper td {
	vertical-align: middle;
	text-align: center;
}
#headerBox {
	border: 1px solid #A6E0FF;
	width: 800px;
	color: #00529B;
	background: #EDF8FE;
	height: 150px;
	text-align: center;
	margin: 0px auto;
}
#top {
	color: #00529B;
	background: #DAF3FF;
	text-align: center;
	border-bottom: 1px solid #BFE9FF;
	padding-top: 10px;
	padding-bottom: 10px;
	font-weight:bold;
	
}
#bottom {
	color: #00529B;
	background: #EDF8FE;
	text-align: center;
	padding-top: 30px;
}
</style>
</head>
<body>
<table id="wrapper">
<tr>
<td>
<div id="headerBox">
<form method="post" id="login" action="index.php">
<div id="top">Log In</div>
<div id="bottom">
Username: <input id="username" name="username" type="text" />
Password: <input id="password" name="password" type="password" />
<input type="submit" name="submit" id="submit" value="Log in" />
<? if(isset($error)) echo $error; ?>
</div>
</form>
</div>
</td>
</tr>
</table>
<script type="text/javascript">
//<![CDATA[
<!--
document.getElementById("username").focus();
//-->
//]]>
</script>
</body>
</html>
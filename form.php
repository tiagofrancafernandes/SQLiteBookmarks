<?php
include "config.inc.php";
if($_SESSION['logedin'] != 'loggedin')
{
header("Location: index.php"); 
exit(); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Add a note</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body>
<div id="layoutBox">
<div id="navigationmenu"><div id="alignleft">Notes Manager</div><div id="alignright"><a href="main.php">Home</a> - <a href="form.php">Add a note</a> - <a href="logoff.php">Logout</a></div><div style="clear: both;"></div></div>
<div id="mainContent">
<form action="insert.php" method="POST" id="login">
<h1>Add a note</h1>
Title: <input name="title" size="100" /><br><br>
Note: <br>
<textarea id="textarea1" name="notes" style="width:750px;height:500px;">
</textarea>
<input type="submit" value="Submit" id="submit" />
</form>
</div>
</div>
</body>
</html>
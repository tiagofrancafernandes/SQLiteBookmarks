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
<title>Notes Manager</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<style type="text/css">
#customers
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#customers td, #customers th 
{
font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
#customers th 
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#ffffff;
}
#customers tr.alt td 
{
color:#000000;
background-color:#EAF2D3;
}
.pages a {
  color: #1C5C9A;
  text-decoration: none;
  font-weight: bold;
  font-family:arial, helvetica, arial, sans-serif;
}
.pages a:hover {
  color: #6398CD;
  text-decoration: none;
  font-weight: bold;
  font-family:arial, helvetica, arial, sans-serif;
}
.pages {
    padding: 20px 0 10px 0;
    margin: 20px 0 10px 0;
    clear: left;
    font-size: 11px;
    text-align: center;
	font-family:arial, helvetica, arial, sans-serif;
}
.pages a, .pages span {
    padding: 0.2em 0.5em;
    margin-right: 0.1em;
    border: 1px solid #fff;
    background: #fff;
}
.pages span.current {
    border: 1px solid #2E6AB1;
    font-weight: bold;
    background: #30659E;
    color: #fff;
	font-family:arial, helvetica, arial, sans-serif;
}
.pages a {
    border: 1px solid #9AAFE5;
    text-decoration: none;
}
.pages a:hover {
    color: #1c5c9a;
    border-color: #6398CD;
    background: #ecf2f8;
}
.pages a.nextprev {
    font-weight: bold;
	font-family:arial, helvetica, arial, sans-serif;
}
.pages span.nextprev {
    border: 1px solid #ddd;
    color: #666;
	font-weight: bold;
	font-family:arial, helvetica, arial, sans-serif;
}
</style>
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body>
<div id="layoutBox">
  <!-- Navigation menu starts -->
  <div id="navigationmenu"><div id="alignleft">Notes Manager</div><div id="alignright"><a href="main.php">Home</a> - <a href="form.php">Add a note</a> - <a href="logoff.php">Logout</a></div><div style="clear: both;"></div></div>

<?php
$rowedit = $_GET['id']; 
$db = new PDO("sqlite:$dbname");
$result = $db->query("SELECT rowid, Title, Notes FROM $tablename WHERE rowid = '$rowedit'");
$fields = $result->fetch(PDO::FETCH_ASSOC);
$result = null;
?>
<div id="mainContent">
<form action="update.php?id=<?php echo $rowedit;?>" method="POST" id="login">
<h1>Edit</h1>
Title: <input name="title" size="100" value="<?php echo stripslashes($fields['Title']); ?>" /><br><br>
Notes: <br>
<textarea id="textarea1" name="notes" style="width:750px;height:500px;">
<?php echo $fields['Notes'];?>
</textarea>
<input type="submit" value="Update" id="submit" />
</form>
</div>

<?php
$db = NULL;
?>
</div>
</body>
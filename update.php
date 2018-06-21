<?php
include "config.inc.php";
if($_SESSION['logedin'] != 'loggedin')
{
header("Location: index.php"); 
exit(); 
}

$rowedit = $_GET['id']; 
$title = $_POST['title'];
$notes = $_POST['notes'];

if(empty($title))
{
header("Location: error.php?error=notitle");
exit();
}
if(empty($notes))
{
header("Location: error.php?error=nonotes");
exit();
}

$today = date("F j, Y");
$db = new PDO("sqlite:$dbname");

$query = "UPDATE $tablename SET Title = :title, Notes = :notes WHERE rowid = '$rowedit'";
$result = $db->prepare($query);
$result->execute(array("$title", "$notes"));
// close the database connection
$db = null;
header("Location: main.php");

?>
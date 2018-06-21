<?php
include "config.inc.php";
if($_SESSION['logedin'] != 'loggedin')
{
header("Location: index.php"); 
exit(); 
}

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
  
//open the database
$db = new PDO("sqlite:$dbname");

$query = "INSERT INTO $tablename (Title, Notes) VALUES (:title ,:notes)";
$result = $db->prepare($query);
$result->execute(array("$title", "$notes"));
// close the database connection
$db = NULL;
header("Location: $mainpage"); 
?>
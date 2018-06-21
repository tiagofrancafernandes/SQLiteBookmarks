<?php
include "config.inc.php";
if($_SESSION['logedin'] != 'loggedin')
{
header("Location: $redirectlocation"); 
exit(); 
}

$rowdelete = $_GET['id']; 
//open the database

$db = new PDO("sqlite:$dbname");

//now output the data to a simple html table...
$db->exec("DELETE FROM $tablename WHERE rowid = '$rowdelete'");
$db = NULL;

// echo $rowdelete;

header("Location: main.php"); 

?>
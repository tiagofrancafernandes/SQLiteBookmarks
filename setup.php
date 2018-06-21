<?php
$dbname = "db/Notes.db";
$tablename = "NotesTable";

  try
  {
    //open the database
    $db = new PDO("sqlite:$dbname");

    //create the database
    $db->exec("CREATE TABLE $tablename (Title TEXT, Notes TEXT)");
	echo "Database and Table created sucessfully.";
	
    // close the database connection
    $db = NULL;
  }
  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
?>
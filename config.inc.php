<?php
ob_start("ob_gzhandler");
header("Content-Encoding: gzip");
session_start();

// main page
$mainpage = "main.php";

// SQLite database with path
$dbname = "db/Notes.db";
$tablename = "NotesTable";
?>
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
$db = new PDO("sqlite:$dbname");
$result = $db->query("SELECT rowid FROM $tablename");
$rows = $result->fetchAll();
$total_pages = count($rows);
$limit = 5;
$adjacents = 3;
if(isset($_GET['page']))
{
$page = $_GET['page'];
if(preg_match('/[^0-9]/i', $page))
{
echo "SQL Injection detected!";
exit();
}
}
if(isset($page))
$start = ($page - 1) * $limit; 			//first item to display on this page
else
$start = 0;

$result = $db->query("SELECT rowid, Title, Notes FROM $tablename LIMIT '$start', '$limit'");

$i = 1;
foreach($result as $row)
{
	echo "<div id=\"mainContent\">";
	echo "<span class=\"underline\">" . stripslashes($row['Title']) . "</span><br><br>" . nl2br($row['Notes']) . "\n";
	echo "<br><br><hr><div id=\"alignleft\"></div><div id=\"alignright\"><a href='delete.php?id=" . $row['rowid'] . "' onclick=\"javascript:return confirm('Delete permanently?')\"><img src='remove.png' border='0' title='Delete'></a> <a href='edit.php?id=" . $row['rowid'] . "'><img src='edit.png' border='0' title='Edit'></a></div><div style=\"clear: both;\"></div>";
	echo "</div>";
	$i++;
}
$db = NULL;
/*
	Plugin Name: *Digg Style Paginator
	Plugin URI: http://www.mis-algoritmos.com/2006/11/23/paginacion-al-estilo-digg-y-sabrosus/
	Description: Adds a <strong>digg style pagination</strong>.
	Version: 0.1 Beta
*/
function pagination($total_pages,$limit,$page,$file,$adjacents){
		#$total_pages; //total number of rows in data table
		#$limit; //how many items to show per page
		#$page = isset($_GET['page'])?$_GET['page']:1;

		#$file = "paginator.php";
		#$file = array("digg-[...].html","[...]");
		#$adjacents = 3;

		/* Setup vars for query. */
		if($page)
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;								//if no page var is given, set start to 0

		/* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//anterior page is page - 1
		$siguiente = $page + 1;							//siguiente page is page + 1
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1

		/*
			Now we apply our rules and draw the pagination object.
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/

		$url_friendly = false;
		if(is_array($file))
			$url_friendly=true;

		$p = false;
		if(strpos($file,"?")>0)
			$p = true;

		ob_start();
		if($lastpage > 1){
				echo "<div class=\"pages\">";
				//anterior button
				if($page > 1)
						if($url_friendly)
								echo "<a href=\"".str_replace($file[1],$prev,$file[0])."\"><< Previous</a>";
							else
								if($p)
									echo "<a href=\"$file$prev\"><< Previous</a>";
									else
									echo "<a href=\"$file$prev\"><< Previous</a>";
					else
						echo "<span class=\"nextprev\"><< Previous</span>";
				//pages
				if ($lastpage < 7 + ($adjacents * 2)){//not enough pages to bother breaking it up
						for ($counter = 1; $counter <= $lastpage; $counter++){
								if ($counter == $page)
										echo "<span class=\"current\">$counter</span>";
									else
										if($url_friendly)
												echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
											else
												if($p)
												echo "<a href=\"$file$counter\">$counter</a>";
												else
												echo "<a href=\"$file?page=$counter\">$counter</a>";
							}
					}
				elseif($lastpage > 5 + ($adjacents * 2)){//enough pages to hide some
						//close to beginning; only hide later pages
						if($page < 1 + ($adjacents * 2)){
								for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
										if ($counter == $page)
												echo "<span class=\"current\">$counter</span>";
											else
												if($url_friendly)
														echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
													else
														if($p)
														echo "<a href=\"$file$counter\">$counter</a>";
														else
														echo "<a href=\"$file?page=$counter\">$counter</a>";
									}
								echo "<b>...</b>";
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],$lpm1,$file[0])."\">$lpm1</a>";
										echo "<a href=\"".str_replace($file[1],$lastpage,$file[0])."\">$lastpage</a>";
									}else{
										if($p){
										echo "<a href=\"$file$lpm1\">$lpm1</a>";
										echo "<a href=\"$file$lastpage\">$lastpage</a>";
										}else{
										echo "<a href=\"$file?page=$lpm1\">$lpm1</a>";
										echo "<a href=\"$file?page=$lastpage\">$lastpage</a>";
										}

									}
							}
						//in middle; hide some front and some back
						elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],1,$file[0])."\">1</a>";
										echo "<a href=\"".str_replace($file[1],2,$file[0])."\">2</a>";
									}else{
										if($p){
										echo "<a href=\"{$file}1\">1</a>";
										echo "<a href=\"{$file}2\">2</a>";
										}else{
										echo "<a href=\"$file?page=1\">1</a>";
										echo "<a href=\"$file?page=2\">2</a>";
										}
									}
								echo "<b>...</b>";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
									if ($counter == $page)
											echo "<span class=\"current\">$counter</span>";
										else
											if($url_friendly)
													echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
												else
													if($p)
													echo "<a href=\"$file$counter\">$counter</a>";
													else
													echo "<a href=\"$file?page=$counter\">$counter</a>";
								echo "<b>...</b>";
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],$lpm1,$file[0])."\">$lpm1</a>";
										echo "<a href=\"".str_replace($file[1],$lastpage,$file[0])."\">$lastpage</a>";
									}else{
										if($p){
										echo "<a href=\"$file$lpm1\">$lpm1</a>";
										echo "<a href=\"$file$lastpage\">$lastpage</a>";
										}else{
										echo "<a href=\"$file?page=$lpm1\">$lpm1</a>";
										echo "<a href=\"$file?page=$lastpage\">$lastpage</a>";
										}
									}
							}
						//close to end; only hide early pages
						else{
								if($url_friendly){
										echo "<a href=\"".str_replace($file[1],1,$file[0])."\">1</a>";
										echo "<a href=\"".str_replace($file[1],2,$file[0])."\">2</a>";
									}else{
										if($p){
										echo "<a href=\"{$file}1\">1</a>";
										echo "<a href=\"{$file}2\">2</a>";
										}else{
										echo "<a href=\"$file?page=1\">1</a>";
										echo "<a href=\"$file?page=2\">2</a>";
										}
									}
								echo "<b>...</b>";
								for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
									if ($counter == $page)
											echo "<span class=\"current\">$counter</span>";
										else
											if($url_friendly)
													echo "<a href=\"".str_replace($file[1],$counter,$file[0])."\">$counter</a>";
												else
													if($p)
													echo "<a href=\"$file$counter\">$counter</a>";
													else
													echo "<a href=\"$file?page=$counter\">$counter</a>";
							}
					}
				//siguiente button
				if ($page < $counter - 1)
						if($url_friendly)
								echo "<a href=\"".str_replace($file[1],$siguiente,$file[0])."\">Siguiente >></a>";
							else
								if($p)
								echo "<a href=\"$file$siguiente\">Next >></a>";
								else
								echo "<a href=\"$file?page=$siguiente\">Next >></a>";
					else
						echo "<span class=\"nextprev\">Next >></span>";
				echo "</div>\n";
			}
		return utf8_decode(ob_get_clean());
	}

if(!isset($page))
$page=1;
echo pagination($total_pages,$limit,$page,"main.php?page=",$adjacents);
?>
</div>
</body>
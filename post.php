<?php
ini_set('display_errors', 1);
// Add your posting code here.
// 
// To send a user to a different page (after possibly executing some code,
// you can use the statement:
//
//     header('Location: view.php');
//
// This will send the user tp view.php. To use this mechanism, the
// statement must be executed before any of the document is output.

session_start();

// don't let user jump to here
if($_POST == null)
{
	header("Location: index.php");
	exit;
}

$host = "localhost";
$user = "chattr";
$pass = "toomanysecrets";
$db = "chattr";
$con = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass") or die ("Failed connection\n");
$text = $_POST['TEXT'];
// encode to html
$text = htmlentities($text);
// escape sql
$text = pg_escape_string($text);
$username = $_SESSION['username'];
// encode to html
$username = htmlentities($username);
// escape sql
$username = pg_escape_string($username);

// need to get the hashuser back
$query = pg_query($con, "SELECT username, salt FROM poster");
while($row = pg_fetch_row($query))
{
	$hashuser = md5($username . $row[1]);
	if($hashuser == $row[0])
	{
		$stmt = "INSERT INTO post(post_ref, message) VALUES('$hashuser', '$text')";
		pg_query($con, $stmt);
		header("Location: view.php?user=$username");
		exit;
	}
}
?>

<?php
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
	header("Location: index.php");

$host = "localhost";
$user = "chattr";
$pass = "toomanysecrets";
$db = "chattr";
$con = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass") or die ("Failed connection\n");
$text = $_POST['TEXT'];
$username = $_SESSION['username'];
$stmt = "INSERT INTO post(post_ref, message) VALUES('$username', '$text')";
pg_query($con, $stmt);
header("Location: view.php?user=$username");
?>

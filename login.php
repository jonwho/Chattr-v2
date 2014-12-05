<DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 3.2//EN">
<HEAD>
    <TITLE>Chattr</TITLE>
</HEAD>
<BODY BGCOLOR=WHITE>
<TABLE ALIGN="CENTER">
<TR><TD>
<H1>Chattr</H1>
</TD></TR>
<TR><TD>
</TD></TR>
<?php

// The login.php is invoked when the user is either trying to create a new
// account or to login. If it's the former, the NEW parameter will be set.
// To send a user to a different page (after possibly executing some code,
// you can use the statement:
//
//     header('Location: view.php');
//
// This will send the user to view.php. To use this mechanism, the
// statement must be executed before any of the document is output.

session_start();
$host = "localhost";
$user = "chattr";
$pass = "toomanysecrets";
$db = "chattr";
$con = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass") or die ("Failed connection\n");

// don't let user jump to login.php
if($_POST == null)
	header("Location: index.php");

$username = $_POST['USER'];
$password = $_POST['PASS'];
if(isset($_POST['NEW'])) 
{
	// Your new user creation code goes here. If the user name
	// already exists, then display an error. Otherwise, create a new
	// user account and send him to view.php.
	$stmt = "INSERT INTO poster(username, password) VALUES('$username', '$password')";
	$query = pg_query($con, $stmt);
	if($query)
	{
		$_SESSION['username'] = $username;
		header("Location: view.php?user=$username");
	}
	else
	{
		session_unset();
?>
		<TR>
			<TD>
				<H2><?php echo "User $username already exists!" ?></H2>
				<a href="index.php">Back</a>
			</TD>
		</TR>
<?php
	}
} 
else 
{
	// Your user login code goes here. If the user name and password
	// are not correct, then display an error. Otherwise, log in the
	// user and send him to view.php.
	$query = pg_query($con, "SELECT username FROM poster WHERE username='$username' AND password='$password'");
	if(!$row = pg_fetch_row($query))
	{
		session_unset();
?>
		<TR>
			<TD>
				<H2><?php echo "Login Failed!" ?></H2>
				<a href="index.php">Back</a>
			</TD>
		</TR>
<?php
	}
	else
	{
		$_SESSION['username'] = $username;
		header("Location: view.php?user=$username");
	}
}
?>
</TABLE>
</BODY>

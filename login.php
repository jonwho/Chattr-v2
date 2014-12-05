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
ini_set('display_errors', 1);
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
{
	header("Location: index.php");
	exit;
}

$username = $_POST['USER'];
// encode to html
$username = htmlentities($username);
// escape sql
$username = pg_escape_string($username);
$password = $_POST['PASS'];
// encode to html
$password = htmlentities($password);
// escape sql
$password = pg_escape_string($password);

// hash + salt the username and password
$salt = bin2hex(openssl_random_pseudo_bytes(25));
$hashuser = md5($username . $salt);
$hashpass = md5($password . $salt);
if(isset($_POST['NEW'])) 
{
	// Your new user creation code goes here. If the user name
	// already exists, then display an error. Otherwise, create a new
	// user account and send him to view.php.

	$stmt = "INSERT INTO poster(username, salt, password) VALUES('$hashuser', '$salt', '$hashpass')";
	$query = pg_query($con, $stmt);
	if($query)
	{
		$_SESSION['username'] = $username;
		header("Location: view.php?user=$username");
		exit;
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
	$query = pg_query($con, "SELECT username, salt, password FROM poster");

	while($row = pg_fetch_row($query)) 
	{
		$testuser = md5($username . $row[1]);
		$testpass = md5($password . $row[1]);
		if($testuser == $row[0] AND $testpass == $row[2])
		{
			$_SESSION['username'] = $username;
			header("Location: view.php?user=$username");
			exit;
		}
	}
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
?>
</TABLE>
</BODY>

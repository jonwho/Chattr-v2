<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 3.2//EN">
<HEAD>
    <TITLE>Chattr</TITLE>
</HEAD>
<BODY BGCOLOR=WHITE>
<TABLE ALIGN="CENTER">
<TR><TD>
<H1>Chattr</H1>
</TD></TR>

<?php
    $host = "localhost";
    $user = "chattr";
    $pass = "toomanysecrets";
    $db = "chattr";
    $con = pg_connect("host=$host port=5432 dbname=$db user=$user password=$pass") or die ("Failed connection\n");
    $urlName = $_GET['user'];
?>

<?php
	// The following <TR> element should only appear if the user is
	// logged in and viewing his own entry.
    session_start();
    $username = $_SESSION['username'];

    if($_GET == null and $username == null)
        header("Location: index.php");

    // if logged in and no args on view.php still view self-posts
    if($username == $urlName or ($username != null and $_GET == null))
    {
?>
    <TR><TD>
    <FORM ACTION="post.php" METHOD="POST">
    <TABLE CELLPADDING=5>
    <TR><TD>Message:</TD><TD><INPUT TYPE="TEXT" NAME="TEXT">
    <INPUT TYPE="SUBMIT" VALUE="Submit"></TD></TR>
    </TABLE>
    </FORM>
    </TD></TR>
<?php 
    } 
?>  
<?php
    // The following <TR> element should always appear if the user
    // exists.
    $stmt = "SELECT username FROM poster WHERE username='$urlName'";
    $query = pg_query($con, $stmt);
    $validUser = pg_fetch_row($query);
    // if a row exists with that user then it's true
    if($validUser or ($username != null and $_GET == null))
    {
?>
    <TR><TD>
    <TABLE CELLPADDING=5>
    <TR><TH>When</TH><TH>Who</TH><TH>What</TH></TR>
<?php
		// Display user's posts here. The structure is:
		//
		//     <TR>
		//         <TD>DATE GOES HERE</TD>
		//         <TD>USER NAME GOES HERE</TD>
		//         <TD>MESSAGE TEXT GOES HERE</TD>
		//     </TR>
        $postStmt = "SELECT posttime, post_ref, message FROM post WHERE post_ref='$urlName'";
        // overwrite postStmt if $_GET is null
        if($_GET == null)
            $postStmt = "SELECT posttime, post_ref, message FROM post WHERE post_ref='$username'";
        $postQuery = pg_query($con, $postStmt);
        while($row = pg_fetch_row($postQuery))
        {
?>
            <TR>
                <TD><?php echo "$row[0]" ?></TD>
                <TD><?php echo "$row[1]" ?></TD>
                <TD><?php echo "$row[2]" ?></TD>
            </TR>
<?php
        }
    }
?>
    </TABLE>
    </TD></TR>
<?php
	// The following <TR> element should be displayed if the user
	// name does not exist. Add code to display user name.
    
    if(!$validUser and $urlName != null)
    {
?>
    <TR><TD>
    <H2>User <?php echo "$urlName" ?> does not exist!</H2>
    </TD></TR>
<?php
    }
?>
<?php
    // The following <TR> element should only be shown if the user
    // is logged in. 
    if($username != null)
    {
?>
<TR><TD><A HREF="logout.php">Logout</A></TR></TD>
<?php
	}// Done!
?>
</TABLE>
</BODY>


<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 3.2//EN">
<HEAD>
<TITLE>Chattr</TITLE>
</HEAD>
<BODY BGCOLOR=WHITE>
	<?php
		ini_set('display_errors', 1);
		session_start();
		$username = $_SESSION['username'];
		// encode to html
		$username = htmlentities($username);
		// escape sql
		$username = pg_escape_string($username);
		if($username != null)
			header("Location: view.php?user=$username");
	?>
<TABLE ALIGN="CENTER">
<TR><TD>
<H1>Chattr</H1>
</TD></TR>
<TR><TD>
<FORM ACTION="login.php" METHOD="POST">
<TABLE CELLPADDING=5>
<TR><TD>User name:</TD><TD><INPUT TYPE="TEXT" NAME="USER"></TD></TR>
<TR><TD>Password:</TD><TD><INPUT TYPE="PASSWORD" NAME="PASS"></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE="CHECKBOX" NAME="NEW" VALUE="YES">&nbsp;New user&nbsp;
<INPUT TYPE="SUBMIT" VALUE="Submit"></TD></TR>
</TABLE>
</FORM>
</TD></TR>
</TABLE>
</BODY>

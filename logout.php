<?php
ini_set('display_errors', 1);
// Your logout code goes here.
session_start();
session_unset();
header("Location: index.php");
exit();
?>

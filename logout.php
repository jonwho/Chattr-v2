<?php

// Your logout code goes here.
session_start();
session_unset();
header("Location: index.php");
?>

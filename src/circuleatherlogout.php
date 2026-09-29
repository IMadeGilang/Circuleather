<?php
session_start();

session_destroy();

header("Location: circuleatherinlog.php");
exit();
?>

<?php
// Include FB config file

require_once 'fbConfig.php';

destroySession();
// Redirect to the homepage
header("Location:index.php");
?>
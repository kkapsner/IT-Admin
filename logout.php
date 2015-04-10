<?php
/*
 * Performs a logout.
 */

/* @var $ldap LDAP */

session_start();
unset($_SESSION["userID"]);
header("Location: ./");

?>

<?php

$servername = "database";
$username = "root";
$password = "root";
$banco = "test";

$link = mysql_connect($servername, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully';

mysql_select_db($banco, $link);
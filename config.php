<?php

$host = "localhost";    /* Host name */
$user = "gemc2020_webinar";         /* User */
$password = "4?HJ1wb+TkR3";         /* Password */
$dbname = "gemc2020_webinar";   /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 	die("Connection failed: " . mysqli_connect_error());
}

<?php
require_once 'vendor/autoload.php';
require_once 'db.php';
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'testDB';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die ('Non riesco a connettermi: ' . mysqli_connect_error($conn));
}
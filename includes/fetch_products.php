<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();

$sql = "select * from products where p_STATUS != 'deleted' and p_AVAILABILITY like 'yes' order by p_ID desc";
$results = $functions->fetch_rows($functions->query($sql));
echo json_encode($results);
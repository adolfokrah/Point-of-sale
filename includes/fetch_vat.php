<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();

$sql = "select * from company_details";
$results = $functions->fetch_rows($functions->query($sql));

echo $results[0]['vat_charges'];
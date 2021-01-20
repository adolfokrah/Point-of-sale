<?php
 include_once 'connection.php';
 include_once 'includes/sessions.php';
 include_once 'includes/layout/header.php';
 include_once 'includes/functions.php';

 $session = new Session();
 $functions = new Functions();

 $functions->view_page_permission_access();
?>
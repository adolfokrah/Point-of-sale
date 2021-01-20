<?php

include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();


    $total_qty = 0;
    $total_price = 0;

    $paid_qty = 0;
    $unpaid_qty = 0;
    $paid_net_amount = 0;
    $unpaid_net_amount = 0;

    $sql = "select *, sum(or_net_amount) as or_net_amount from orders where or_payment_status = 'Paid' group by year(date_time)";


    $results = $functions->fetch_rows($functions->query($sql));
    $paid_net_amount = sprintf('%0.2f',$results[0]['or_net_amount']);


    $sql = "select *, sum(or_net_amount) as or_net_amount from orders where or_payment_status = 'Unpaid' group by year(date_time)";


    $results = $functions->fetch_rows($functions->query($sql));
    $unpaid_net_amount = sprintf('%0.2f',$results[0]['or_net_amount']);

    $array = array((double) $paid_net_amount,(double) $unpaid_net_amount);
    echo json_encode($array);
?>

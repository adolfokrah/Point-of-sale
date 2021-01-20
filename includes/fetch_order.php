<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();
$_POST = json_decode(file_get_contents("php://input"),true);
$orderId = $_POST['orderId'];
$orderId = $functions->real_escape($orderId);

$sql = "select * from orders left join cart on orders.order_id = cart.order_id where cart.order_id = '$orderId'";

$results = $functions->fetch_rows($functions->query($sql));

$order_summary = array();
$cart = array();

$order_summary['amount_received'] = $results[0]['or_amount_received'];
$order_summary['customer_address'] = $results[0]['or_customer_address'];
$order_summary['customer_name'] = $results[0]['or_customer_name'];
$order_summary['customer_phone'] = $results[0]['or_customer_phone'];
$order_summary['discount'] = $results[0]['or_discount'];
$order_summary['gross_amount'] = $results[0]['or_gross_amount'];
$order_summary['net_amount'] = $results[0]['or_net_amount'];
$order_summary['order_id'] = $results[0]['or_order_id'];
$order_summary['payment_status'] = $results[0]['or_payment_status'];
$order_summary['vat'] = $results[0]['or_vat'];
$order_summary['order_id'] = $results[0]['order_id'];
$order_summary['vat_percentage'] = $results[0]['or_vat_percentage'];
$order_summary['sold_by'] = $results[0]['sold_by'];
$order_summary['modified_by'] = $results[0]['modified_by'];

foreach ($results as $item) {
    $array = array();
    $array['p_NAME'] = $item['cart_p_NAME'];
    $array['p_PRICE'] = ' ¢ '.sprintf('%0.2f',$item['cart_p_PRICE']);
    $array['p_AMOUNT'] = ' ¢ '.sprintf('%0.2f',$item['cart_p_AMOUNT']);
    $array['p_QTY'] = $item['cart_p_QTY'];
    $array['cart_id'] = $item['cart_id'];
    $array['p_STATUS'] = $item['status'];
    $array['p_ID'] = $item['cart_p_ID'];
    $array['p_NEW'] = 'FALSE';
    array_push($cart,$array);
}

$fields = array();

array_push($fields,$order_summary);
array_push($fields,$cart);

echo json_encode($fields);
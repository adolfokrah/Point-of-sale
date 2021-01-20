<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();
$_POST = json_decode(file_get_contents("php://input"),true);
$cart = $_POST['cart'];
unset($_POST['cart']);

$order_id = 'sdfsdfsdfsd';
$date = date('Y-m-d H:i');

$sql = "insert INTO `orders` (`order_id`, `user_id`, `or_gross_amount`, `or_vat`, `or_discount`, `or_net_amount`, `or_payment_status`, `or_amount_received`, `or_customer_name`, `or_customer_address`, `or_customer_phone`, `or_order_id`, `date_time`,`or_vat_percentage`,`sold_by`,`modified_by`) VALUES (NULL, '".$functions->real_escape($_SESSION['user_id'])."', '".$functions->real_escape($_POST['gross_amount'])."', '".$functions->real_escape($_POST['vat'])."', '".$functions->real_escape($_POST['discount'])."', '".$functions->real_escape($_POST['net_amount'])."', '".$functions->real_escape($_POST['payment_status'])."', '".$functions->real_escape($_POST['amount_received'])."', '".$functions->real_escape($_POST['customer_name'])."', '".$functions->real_escape($_POST['customer_address'])."', '".$functions->real_escape($_POST['customer_phone'])."', '', '".$functions->real_escape($date)."','".$functions->real_escape($_POST['vat_percentage'])."','".$functions->real_escape($_SESSION['user_data']['user_name'])."','');";

$functions->query($sql);
$order_id = $functions->get_insert_id();
$or_order_id = $invID = 'OD-'.str_pad($order_id, 5, '0', STR_PAD_LEFT);

$sql = '';

foreach ($cart as $item) {
    
    $item['p_PRICE'] = str_replace(' ¢ ','',$item['p_PRICE']);
    $item['p_AMOUNT'] = str_replace(' ¢ ','',$item['p_AMOUNT']);
    $sql ="insert INTO `cart` (`cart_id`, `order_id`, `cart_p_NAME`, `cart_p_PRICE`, `cart_p_ID`, `cart_p_AMOUNT`, `cart_p_QTY`, `status`) VALUES (NULL, '$order_id', '".$functions->real_escape($item['p_NAME'])."', '".$functions->real_escape($item['p_PRICE'])."', '".$functions->real_escape($item['p_ID'])."', '".$functions->real_escape($item['p_AMOUNT'])."', '".$functions->real_escape($item['p_QTY'])."', 'active')";
    $functions->query($sql);
   

    $action = "Product sold <strong>(-".$item['p_QTY'].")</strong> from order <a href=\"edit_order.php?order=$order_id\">$or_order_id</a>";
    $functions->insert_product_history($action,$item['p_ID']);
}
$_SESSION['success'] = 'order saved successfully';
echo $order_id;

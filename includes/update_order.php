<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();
$_POST = json_decode(file_get_contents("php://input"),true);
$cart = $_POST['cart'];
unset($_POST['cart']);


//$date = gmdate('Y-m-d H:s');

$sql = "update `orders` SET `or_gross_amount` = '".$functions->real_escape($_POST['gross_amount'])."', `or_vat` = '".$functions->real_escape($_POST['vat'])."', `or_discount` = '".$functions->real_escape($_POST['discount'])."', `or_net_amount` = '".$functions->real_escape($_POST['net_amount'])."', `or_payment_status` =  '".$functions->real_escape($_POST['payment_status'])."', `or_amount_received` = '".$functions->real_escape($_POST['amount_received'])."', `or_customer_name` =  '".$functions->real_escape($_POST['customer_name'])."', `or_customer_address` = '".$functions->real_escape($_POST['customer_address'])."', `or_customer_phone` = '".$functions->real_escape($_POST['customer_phone'])."',`or_vat_percentage`='".$functions->real_escape($_POST['vat_percentage'])."',`modified_by`='".$functions->real_escape($_SESSION['user_data']['user_name'])."' WHERE `orders`.`order_id` = '".$functions->real_escape($_POST['order_id'])."'";

$functions->query($sql);


// $order_id = $functions->get_insert_id();
// $sql = '';

$order_id = $_POST['order_id'];
$or_order_id = $invID = 'OD-'.str_pad($order_id, 5, '0', STR_PAD_LEFT);

foreach ($cart as $item) {
    $sql = "select * from cart where cart_id = '".$item['cart_id']."'";
    $results = $functions->fetch_rows($functions->query($sql));
    if(sizeof($results) > 0){
        $item['p_PRICE'] = str_replace(' ¢ ','',$item['p_PRICE']);
        $item['p_AMOUNT'] = str_replace(' ¢ ','',$item['p_AMOUNT']);

        $sql2 = "update `cart` SET `cart_p_PRICE` = '".$functions->real_escape($item['p_PRICE'])."', `cart_p_AMOUNT` = '".$functions->real_escape($item['p_AMOUNT'])."', `cart_p_QTY` =  '".$functions->real_escape($item['p_QTY'])."', `status` =  '".$functions->real_escape($item['p_STATUS'])."' WHERE `cart`.`cart_id` =  '".$functions->real_escape($item['cart_id'])."'";

        $functions->query($sql2);

        $action = '';
        $new_qty = $item['p_QTY'] - $results[0]['cart_p_QTY'];
        if($new_qty < 0){
            $action = "Product returned <strong>(".($new_qty * -1).")</strong> from order <a href=\"edit_order.php?order=$order_id\">$or_order_id</a>";
        }else if($new_qty > 0){
            $action = "Product sold <strong>(-".$new_qty.")</strong> from order <a href=\"edit_order.php?order=$order_id\">$or_order_id</a>";
        }else if($item['p_STATUS'] == 'returned' && $results[0]['status'] != 'returned'){
            $action = "Product returned <strong>(".$item['p_QTY'].")</strong> from order <a href=\"edit_order.php?order=$order_id\">$or_order_id</a>";
        }

        if($action != ''){
            $functions->insert_product_history($action,$item['p_ID']);
        }

        // echo $sql2.'....';
    }else{
        $item['p_PRICE'] = str_replace(' ¢ ','',$item['p_PRICE']);
        $item['p_AMOUNT'] = str_replace(' ¢ ','',$item['p_AMOUNT']);
        $sql ="INSERT INTO `cart` (`cart_id`, `order_id`, `cart_p_NAME`, `cart_p_PRICE`, `cart_p_ID`, `cart_p_AMOUNT`, `cart_p_QTY`, `status`) VALUES (NULL, '$order_id', '".$functions->real_escape($item['p_NAME'])."', '".$functions->real_escape($item['p_PRICE'])."', '".$functions->real_escape($item['p_ID'])."', '".$functions->real_escape($item['p_AMOUNT'])."', '".$functions->real_escape($item['p_QTY'])."', 'active')";
            $functions->query($sql);

        $action = "Product sold <strong>(-".$item['p_QTY'].")</strong>";
        $functions->insert_product_history($action,$item['p_ID']);
    }
}
$_SESSION['success'] = 'order updated successfully';
echo $order_id;
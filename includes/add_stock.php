<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';

$session = new Session();
$functions = new Functions();

$qty = $functions->real_escape($_POST['new_qty']);
$p_id = $functions->real_escape($_POST['p_id']);

$sql = "select * from products where p_ID = '$p_id'";

$results = $functions->fetch_rows($functions->query($sql));
$new_qty = $qty + $results[0]['p_QTY'];

$sql = "update products set p_QTY = $new_qty where p_ID = $p_id";
$functions->query($sql);

$action = "Product quantity added <strong>($qty)</strong>";
$functions->insert_product_history($action,$p_id);


$sql = "select * from products where p_ID = '$p_id'";
$results = $functions->fetch_rows($functions->query($sql));

$sql = "select *,sum(cart.cart_p_QTY) as cart_p_QTY from products left join cart on products.p_ID = cart.cart_p_ID where products.p_STATUS != 'deleted' and cart.status = 'active' and products.p_ID = '".$results[0]['p_ID']."'";
$fetch = $functions->fetch_rows($functions->query($sql));

$cart_total = $fetch[0]['cart_p_QTY'];
$results[0]['p_QTY'] = $results[0]['p_QTY'] - $cart_total;

$action = "Product quantity updated <strong>(".$results[0]['p_QTY'] .")</strong>";
$functions->insert_product_history($action,$p_id);

$new_qty = $results[0]['p_QTY'];
$low_alert = $new_qty;
$result = $results[0];

if($new_qty <= $result['p_LOW_ALERT']){
    $low_alert = $low_alert.' <a class="ui orange  label">
     Low !
   </a>';
}

echo $low_alert;
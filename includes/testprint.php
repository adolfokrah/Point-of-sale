<?php
include_once 'connection.php';
include_once 'sessions.php';
include_once 'functions.php';


$session = new Session();
$functions = new Functions();

$order_id = $functions->real_escape($_GET['order_id']);

$sql = "select * from orders left join cart on orders.order_id = cart.order_id where cart.status = 'active' and  cart.order_id = '$order_id'";

$results = $functions->fetch_rows($functions->query($sql));

$order_summary = array();
$cart = array();
$sql = "select * from company_details";
$company_details = $functions->fetch_rows($functions->query($sql))[0]; 

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
$order_summary['date_time'] = $results[0]['date_time'];

foreach ($results as $item) {
    $array = array();
    $array['p_NAME'] = $item['cart_p_NAME'];
    $array['p_PRICE'] = sprintf('%0.2f',$item['cart_p_PRICE']);
    $array['p_AMOUNT'] = sprintf('%0.2f',$item['cart_p_AMOUNT']);
    $array['p_QTY'] = $item['cart_p_QTY'];
    $array['cart_id'] = $item['cart_id'];
    $array['p_STATUS'] = $item['status'];
    $array['p_ID'] = $item['cart_p_ID'];
    $array['p_NEW'] = 'FALSE';
    $array['vat_percentage'] = $item['or_vat_percentage'];
    array_push($cart,$array);
}

$top_up = $order_summary['net_amount'] - $order_summary['amount_received'];


$top_up_text = $top_up <= 0 ? 'Balance' : 'Top up';

$total_qty = 0;
?>
<body onload="print_receipt()">
    
<table style="width:100%;">
    <thead>
        <tr>
            <th colspan="4" style="font-size:20px;  font-family:courier">Receipt</th>
        </tr>
        <tr>
            <th colspan="4" style="font-size:18px; font-family:courier"><?php echo $company_details['company_name']; ?></th>
        </tr>
        <tr>
            <th colspan="4" style="font-size:15px; font-wieght:200; font-family:courier"><?php echo $company_details['phone']; ?></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th colspan="4" style="font-weight:100; padding-top:20px; font-size:13px; font-family:courier" align="left">Order Id : <?php   echo $or_order_id = $invID = 'OD-'.str_pad($order_id, 5, '0', STR_PAD_LEFT);?></th>
        </trd>
        <tr>
            <th colspan="4" style="font-weight:100; font-size:13px; font-family:courier" align="left">Date : <?php   echo gmdate('l d M, Y',strtotime($order_summary['date_time']));?></th>
        </trd>
        <tr>
            <th colspan="4" style="font-weight:100; font-size:13px; font-family:courier" align="left">Cashier : <?php   echo $order_summary['sold_by'];?></th>
        </trd>
        <tr>
            <th colspan="4" style="font-weight:100; font-size:13px; font-family:courier" align="left">Time : <?php   echo gmdate('h:i A',strtotime($order_summary['date_time']));?></th>
        </trd>
    <thead>
    <thead>
        <tr>
            <th align="left" style="padding-top:20px; font-family:courier; font-size:12px;">Item</th>
            <th style="padding-top:20px; font-family:courier; font-size:12px;">Price</th>
            <th style="padding-top:20px; font-family:courier; font-size:12px;">Qty</th>
            <th align="right" style="padding-top:20px; padding-right:10px; font-family:courier; font-size:12px;">Sub total</th>
        </trd>
    </thead>

    <thead>
        <tr>
            <th colspan="4" style=" font-family:courier; border-bottom:2px dotted black;"></th>
        </trd>
    </thead>

    <tbody>
        <?php foreach($cart as $item): ?>
            <?php $total_qty = $total_qty + $item['p_QTY']; ?>
            <tr>
                <td style="font-weight:100; max-width:100px; font-size:12px; font-family:courier; padding-top:0px"><?php echo $item['p_NAME'] ?></td>
                <td align="center" style="font-weight:100; font-size:12px; font-family:courier; padding-top:0px"><?php echo $item['p_PRICE'] ?></td>
                <td align="center" style="font-weight:100; font-size:12px; font-family:courier; padding-top:0px"><?php echo $item['p_QTY'] ?></td>
                <td align="right" style="font-weight:100; padding-right:10px; font-size:12px; font-family:courier; padding-top:0px"><?php echo sprintf('%0.2f',$item['p_QTY'] * str_replace(' ¢ ',"",$item['p_PRICE'])) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <thead>
        <tr>
            <th colspan="4" style=" font-family:courier; border-bottom:2px dotted black;"></th>
        </trd>
        <tr>
             <th style="font-weight:100; font-size:13px; font-family:courier; padding-top:10px" align="left" colspan="4">Items Count: <?php echo $total_qty ?></th>
        </tr>

        <tr>
             <th style="font-weight:100; font-size:13px; padding-top:10px; font-family:courier; " align="left" colspan="1">Subtotal</th>
             <th style="font-weight:100; font-size:13px; padding-top:10px; padding-right:10px; font-family:courier; " align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',$order_summary['gross_amount']) ?></th>
        </tr>
        <tr>
             <th style="font-weight:100; font-size:13px;  font-family:courier; " align="left" colspan="1">VAT @ <?php echo $order_summary['vat_percentage']?>%</th>
             <th style="font-weight:100; font-size:13px;  font-family:courier; padding-right:10px; " align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',$order_summary['vat']) ?></th>
        </tr>
        <tr>
             <th style="font-weight:100; font-size:13px;  font-family:courier; "align="left" colspan="1">Discount</th>
             <th style="font-weight:100; font-size:13px;  font-family:courier; padding-right:10px;"align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',$order_summary['discount']) ?></th>
        </tr>

        <tr>
             <th style="font-weight:bolder;  font-size:16px; font-family:courier; padding-top:10px" align="left" colspan="1">TOTAL</th>
             <th style="font-weight:bolder;  font-size:16px;  font-family:courier; padding-right:10px; padding-top:10px" align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',$order_summary['net_amount']) ?></th>
        </tr>
        <tr>
            <th colspan="4" style=" font-family:courier; border-bottom:2px dotted black;"></th>
        </tr>
        <tr>
             <th style="font-weight:100; font-size:13px; paddin-top:50px;  font-family:courier; "align="left" colspan="1">Cash</th>
             <th style="font-weight:100; font-size:13px;  font-family:courier; padding-right:10px; "align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',$order_summary['amount_received']) ?></th>
        </tr>
        <tr>
             <th style="font-weight:100; font-size:13px; paddin-top:50px;  font-family:courier; "align="left" colspan="1">Amount Paid</th>
             <th style="font-weight:100; font-size:13px;  font-family:courier; padding-right:10px;"align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',$order_summary['amount_received']) ?></th>
        </tr>
        <tr>
             <th style="font-weight:100; font-size:13px;  font-family:courier; "align="left" colspan="1"><?php echo $top_up_text;?></th>
             <th style="font-weight:100; font-size:13px;  font-family:courier; padding-right:10px;"align="right" colspan="3"><?php echo ' ¢ '.sprintf('%0.2f',str_replace('-','',$top_up)) ?></th>
        </tr>
        <tr>
            <th style="font-weight:100; font-size:13px; padding-top:20px; font-family:courier; "align="center" colspan="4"><?php echo $company_details['message'];?></th>
        </td>
        <tr>
            <th style="font-weight:100; font-size:13px; font-size:12px;padding-right:10px; font-family:courier; "align="center" colspan="4">Developed by miniworks</th>
        </td>
        <!-- <tr>
            <th style="font-weight:100; font-size:13px; font-size:12px;padding-right:10px; font-family:courier; "align="center" colspan="4">0245301631</th>
        </td> -->

    </thead>
    
    
</table>
<script>
    
function print_receipt(){
    window.print();
    window.onmousemove = function() {
     window.close();
    }
}
</script>
</body>
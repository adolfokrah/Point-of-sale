
<?php $title = 'Manage Orders'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
?>
<style>
    .card{
        width:100% !important;
    }
</style>
</head>
<body>
<?php include 'includes/layout/topBar.php' ?>
<div class="row" style="margin-top:30px">
        <div class="col-md-12 col-lg-2">
        <?php include 'includes/layout/sidebar.php' ?>
    </div>
    <div class="col-md-10 main-content">
        <div class="ui breadcrumb">
            <a class="section">Home</a>
            <div class="divider"> / </div>
            <a class="section">Orders</a>
            <div class="divider"> / </div>
            <div class="active section">Manage Orders</div>
        </div>
        <div></div>
        <?php
              $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
               $permissions = $functions->get_user_permission($path);

               if(in_array('create',$permissions)):
        ?>
        <a href="add_order.php">
            <div class="ui  small primary labeled icon button">
                <i class="add icon"></i> Add new order
            </div>
        </a>
        <?php endif ?>

        <?php
            $from = date('Y-m-d');
            $to = date('Y-m-d');
            $user_name = ($_SESSION['user_data']['user_type'] == 'admin') ? "": $_SESSION['user_data']['user_name'];
            $order_id = '';
            
            if(isset($_POST['from']) && isset($_POST['to']) && isset($_POST['user_name'])  && isset($_POST['order_id'])){
                $from = $_POST['from'];
                $to = $_POST['to'];
                $user_name = $_POST['user_name'];
                $order_id = $_POST['order_id'];
            }
        ?>
        <form action="?" method="post" style="margin-top:20px" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6 col-md-2">
                    <div class="ui input focus">
                        <input type="date" value="<?php echo $from ?>" name="from" placeholder="date">
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="ui input focus">
                        <input type="date" value="<?php echo $to ?>" name="to" placeholder="date">
                    </div>
                </div>

                <?php if($_SESSION['user_data']['user_type'] == 'admin' || !in_array('create',$permissions)):?>

                <div class="col-sm-12 col-md-2">
                 
                    <div class="form-group">
                   
                    <div class="ui input">
                    <select class="js-example-basic-single" name="user_name" style="width:100%" onchange="get_value(event)">
                        <?php 
                            $sql = "select * from users";
                            $results = $functions->fetch_rows($functions->query($sql));
                            array_push($results,array("user_name"=>"all"));

                            foreach ($results as $result) {
                                if($user_name == ''){
                                    $user_name = 'all';
                                }
                                $selected = '';
                                if($result['user_name'] == $user_name){
                                    $selected = 'selected';
                                }else{
                                    $selected  = '';
                                }
                                echo '<option value="'.$result['user_name'].'" '.$selected.'>'.$result['user_name'].'</option>';
                            }
                        ?>
                    </select>
                    </div>
                       

                </div>
                </div>
                <?php else:?>
                        <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_data']['user_name'] ?>"/>
                    <?php endif?>
                <div class="col-sm-12 col-md-2">
                    <div class="ui input focus">
                         <input type="text"  value="<?php echo $order_id; ?>" style="height:45px" name="order_id" placeholder="Order ID"/>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2">
                    <div class="ui input focus">
                        <button type="submit" style="height:43px" class="ui  small primary labeled icon button">
                            <i class="search icon"></i> Search
                        </button>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2">
                       <a  href="orders_statement.php?from=<?php echo $from ?>&to=<?php echo $to?>&user_name=<?php echo $user_name ?>&order_id=<?php echo $order_id?>">
                       <button type="button" style="height:43px" class="ui  small primary labeled icon button">
                            <i class="file icon"></i> Statement
                        </button>
                        </a>
                </div>


            </div>

        </form>

        <?php
            if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
                echo $functions->message($_SESSION['success'],'green');
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $functions->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }

            
        ?>


        <div class="ui card">
        <div class="content">
            <div class="header">Products</div>
        </div>
        <div class="content">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Customer Number</th>
                <th>Total Items</th>
                <th>Total Amount</th>
                <th>Payment Status</th>
                <th>Sold by</th>
                <th>Date Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
            $from .=' 00:00:00';
            $to .=' 23:59:59';
            if($user_name == 'all'){
                $user_name = '';
            }

            if(strpos($order_id,'OD-') > -1){
                $order_id = trim($order_id);
                $order_id = sprintf("%01s", str_replace('OD-','',$order_id) + 1);
                $order_id = $order_id - 1;
            }

            // if(!in_array('create',$permissions) && ){
            //     $user_name = '';
            // }
            if($order_id != ''){
                $sql = "select *, sum(cart.cart_p_QTY) as cart_p_QTY, sum(cart.cart_p_AMOUNT) as cart_p_AMOUNT from orders left join cart on orders.order_id = cart.order_id where orders.order_id = '$order_id'";   
            }else if($user_name != ''){
                $sql = "select *, sum(cart.cart_p_QTY) as cart_p_QTY, sum(cart.cart_p_AMOUNT) as cart_p_AMOUNT from orders left join cart on orders.order_id = cart.order_id where orders.date_time between '$from' and '$to' and orders.sold_by = '$user_name' group by orders.order_id order by orders.order_id desc";
            }else{
                 $sql = "select *, sum(cart.cart_p_QTY) as cart_p_QTY, sum(cart.cart_p_AMOUNT) as cart_p_AMOUNT from orders left join cart on orders.order_id = cart.order_id where orders.date_time between '$from' and '$to' group by orders.order_id order by orders.order_id desc";
            }
            


            $results = $functions->fetch_rows($functions->query($sql));
            foreach ($results as $result) {

                $or_order_id = $invID = 'OD-'.str_pad($result['order_id'], 5, '0', STR_PAD_LEFT);

               
                $payment_status = '<a class="ui green  label">
                 Paid
                </a>';

                $returned_times = '';

                if(strtoupper($result['or_payment_status']) == 'UNPAID'){
                    $payment_status = '<a class="ui red  label">
                    Un paid
                   </a>';
                }
                $sql = "select * from cart where order_id = '".$result['order_id']."' and status = 'returned'";
                $fetch = $functions->fetch_rows($functions->query($sql));

                if(sizeof($fetch) > 0){
                    $returned_times = ' <button  data-tooltip="Somre products where returned" data-position="top right" class="ui icon button"><i style="color:red" class="redo icon"></i></button>';
                    $returned_items_qty = 0;
                    $price_of_returned_items = 0;
                    foreach ($fetch as $item) {
                        $returned_items_qty = $returned_items_qty + $item['cart_p_QTY'];
                        $price_of_returned_items = $price_of_returned_items + $item['cart_p_AMOUNT'];
                    }

                    $result['or_net_amount'] = $result['cart_p_AMOUNT'] + $result['or_vat'] - $result['or_discount'] - $price_of_returned_items;
                    $result['cart_p_QTY'] = $result['cart_p_QTY'] - $returned_items_qty;
                }

                $actions = '';
                $msg = 'Print receipt';
                if($result['or_amount_received'] < 1){
                    $msg = 'Print Invoice';
                }
                if($result['cart_p_QTY'] > 0){
                    $actions .='<a target="_blank" href="includes/testprint.php?order_id='.$result['order_id'].'"><button data-tooltip="'.$msg.'" data-position="top right" class="ui icon button"><i class="print icon"></i></button></a>';
                }
                if(in_array('update',$permissions)){
                    $actions .= '
                    <a  href="edit_order.php?order='.$result['order_id'].'"><button data-tooltip="Edit product" data-position="top right" class="ui icon button"><i class="edit icon"></i></button></a>
                    '.$returned_times.'';
                }

                echo '<tr>
                <td>'.$or_order_id.'</td>
                <td>'.$result['or_customer_name'].'</td>
                <td>'.$result['or_customer_phone'].'</td>
                <td>'.$result['cart_p_QTY'].'</td>
                <td>¢ '.sprintf('%0.2f',$result['or_net_amount']).'</td>
                <td>'.$payment_status.'</td>
                <td>'.$result['sold_by'].'</td>
                <td>'.gmdate('d M Y h:i A',strtotime($result['date_time'])).'</td>
                <td>
                '.$actions.'
                </td>
            </tr>';
            }
         ?>
            
        </tbody>
    </table>
        </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-7"></div>
            <div class="col-sm-12 col-md-5">
            <table class="ui celled structured table">
                <thead>
                    <tr><th>Payment Status</th>
                    <th>Qty</th>
                    <th>Total Amount</th>
                </tr></thead>
                <tbody>
                <?php
                    $total_qty = 0;
                    $total_price = 0;

                    $paid_qty = 0;
                    $unpaid_qty = 0;
                    $paid_net_amount = 0;
                    $unpaid_net_amount = 0;

                    if($order_id != ''){
                        $sql = "select *, sum(or_net_amount) as or_net_amount from orders where orders.order_id = '$order_id' group by or_payment_status"; 
                    }else if($user_name != ''){
                        $sql = "select *, sum(or_net_amount) as or_net_amount from orders where orders.date_time between '$from' and '$to' and orders.sold_by = '$user_name' group by or_payment_status";
                    }else{
                        $sql = "select *, sum(or_net_amount) as or_net_amount from orders where orders.date_time between '$from' and '$to' group by or_payment_status";
                    }


                    $results = $functions->fetch_rows($functions->query($sql));

                    foreach ($results as $result) {

                        if($order_id != ''){
                            $sql = "select * from orders where or_payment_status like '".$result['or_payment_status']."' and order_id = '$order_id'";
                        }else if($user_name != ''){
                            $sql = "select * from orders where or_payment_status like '".$result['or_payment_status']."' and orders.date_time between '$from' and '$to' and sold_by = '$user_name'";
                        }else{
                            $sql = "select * from orders where or_payment_status like '".$result['or_payment_status']."' and orders.date_time between '$from' and '$to'";
                        }

                        $orders = $functions->fetch_rows($functions->query($sql));
                        
                        foreach ($orders as $order) {
                            $sql = "select *,sum(cart.cart_p_QTY) as cart_p_QTY from cart where order_id = '".$order['order_id']."' and status = 'active' ";
                            $fetch = $functions->fetch_rows($functions->query($sql));    
                            $qty = $fetch[0]['cart_p_QTY'];
                            if($result['or_payment_status'] == 'Paid'){
                                $paid_qty = $qty + $paid_qty;
                                $paid_net_amount = $result['or_net_amount'];
                            }else{
                                $unpaid_qty = $qty + $unpaid_qty;
                                $unpaid_net_amount = $result['or_net_amount'];
                            }
                            $total_qty = $total_qty + $qty;
                        }
                       
                       
                        $total_price = $result['or_net_amount'] + $total_price;
                       
                    }
                ?>

                    <tr>
                        <td data-label="Name">Paid</td>
                        <td data-label="Age"><?php echo $paid_qty ?></td>
                        <td data-label="Job"><?php echo '¢ '.sprintf('%0.2f',$paid_net_amount) ?></td>
                    </tr>

                    <tr>
                        <td data-label="Name">UnPaid</td>
                        <td data-label="Age"><?php echo $unpaid_qty ?></td>
                        <td data-label="Job"><?php echo '¢ '.sprintf('%0.2f',$unpaid_net_amount) ?></td>
                    </tr>
                    
                </tbody>
                <thead>
                    <tr><th>Total</th>
                    <th><?php echo $total_qty ?></th>
                    <th><?php echo '¢'.sprintf('%0.2f',$total_price);?></th>
                   
                </tr></thead>
                </table>
        </div>

    </div>
</div>



<?php include_once 'includes/layout/footer.php'?>
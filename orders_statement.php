
<?php $title = 'Orders Statement'; ?>
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
            <a class="section" href="orders.php">Orders</a>
            <div class="divider"> / </div>
            <div class="active section">Oders statment</div>
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
            
            if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['user_name'])  && isset($_GET['order_id'])){
                $from = $_GET['from'];
                $to = $_GET['to'];
                $user_name = $_GET['user_name'];
                $order_id = $_GET['order_id'];
            }
        ?>
        <form action="?" method="get" style="margin-top:20px" enctype="multipart/form-data">
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

                <?php if($_SESSION['user_data']['user_type'] == 'admin'):?>

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
                         <input type="text" value="<?php echo $order_id ?>" style="height:45px" name="order_id" placeholder="Order ID"/>
                    </div>
                </div>

                <div class="col-sm-12 col-md-2">
                    <div class="ui input focus">
                        <button type="submit" style="height:43px" class="ui  small primary labeled icon button">
                            <i class="search icon"></i> Search
                        </button>
                    </div>
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
                <th>Product Name</th>
                <th>Qty Sold</th>
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

            if($order_id != ''){
                $sql = "select *, sum(cart.cart_p_QTY) as cart_p_QTY, sum(cart.cart_p_AMOUNT) as cart_p_AMOUNT from orders left join cart on orders.order_id = cart.order_id where orders.order_id = '$order_id' and cart.status = 'active' group by cart.cart_p_NAME order by orders.order_id desc";
            }else if($user_name != ''){
                $sql = "select *, sum(cart.cart_p_QTY) as cart_p_QTY, sum(cart.cart_p_AMOUNT) as cart_p_AMOUNT from orders left join cart on orders.order_id = cart.order_id where orders.date_time between '$from' and '$to' and cart.status = 'active' and orders.sold_by = '$user_name' group by cart.cart_p_NAME order by orders.order_id desc";
            }else{
                 $sql = "select *, sum(cart.cart_p_QTY) as cart_p_QTY, sum(cart.cart_p_AMOUNT) as cart_p_AMOUNT from orders left join cart on orders.order_id = cart.order_id where orders.date_time between '$from' and '$to' and cart.status = 'active' group by cart.cart_p_NAME order by orders.order_id desc";
            }
            


            $results = $functions->fetch_rows($functions->query($sql));
            foreach ($results as $result) {

                $or_order_id = $invID = '';


                $actions = '';
               

                echo '<tr>
                <td>'.$result['cart_p_NAME'].'</td>
                <td>'.$result['cart_p_QTY'].'</td>
            </tr>';
            }
         ?>
            
        </tbody>
    </table>
        </div>
        </div>

        

    </div>
</div>



<?php include_once 'includes/layout/footer.php'?>
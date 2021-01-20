
<?php $title = 'Dashboard'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
?>
</head>
<body>
<?php include 'includes/layout/topBar.php' ?>
<div class="row" style="margin-top:30px">
     <div class="col-md-12 col-lg-2">
        <?php include 'includes/layout/sidebar.php' ?>
    </div>

    <?php
        $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
        $permissions = $functions->get_user_permission($path);
        $view = false;
        foreach ($permissions as $permission) {
            if($permission == 'view'){
                $view = true;
            }
        }
    ?>

    <?php if($view == true): ?>
    <div class="col-md-12 col-lg-10 main-content">
       <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="dashboard-card">
                    <div class="card-icon red">
                        <i class="user icon"></i>
                    </div>
                    <div class="card-caption">
                        <span>
                            <h3>
                                <?php
                                    $sql = "select * from users";
                                    echo $functions->fetch_num_rows($functions->query($sql));
                                ?>
                            </h3>
                            <span>Users</span>
                        <span>
                    </div>
                </div>
               
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="dashboard-card">
                    <div class="card-icon green">
                        <i class="bars icon"></i>
                    </div>
                    <div class="card-caption">
                        <span>
                            <h3>
                                <?php
                                    $sql = "select * from products group by p_CAT";
                                    echo $functions->fetch_num_rows($functions->query($sql));
                                ?>
                            </h3>
                            <span>Categories</span>
                        <span>
                    </div>
                </div>
               
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="dashboard-card">
                    <div class="card-icon blue">
                        <i class="cart icon"></i>
                    </div>
                    <div class="card-caption">
                        <span>
                            <h3>
                                <?php
                                    $sql = "select * from products";
                                    echo $functions->fetch_num_rows($functions->query($sql));
                                ?>
                            </h3>
                            <span>Products</span>
                        <span>
                    </div>
                </div>
               
            </div>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="dashboard-card">
                    <div class="card-icon yellow">
                        <i class="users icon"></i>
                    </div>
                    <div class="card-caption">
                        <span>
                            <h3>
                                <?php
                                    $sql = "select * from groups where group_name != 'admin'";
                                    echo $functions->fetch_num_rows($functions->query($sql));
                                ?>
                            </h3>
                            <span>Groups</span>
                        <span>
                    </div>
                </div>
               
            </div>
       </div>
       <div class="row" style="padding-top:30px">
            <div class="col-sm-12 col-md-7">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-12 col-md-5">
                <canvas id="myChart2" width="400" height="266"></canvas>
            </div>
       </div>
       <div class="row" style="padding-top:50px;  ">
            <div class="col-sm-12 col-md-12 col-lg-4"  style="margin-top:20px">
                <div class="html ui top attached segment" style="width:100%">
                    <div class="ui top attached label">HIGHEST SELLING PRODUCTS</div>
                        <div class="content" style="padding:0px">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Qty Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = "select *,sum(cart_p_QTY) as p_QTY from cart group by cart_p_ID order by p_QTY desc limit 5";
                                $counter = 0;
                                $results = $functions->fetch_rows($functions->query($sql));
                                foreach ($results as $result) {
                                    $counter++;
                                    echo '<tr>
                                    <td>'.$counter.'</td>
                                    <td>'.$result['cart_p_NAME'].'</td>
                                    <td>'.$result['p_QTY'].'</td>
                                </tr>';
                                }
                            ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-4" style="margin-top:20px">
                <div class="html ui top attached segment" style="width:100%">
                    <div class="ui top attached label">LATEST SALES</div>
                        <div class="content" style="padding:0px">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Items</th>
                                    <th>Cost</th>
                                    <th>Sold by</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = "select  *, sum(cart.cart_p_QTY) as cart_p_QTY from orders left join cart on orders.order_id = cart.order_id group by orders.order_id order by orders.order_id  asc limit 5";
                                $counter = 0;
                                $results = $functions->fetch_rows($functions->query($sql));
                                foreach ($results as $result) {
                                    $or_order_id = $invID = 'OD-'.str_pad($result['order_id'], 5, '0', STR_PAD_LEFT);
                                    $counter++;

                                    $sql = "select * from cart where order_id = '".$result['order_id']."' and status = 'returned'";
                                    $fetch = $functions->fetch_rows($functions->query($sql));
                    
                                    if(sizeof($fetch) > 0){
                                       
                                        $returned_items_qty = 0;
                                        $price_of_returned_items = 0;
                                        foreach ($fetch as $item) {
                                            $returned_items_qty = $returned_items_qty + $item['cart_p_QTY'];
                                            $price_of_returned_items = $price_of_returned_items + $item['cart_p_AMOUNT'];
                                        }
                    
                                        //$result['or_net_amount'] = $result['cart_p_AMOUNT'] + $result['or_vat'] - $result['or_discount'] - $price_of_returned_items;
                                        $result['cart_p_QTY'] = $result['cart_p_QTY'] - $returned_items_qty;
                                    }

                                    echo '<tr>
                                    <td>'.$counter.'</td>
                                    <td><a  href="edit_order.php?order='.$result['order_id'].'">'.$or_order_id.'</a></td>
                                    <td>'.$result['cart_p_QTY'].'</td>
                                    <td>¢ '.sprintf('%0.2f',$result['or_net_amount']).'</td>
                                    <td>'.$result['sold_by'].'</td>
                                </tr>';
                                }
                            ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4" style="margin-top:20px">
                <div class="html ui top attached segment" style="width:100%">
                    <div class="ui top attached label">RECENTLY ADDED PRODUCTS</div>
                        <div class="content" style="padding:0px">
                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Price</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = "select * from products order by p_id desc limit 5";
                                $counter = 0;
                                $results = $functions->fetch_rows($functions->query($sql));
                                foreach ($results as $result) {
                                    $counter++;

                                    $aval = '<a class="ui green  label">
                                    Available
                                   </a>';
                   
                   
                                   if(strtoupper($result['p_AVAILABILITY']) == 'NO'){
                                       $aval = '<a class="ui red  label">
                                       NotAvailable
                                      </a>';
                                   }

                                    echo '<tr>
                                    <td>'.$counter.'</td>
                                    <td> <a  href="edit_product.php?id='.base64_encode($result['p_ID']).'">'.$result['p_NAME'].' ' .$aval.'</a></td>
                                    <td>'.$result['p_QTY'].'</td>
                                    <td><a class="ui orange  label">¢ '.sprintf('%0.2f',$result['p_PRICE']).'</a></td>
                                </tr>';
                                }
                            ?>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

            </div>
           
            
                
        </div>
            
    </div>
        <?php else:?>
        <h1 style="margin-top:40px; text-align:center">Welcome <?php echo $_SESSION['user_data']['user_name'] ?>!</h1></center>
    <?php endif?>
</div>

<?php include_once 'includes/layout/footer.php'?>

<script>
var ctx = document.getElementById('myChart');

$.get('includes/fetch_orders_to_dash.php',function(data){
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'Fabruary', 'March', 'April', 'May', 'June','July', 'Auguest', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Amount of sales made per month for this year',
            data: JSON.parse(data),
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
})


var ctx2 = document.getElementById('myChart2');
$.get('includes/fetch_paid_un_paid_orders_to_dash.php',function(data){
    var myChart = new Chart(ctx2, {
    type: 'polarArea',
    data: {
        labels: ['Paid', 'Unpaid'],
        datasets: [{
            label: 'Total amount of paid and unpaid orders for this year',
            data: JSON.parse(data),
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
})


</script>
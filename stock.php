
<?php $title = 'Manage Stock'; ?>
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
            <a class="section">Products</a>
            <div class="divider"> / </div>
            <div class="active section">Manage stock</div>
        </div>
        <div></div>
        

        <div class="ui card">
        <div class="content">
            <div class="header">Products</div>
        </div>
        <div class="content">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product Name</th>
                <th>Model</th>
                <th>Year</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Category</th>
                <th>Availability</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
             $sql = "select * from products where products.p_STATUS != 'deleted' order by p_ID desc";
             $results = $functions->fetch_rows($functions->query($sql));
             foreach ($results as $result) {
 
                 $sql = "select *,sum(cart.cart_p_QTY) as cart_p_QTY from products left join cart on products.p_ID = cart.cart_p_ID where products.p_STATUS != 'deleted' and cart.status = 'active' and products.p_ID = '".$result['p_ID']."'";
                 $fetch = $functions->fetch_rows($functions->query($sql));
 
                 $cart_total = $fetch[0]['cart_p_QTY'];
                 $result['p_QTY'] = $result['p_QTY'] - $cart_total;
                $aval = '<a class="ui green  label">
                 Available
                </a>';

                $low_alert = '';

                if(strtoupper($result['p_AVAILABILITY']) == 'NO'){
                    $aval = '<a class="ui red  label">
                    NotAvailable
                   </a>';
                }

                if($result['p_QTY'] <= $result['p_LOW_ALERT']){
                    $low_alert = '<a class="ui orange  label">
                     Low !
                   </a>';
                }

                $actions  = '';
                $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
                $permissions = $functions->get_user_permission($path);
                if(in_array('update',$permissions)){
                    $actions = ' <input onkeyup="get_key(event,\''.$result['p_ID'].'\')" id="stock_p_new_qty_'.$result['p_ID'].'" type="number" placeholder="QTY" onSubmit="add_stock(\''.$result['p_ID'].'\')">
                    <button class="ui icon button" onclick="add_stock(\''.$result['p_ID'].'\')">
                        <i class="add icon"></i>
                    </button>';
                }

                echo '<tr>
                <td>'.$result['p_SKU'].'</td>
                <td>'.$result['p_NAME'].'</td>
                <td>'.$result['p_MODEL'].'</td>
                <td>'.$result['p_YEAR'].'</td>
                <td>¢ '.sprintf('%0.2f',$result['p_PRICE']).'</td>
                <td id="stock_p_qty_'.$result['p_ID'].'">'.$result['p_QTY'].' '.$low_alert.'</td>
                <td>'.$result['p_CAT'].'</td>
                <td>'.$aval.'</td>
                <td>
                <div class="ui action input">
                    '.$actions.'
                </div>
                </td>
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